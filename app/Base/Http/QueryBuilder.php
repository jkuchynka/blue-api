<?php

namespace Base\Http;

use Base\Http\Filters\FuzzyFilter;
use Base\Http\Support\Http;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\FiltersPartial;
use Spatie\QueryBuilder\QueryBuilder as BaseQueryBuilder;

abstract class QueryBuilder extends BaseQueryBuilder
{
    /**
     * QueryBuilder constructor.
     * Sets up query filters and sorts
     *
     * @param Builder|Relation $builder
     * @param null|Request $request
     */
    public function __construct($builder, ?Request $request = null)
    {
        parent::__construct($builder, $request);

        $this
            ->allowedIncludes($this->includes())
            ->allowedFilters($this->parseFilters())
            ->allowedSorts($this->sorts());
    }

    /**
     * Get parsed filters
     *
     * @return array
     */
    protected function parseFilters()
    {
        $parsed = [];
        $fuzzyFields = [];
        foreach ($this->filters() as $field => $filters) {
            foreach ($filters as $fieldFilter) {
                $filter = Http::getFilter($fieldFilter);
                switch ($filter['key']) {
                    // Exact match
                    case 'eq':
                        $parsed[] = AllowedFilter::exact($field, $field);
                    break;
                    // Greater than
                    case 'gt':
                        $parsed[] = AllowedFilter::callback($field.':gt', function (Builder $query, $value) use ($field) {
                           $query->where($field, '>', $value);
                        });
                    break;
                    // Greater than or equal
                    case 'gte':
                        $parsed[] = AllowedFilter::callback($field.':gte', function (Builder $query, $value) use ($field) {
                           $query->where($field, '>=', $value);
                        });
                    break;
                    // Lesser than
                    case 'lt':
                        $parsed[] = AllowedFilter::callback($field.':lt', function (Builder $query, $value) use ($field) {
                            $query->where($field, '<', $value);
                        });
                    break;
                    // Lesser than or equal
                    case 'lte':
                        $parsed[] = AllowedFilter::callback($field.':lte', function (Builder $query, $value) use ($field) {
                            $query->where($field, '<=', $value);
                        });
                    break;
                    // Has value (empty or non empty)
                    // Eg:
                    // filter[field:has] = true|1 (is empty)
                    // filter[field:has] = false|0 (not empty)
                    case 'has':
                        $parsed[] = AllowedFilter::callback($field.'!', function (Builder $query, $value) use ($field) {
                            $query->where(function (Builder $query) use ($field, $value) {
                                $isRelation = Str::contains($field, '.');
                                if ($isRelation) {
                                    [$relation, $property] = collect(explode('.', $field));
                                }
                                if ($value === false || $value === 'false' || $value === 0 || $value === '0') {
                                    if ($isRelation) {
                                        $query->whereHas($relation);
                                    } else {
                                        $query
                                            ->whereNull($field)
                                            ->orWhere($field, '')
                                            ->orWhere($field, 0);
                                    }
                                } else {
                                    if ($isRelation) {
                                        $query->whereDoesntHave($relation);
                                    } else {
                                        $query
                                            ->whereNotNull($field)
                                            ->where($field, '<>', '')
                                            ->where($field, '<>', 0);
                                    }
                                }
                            });
                        });
                    break;
                    // Fuzzy match, also add field to global fuzzy search
                    case 'like':
                        $parsed[] = AllowedFilter::partial($field.':like', $field);
                        $fuzzyFields[] = $field;
                    break;
                }
            }
        }
        if ($fuzzyFields) {
            $parsed[] = AllowedFilter::custom('like', new FuzzyFilter($fuzzyFields));
        }

        return $parsed;
    }

    /**
     * Get allowed filters
     *
     * @return string[]
     */
    abstract public function filters();

    /**
     * Get allowed includes
     *
     * @return string[]
     */
    abstract public function includes();

    /**
     * Get allowed sorts
     *
     * @return string[]
     */
    abstract public function sorts();
}

<?php

namespace Base\Http;

use Base\Http\Filters\FuzzyFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder as BaseQueryBuilder;

abstract class QueryBuilder extends BaseQueryBuilder
{
    /**
     * Determine whether to include a fuzzy search for all the
     * allowed filters fields.
     *
     * @var bool
     */
    protected $useFuzzy = true;

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

        $filters = $this->filters();
        if ($this->useFuzzy) {
            $filters[] = AllowedFilter::custom('search', new FuzzyFilter($filters));
        }

        $this
            ->allowedFilters($filters)
            ->allowedSorts($this->sorts());
    }

    /**
     * Get allowed filters
     *
     * @return array
     */
    abstract public function filters();

    /**
     * Get allowed sorts
     *
     * @return array
     */
    abstract public function sorts();
}

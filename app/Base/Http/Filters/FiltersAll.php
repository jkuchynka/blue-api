<?php

namespace App\Base\Http\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Does a filter on all allowed filters by "or" matching.
 * Only allows for string filters and does a simple fuzzy "contain" search
 * for each column.
 */
class FiltersAll implements Filter
{
    protected $fields = [];

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $fields = $this->fields;
        $query->where(function ($query) use ($value, $fields) {
            $init = false;
            foreach ($fields as $field) {
                if (is_string($field)) {
                    $expression = '%' . $value . '%';
                    if ( ! $init) {
                        $init = true;
                        $query->where($field, 'LIKE', $expression);
                    } else {
                        $query->orWhere($field, 'LIKE', $expression);
                    }
                }
            }
        });
    }
}

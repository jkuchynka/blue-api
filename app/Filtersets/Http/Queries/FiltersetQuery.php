<?php

namespace App\Filtersets\Http\Queries;

use Base\Http\QueryBuilder;

class FiltersetQuery extends QueryBuilder
{
    /**
     * Get allowed filters
     *
     * @return array
     */
    public function filters()
    {
        return [
            'group' => ['=']
        ];
    }

    /**
     * Get allowed includes
     *
     * @return string[]
     */
    public function includes()
    {
        return [
            'filters'
        ];
    }

    /**
     * Get allowed sorts
     *
     * @return array
     */
    public function sorts()
    {
        return [
            'name'
        ];
    }
}

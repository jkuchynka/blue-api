<?php

namespace App\Users\Http\Queries;

use Base\Http\QueryBuilder;

class UserQuery extends QueryBuilder
{
    /**
     * Get allowed filters
     *
     * @return array
     */
    public function filters()
    {
        return [
            'id',
            'name',
            'email'
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
            'id',
            'name',
            'email'
        ];
    }
}

<?php

namespace App\Users\Http\Queries;

use Base\Http\QueryBuilder;

class UserQuery extends QueryBuilder
{
    /**
     * Get allowed filters
     *
     * @return string[]
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
     * Get allowed includes
     *
     * @return string[]
     */
    public function includes()
    {
        return [
            'permissions',
            'roles'
        ];
    }

    /**
     * Get allowed sorts
     *
     * @return string[]
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

<?php

namespace App\Users\Http\Queries;

use Base\Http\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

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
            'id' => ['=', '>', '>=', '<', '<='],
            'username' => ['*', '=', '!'],
            'name' => ['*', '=', '!'],
            'email' => ['*'],
            'created_at' => ['>', '>=', '<', '<='],
            'updated_at' => ['>', '>=', '<', '<='],
            'roles.id' => ['=', '!']
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
            'username',
            'name',
            'email'
        ];
    }
}

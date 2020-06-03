<?php

namespace App\Messages\Http\Queries;

use Base\Http\QueryBuilder;

class ContactMessageQuery extends QueryBuilder
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
            'subject',
            'message',
            'name',
            'email',
            'created_at'
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
            'subject',
            'name',
            'email',
            'created_at'
        ];
    }
}

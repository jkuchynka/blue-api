<?php

namespace App\Users\Tests\Unit;

use App\Users\Http\Queries\UserQuery;
use App\Users\User;
use Base\Tests\TestCase;

class UserQueryTest extends TestCase
{
    public function test_it_has_filters()
    {
        $query = UserQuery::for(User::class);
        $this->assertEquals([
            'id',
            'name',
            'email'
        ], $query->filters());
    }

    public function test_it_has_sorts()
    {
        $query = UserQuery::for(User::class);
        $this->assertEquals([
            'id',
            'name',
            'email'
        ], $query->sorts());
    }
}

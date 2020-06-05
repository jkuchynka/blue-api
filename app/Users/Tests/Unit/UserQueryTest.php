<?php

namespace App\Users\Tests\Unit;

use App\Users\Http\Queries\UserQuery;
use App\Users\Models\User;
use Base\Tests\TestCase;

class UserQueryTest extends TestCase
{
    protected $query;

    protected function beforeTest()
    {
        $this->query = UserQuery::for(User::class);
    }

    public function test_it_has_filters()
    {
        $this->assertEquals([
            'id',
            'name',
            'email'
        ], $this->query->filters());
    }

    public function test_it_has_includes()
    {
        $this->assertEquals([
            'permissions',
            'roles'
        ], $this->query->includes());
    }

    public function test_it_has_sorts()
    {
        $this->assertEquals([
            'id',
            'name',
            'email'
        ], $this->query->sorts());
    }
}

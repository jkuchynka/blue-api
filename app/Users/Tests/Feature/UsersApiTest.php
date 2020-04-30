<?php

namespace App\Users\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Users\User;

class UsersApiTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsersReturnsAll()
    {
        $headers = [];
        $users = factory(User::class, 3)->create();
        $response = $this->json('GET', '/api/users', [], $headers)
            ->assertStatus(200)
            // Records should be in data
            ->assertJsonPath('data.0.id', $users[0]->id)
            ->assertJsonPath('data.1.name', $users[1]->name)
            ->assertJsonPath('data.2.email', $users[2]->email);
    }

    public function _testGetUsersFilters()
    {

    }

    public function _testGetUsersSorts()
    {

    }
}

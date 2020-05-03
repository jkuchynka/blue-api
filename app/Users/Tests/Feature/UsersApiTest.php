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

    public function testGetUsersFilterField()
    {
        $user = factory(User::class)->create([
            'name' => 'Foobar',
            'email' => 'test1@mail.net'
        ]);
        $user2 = factory(User::class)->create([
            'name' => 'Bazqux',
            'email' => 'test2@mail.net'
        ]);
        $response = $this->json('GET', '/api/users?filter[name]=qux');
        $response
            ->assertJsonPath('data.0.name', 'Bazqux')
            ->assertJsonPath('total', 1);
        $response = $this->json('GET', '/api/users?filter[email]=test1');
        $response
            ->assertJsonPath('data.0.name', 'Foobar')
            ->assertJsonPath('total', 1);
        $response = $this->json('GET', '/api/users?filter[name]=snoopy')
            ->assertJsonPath('data', [])
            ->assertJsonPath('total', 0);
    }

    public function testGetUsersSearchFields()
    {
        $user = factory(User::class)->create([
            'name' => 'Foobar',
            'email' => 'test1@mail.net'
        ]);
        $user2 = factory(User::class)->create([
            'name' => 'Bazqux',
            'email' => 'test2@mail.net'
        ]);
        $response = $this->json('GET', '/api/users?filter[all]=bar');
        $this->debugJson($response);
        $response
            ->assertJsonPath('data.0.name', 'Foobar')
            ->assertJsonPath('total', 1);
    }

    public function _testGetUsersSorts()
    {

    }
}

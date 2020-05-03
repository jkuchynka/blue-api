<?php

namespace App\Users\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Base\Tests\TestCase;
use App\Users\User;

class UsersApiTest extends TestCase
{
    use RefreshDatabase;

    protected $users = [];

    protected function beforeTest()
    {
        $this->users[] = factory(User::class)->create([
            'name' => 'donald',
            'email' => 'donald.duck@mail.net'
        ]);
        $this->users[] = factory(User::class)->create([
            'name' => 'duey',
            'email' => 'quack@gmail.com'
        ]);
        $this->users[] = factory(User::class)->create([
            'name' => 'scrooge',
            'email' => 'moneybags@example.org'
        ]);
    }

    public function testGetUsersReturnsAll()
    {
        $response = $this->json('GET', '/api/users')
            ->assertStatus(200)
            // Records should be in data
            ->assertJsonPath('data.0.id', $this->users[0]->id)
            ->assertJsonPath('data.1.name', $this->users[1]->name)
            ->assertJsonPath('data.2.email', $this->users[2]->email);
    }

    public function testGetUsersFilterField()
    {
        $response = $this->json('GET', '/api/users?filter[name]=donald');
        $response
            ->assertJsonPath('data.0.name', 'donald')
            ->assertJsonPath('total', 1);
        $response = $this->json('GET', '/api/users?filter[email]=quack');
        $response
            ->assertJsonPath('data.0.name', 'duey')
            ->assertJsonPath('total', 1);
        $response = $this->json('GET', '/api/users?filter[name]=foobar')
            ->assertJsonPath('data', [])
            ->assertJsonPath('total', 0);
    }

    public function testGetUsersSearchFields()
    {
        $response = $this->json('GET', '/api/users?filter[all]=duck');
        $response
            ->assertJsonPath('data.0.name', 'donald')
            ->assertJsonPath('total', 1);
        $response = $this->json('GET', '/api/users?filter[all]=roo');
        $response
            ->assertJsonPath('data.0.name', 'scrooge')
            ->assertJsonPath('total', 1);
    }

    public function testGetUsersSorts()
    {
        $response = $this->json('GET', '/api/users?sort=email');
        $response
            ->assertJsonPath('data.0.name', 'donald')
            ->assertJsonPath('data.1.name', 'scrooge')
            ->assertJsonPath('data.2.name', 'duey');
        $response = $this->json('GET', '/api/users?sort=-email');
        $response
            ->assertJsonPath('data.0.name', 'duey')
            ->assertJsonPath('data.1.name', 'scrooge')
            ->assertJsonPath('data.2.name', 'donald');
    }
}

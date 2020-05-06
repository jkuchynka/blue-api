<?php

namespace App\Users\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Base\Tests\TestCase;
use App\Users\User;

class UsersApiTest extends TestCase
{
    use RefreshDatabase;

    protected $loadModules = ['users'];

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

    public function test_users_index_returns_all()
    {
        $response = $this->json('GET', '/api/users')
            ->assertStatus(200)
            // Records should be in data
            ->assertJsonPath('data.0.id', $this->users[0]->id)
            ->assertJsonPath('data.1.name', $this->users[1]->name)
            ->assertJsonPath('data.2.email', $this->users[2]->email);
    }

    public function test_users_index_filters_fields()
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

    public function test_users_index_searches_fields()
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

    public function test_users_index_sorts()
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

    public function test_users_index_paginates()
    {
        $response = $this->json('get', route('users.index'), [
            'page' => [
                'size' => 2
            ]
        ]);
        $this->assertCount(2, $response->json('data'));
        $response->assertJsonPath('total', 3);
    }

    public function test_users_stores_new_user()
    {
        $response = $this->json('post', route('users.store'), [
            'name' => 'foo',
            'email' => 'bar@mail.net'
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonPath('name', 'foo');
    }

    public function test_users_updates_user()
    {
        $response = $this->json('put', route('users.update', ['user' => $this->users[0]]), [
            'params' => [
                'name' => 'foobar'
            ]
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonPath('name', 'foobar');
    }
}

<?php

namespace App\Users\Tests\Feature;

use App\Users\Models\User;
use App\Users\Http\Controllers\UserController;
use App\Users\Http\Queries\UserQuery;
use Base\Tests\TestCase;
use Base\Tests\Traits\TestsApi;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * API feature resource test
 */
class UsersApiTest extends TestCase
{
    use RefreshDatabase,
        TestsApi;

    /**
     * Ensure this test only loads these modules and their
     * dependencies
     *
     * @type array
     */
    protected $loadModules = ['users'];

    /**
     * Return the fields that should be in responses
     *
     * @return array
     */
    protected function responseFields()
    {
        return [
            'id',
            'username',
            'name',
            'email',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Return the controller under test
     *
     * @return string
     */
    protected function controller()
    {
        return UserController::class;
    }

    /**
     * Return the model under test
     *
     * @return string
     */
    protected function model()
    {
        return User::class;
    }

    /**
     * Return the query builder under test
     *
     * @return UserQuery
     */
    protected function queryBuilder()
    {
        return UserQuery::for(User::class);
    }

    /**
     * Test the basic index api
     */
    public function test_index()
    {
        $this->assertApiIndex('users.index');
    }

    /**
     * Test that the index api filters correct fields
     */
    public function test_index_filters_fields()
    {
        $this->assertApiIndexFilters('users.index');
    }

    /**
     * Test that the index api searches across fields
     */
    public function test_index_searches_fields()
    {
        $this->assertApiIndexSearches('users.index');
    }

    /**
     * Test that the index api sorts fields
     */
    public function test_index_sorts_by_fields()
    {
        $this->assertApiIndexSorts('users.index');
    }

    /**
     * Test that the index api paginates fields
     */
    public function test_index_paginates_fields()
    {
        $this->assertApiIndexPaginates('users.index');
    }

    /**
     * Test that the store api successfully creates record.
     */
    public function test_store_success()
    {
        $this->assertApiStoreSuccess('users.store');
    }

    /**
     * Test that the show api successfully returns record.
     */
    public function test_show()
    {
        $this->assertApiShow('users.show');
    }

    public function test_show_by_username()
    {
        $user = factory(User::class)->create();
        $route = route('users.show', [
            $this->routeParam() => $user->username
        ]);
        $response = $this->getJson($route);
        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', $user->id);
    }

    /**
     * Test that the show api returns 404 if record not found.
     */
    public function test_show_returns_404()
    {
        $this->assertApiShow404('users.show');
    }

    /**
     * Test that the update api successfully updates record.
     */
    public function test_update_success()
    {
        $this->assertApiUpdateSuccess('users.update', 'email', 'foobar@mail.net');
    }

    /**
     * Test that the destroy api successfully deletes record.
     */
    public function test_delete_success()
    {
        $this->assertApiDestroySuccess('users.destroy', true);
    }
}

<?php

namespace App\Users\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Base\Tests\TestCase;
use Base\Tests\Traits\ProvidesController;
use Base\Tests\Traits\ProvidesModel;
use App\Users\UsersController;
use App\Users\User;

/**
 * API feature resource test
 */
class UsersApiTest extends TestCase
{
    use RefreshDatabase,
        ProvidesController,
        ProvidesModel;

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
            'name',
            'email',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Return the controller under test
     *
     * @return string|Base\Http\Controller
     */
    protected function controller()
    {
        return UsersController::class;
    }

    /**
     * Return the model under test
     *
     * @return Model
     */
    protected function model()
    {
        return User::class;
    }

    /**
     * Test the basic index api
     */
    public function test_index()
    {
        $route = 'users.index';

        $this->assertApiIndex($route, $this->getModel(), $this->responseFields());
    }

    /**
     * Test that the index api filters correct fields
     */
    public function test_index_filters_fields()
    {
        $route = 'users.index';

        $this->assertApiIndexFilters($route, $this->getModel(), $this->getController());
    }

    /**
     * Test that the index api searches across fields
     */
    public function test_index_searches_fields()
    {
        $route = 'users.index';

        $this->assertApiIndexSearches($route, $this->getModel(), $this->getController());
    }

    /**
     * Test that the index api sorts fields
     */
    public function test_index_sorts_by_fields()
    {
        $route = 'users.index';

        $this->assertApiIndexSorts($route, $this->getModel(), $this->getController());
    }

    /**
     * Test that the index api paginates fields
     */
    public function test_index_paginates_fields()
    {
        $route = 'users.index';

        $this->assertApiIndexPaginates($route, $this->getModel(), $this->getController());
    }

    /**
     * Test that the store api returns a validation
     * errors response with an invalid field.
     */
    public function test_store_validates()
    {
        $route = 'users.store';
        $invalidField = 'email';

        $this->assertApiStoreValidates($route, $invalidField, $this->getModel());
    }

    /**
     * Test that the store api successfully creates record.
     */
    public function test_store_success()
    {
        $route = 'users.store';

        $this->assertApiStoreSuccess($route, $this->getModel(), $this->responseFields());
    }

    /**
     * Test that the show api successfully returns record.
     */
    public function test_show()
    {
        $route = 'users.show';

        $this->assertApiShow($route, $this->getModel(), $this->responseFields());
    }

    /**
     * Test that the show api returns 404 if record not found.
     */
    public function test_show_returns_404()
    {
        $route = 'users.show';

        $this->assertApiShow404($route, $this->getModel());
    }

    /**
     * Test that the update api returns a validation
     * errors response with an invalid field.
     */
    public function test_update_validates()
    {
        $route = 'users.update';
        $field = 'name';
        $value = '';

        $this->assertApiUpdateValidates($route, $this->getModel(), $field, $value);
    }

    /**
     * Test that the update api successfully updates record.
     */
    public function test_update_success()
    {
        $route = 'users.update';
        $field = 'email';
        $value = 'foobar@mail.net';

        $this->assertApiUpdateSuccess($route, $this->getModel(), $field, $value);
    }

    /**
     * Test that the destroy api successfully deletes record.
     */
    public function test_delete_success()
    {
        $route = 'users.destroy';
        $softDeletes = true;

        $this->assertApiDestroySuccess($route, $this->getModel(), $softDeletes);
    }
}

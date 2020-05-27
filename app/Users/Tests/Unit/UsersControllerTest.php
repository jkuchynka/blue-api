<?php

namespace App\Users\Tests\Unit;

use App\Auth\AuthController;
use App\Auth\Requests\LoginRequest;
use Base\Tests\TestCase;
use Base\Tests\Traits\ProvidesController;
use App\Users\UsersController;

/**
 * Unit test for UsersController
 */
class UsersTest extends TestCase
{
    use ProvidesController;

    /**
     * Set the controller under test
     *
     * @return string|Base\Http\Controller
     */
    protected function controller()
    {
        return UsersController::class;
    }

    /**
     * Return validation rules
     *
     * @param  bool|boolean $update If true, returns update rules
     * @return array
     */
    protected function rules(bool $update = false)
    {
        return [
            'email' => 'required|email',
            'name' => 'required'
        ];
    }

    /**
     * Return allowed filters for index query
     *
     * @return array
     */
    protected function filters()
    {
        return [
            'id',
            'name',
            'email'
        ];
    }

    /**
     * Return allowed sorts for index query
     *
     * @return array
     */
    protected function sorts()
    {
        return [
            'id',
            'name',
            'email'
        ];
    }

    public function test_store_validates_using_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            UserController::class,
            'store',
            UserStoreRequest::class
        );
    }

    public function test_update_validates_using_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            UserController::class,
            'update',
            UserUpdateRequest::class
        );
    }

    /**
     * Test the controller provides and matches allowed filters
     * for the index query
     */
    public function test_controller_has_filters()
    {
        $this->assertControllerHasFilters($this->filters(), $this->getController());
    }

    /**
     * Test the controller provides and matches allowed sorts
     * for the index query
     */
    public function test_controller_has_sorts()
    {
        $this->assertControllerHasSorts($this->sorts(), $this->getController());
    }
}

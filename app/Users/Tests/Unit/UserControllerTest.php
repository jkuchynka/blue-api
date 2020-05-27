<?php

namespace App\Users\Tests\Unit;

use App\Users\Http\Requests\UserUpdateRequest;
use App\Users\Http\Requests\UserStoreRequest;
use App\Users\Http\Controllers\UserController;
use Base\Tests\TestCase;

/**
 * Unit test for UserController
 */
class UserControllerTest extends TestCase
{
    public function test_store_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(
            UserController::class,
            'store',
            UserStoreRequest::class
        );
    }

    public function test_update_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(
            UserController::class,
            'update',
            UserUpdateRequest::class
        );
    }
}

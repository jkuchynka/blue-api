<?php

namespace App\Users\Tests\Unit;

use App\Users\Requests\UserUpdateRequest;
use App\Users\Requests\UserStoreRequest;
use App\Users\UsersController;
use Base\Tests\TestCase;

/**
 * Unit test for UsersController
 */
class UsersControllerTest extends TestCase
{
    public function test_store_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(
            UsersController::class,
            'store',
            UserStoreRequest::class
        );
    }

    public function test_update_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(
            UsersController::class,
            'update',
            UserUpdateRequest::class
        );
    }
}

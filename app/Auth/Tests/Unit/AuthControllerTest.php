<?php

namespace App\Auth\Tests\Unit;

use App\Auth\AuthController;
use App\Auth\Requests\LoginRequest;
use App\Auth\Requests\RegisterRequest;
use Base\Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_validates_using_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            AuthController::class,
            'login',
            LoginRequest::class
        );
    }

    public function test_register_validates_using_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            AuthController::class,
            'register',
            RegisterRequest::class
        );
    }
}

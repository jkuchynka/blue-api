<?php

namespace App\Auth\Tests\Unit;

use App\Auth\Requests\LoginRequest;
use App\Auth\Requests\RegisterRequest;
use App\Auth\Requests\SendResetPasswordRequest;
use App\Auth\Requests\ResetPasswordRequest;
use App\Auth\Requests\ValidateVerifyRequest;
use Base\Rules\SignedUrl;
use Base\Tests\TestCase;

class AuthRequestsTest extends TestCase
{
    public function test_login_request()
    {
        $request = new LoginRequest;

        $this->assertEquals([
            'email' => 'required|email',
            'password' => 'required'
        ], $request->rules());

        $this->assertTrue($request->authorize());
    }

    public function test_register_request()
    {
        $request = new RegisterRequest;

        $this->assertEquals([
            'email' => 'required|email|unique:users'
        ], $request->rules());

        $this->assertTrue($request->authorize());
    }

    public function test_send_reset_password_request()
    {
        $request = new SendResetPasswordRequest;

        $this->assertEquals([
            'email' => 'required|email'
        ], $request->rules());

        $this->assertTrue($request->authorize());
    }

    public function test_reset_password_request()
    {
        $request = new ResetPasswordRequest;

        $this->assertEquals([
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'url' => ['required', new SignedUrl]
        ], $request->rules());

        $this->assertTrue($request->authorize());
    }

    public function test_validate_verify_request()
    {
        $request = new ValidateVerifyRequest;

        $this->assertEquals([
            'url' => ['required', new SignedUrl]
        ], $request->rules());

        $this->assertTrue($request->authorize());
    }
}

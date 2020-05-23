<?php

namespace App\Auth\Tests\Feature;

use App\Auth\Mail\ResetPassword;
use App\Auth\Mail\VerifyEmail;
use App\Users\User;
use Base\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected $loadModules = ['auth'];

    public function test_login()
    {
        $user = factory(User::class)->create();
        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'user' => true,
            'token' => true
        ]);
    }

    /**
     * @todo: fixme
     */
    public function _test_logout()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = $response['token'];

        $this->getJson(route('auth.logout'), [
            'Authentication' => 'Bearer '.$token
        ]);

        $response = $this->getJson(route('auth.status'), [
            'Authentication' => 'Bearer '.$token
        ]);

        $response
            ->assertJsonPath('data.id', null);
    }

    public function test_register()
    {
        Mail::fake();

        $user = factory(User::class)->make();
        $response = $this->postJson(route('auth.register'), [
            'email' => $user->email
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => true
            ]);

        Mail::assertSent(VerifyEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_send_reset_password()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $response = $this->postJson(route('auth.sendResetPassword'), [
            'email' => $user->email
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => true
            ]);

        Mail::assertSent(ResetPassword::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_reset_password()
    {
        $user = factory(User::class)->create();

        $verify = new ResetPassword($user);
        $view = $verify->build();
        $url = $view->viewData['verifyUrl'];

        $response = $this->putJson(route('auth.resetPassword'), [
            'url' => $url,
            'password' => 'foobar123',
            'password_confirm' => 'foobar123'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => true
            ]);

        $user = User::where('id', $user->id)->first();

        $this->assertTrue(Hash::check('foobar123', $user->password));
    }

    public function test_verify()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);

        $verify = new ResetPassword($user);
        $view = $verify->build();
        $url = $view->viewData['verifyUrl'];

        $response = $this->putJson(route('auth.resetPassword'), [
            'url' => $url,
            'password' => 'foobar123',
            'password_confirm' => 'foobar123'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => true
            ]);

        $user = User::where('id', $user->id)->first();

        $this->assertTrue(Hash::check('foobar123', $user->password));
        $this->assertNotEmpty($user->email_verified_at);
    }

    public function test_validate_verify()
    {
        $user = factory(User::class)->create();

        $verify = new ResetPassword($user);
        $view = $verify->build();
        $url = $view->viewData['verifyUrl'];

        $response = $this->postJson(route('auth.validateVerify'), [
            'url' => $url
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => true
            ]);
    }

    public function test_status_not_logged_in()
    {
        $response = $this->getJson(route('auth.status'));

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', null);
    }

    /**
     * @todo: fixme
     */
    public function _test_status_logged_in()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = $response['token'];

        $response = $this->getJson(route('auth.status'), [
            'Authentication' => 'Bearer '.$token
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', $user->id);
    }
}

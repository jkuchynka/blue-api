<?php

namespace App\Auth\Tests\Feature;

use App\Auth\Mail\ResetPassword;
use App\Auth\Mail\VerifyEmail;
use App\Auth\Models\Role;
use App\Auth\Models\Permission;
use App\Users\Models\User;
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

        $role = Role::create([
            'name' => 'test-role'
        ]);
        $permission = Permission::create([
            'name' => 'test-permission'
        ]);
        $role->attachPermission($permission);
        $user->attachRole('test-role');

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id'
            ],
            'meta' => [
                'permissions',
                'roles',
                'token'
            ]
        ]);
        $response->assertJsonPath('meta.roles', ['test-role']);
        $response->assertJsonPath('meta.permissions', ['test-permission']);
        $this->assertNotEmpty($response->json()['meta']['token']);
        $this->assertIsString($response->json()['meta']['token']);
    }

    public function test_logout()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);
        $headers = ['Authorization' => 'Bearer '.$token];

        $response = $this->getJson(route('auth.logout'), $headers);
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => true
            ]);

        $response = $this->getJson(route('auth.status'), $headers);

        $response
            ->assertJsonPath('data.id', null);
    }

    public function test_refresh()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $response = $this->postJson(route('auth.refresh'), [], [
            'Authorization' => 'Bearer '.$token
        ]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json()['meta']['token']);
        $this->assertIsString($response->json()['meta']['token']);
        $this->assertNotEquals($token, $response->json()['meta']['token']);
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

    public function test_update_password()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('secret123')
        ]);

        $this->asUser($user);

        $response = $this->putJson(route('auth.updatePassword'), [
            'current_password' => 'secret123',
            'password' => 'password321',
            'password_confirm' => 'password321'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => true
            ]);

        $user = User::where('id', $user->id)->first();

        $this->assertTrue(Hash::check('password321', $user->password));
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

    public function test_status_logged_in()
    {
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $role = Role::create([
            'name' => 'test-role'
        ]);
        $permission = Permission::create([
            'name' => 'test-permission'
        ]);
        $role->attachPermission($permission);
        $user->attachRole('test-role');

        $response = $this->getJson(route('auth.status'), [
            'Authorization' => 'Bearer '.$token
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id'
            ],
            'meta' => [
                'permissions',
                'roles'
            ]
        ]);
        $response->assertJsonPath('meta.roles', ['test-role']);
        $response->assertJsonPath('meta.permissions', ['test-permission']);
    }
}

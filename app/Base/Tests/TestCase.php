<?php

namespace Base\Tests;

use App\Users\Models\User;
use Base\Modules\ModulesService;
use Illuminate\Routing\Middleware\ThrottleRequests;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        AdditionalAssertions;

    protected $loadModules = [];

    protected $user;

    /**
     * Runs before each test
     * @return void
     */
    protected function beforeTest()
    {

    }

    /**
     * Runs before each test
     * @return void
     */
    protected function setUp(): void
    {
        // Only load specific modules before app is setup,
        // otherwise tests will use normal app config
        if ( ! empty($this->loadModules)) {
            ModulesService::setEnabledModules($this->loadModules);
        }
        parent::setUp();
        $this->user = null;
        $this->withoutMiddleware(ThrottleRequests::class);
        $this->beforeTest();
    }

    /**
     * Execute test as a user
     *
     * @param User $user
     */
    protected function asUser(User $user)
    {
        $this->user = $user;
        $this->actingAs($user);
    }

    /**
     * Create a user with an assigned role, and execute test as this user
     *
     * @param string $role
     */
    protected function asUserByRole($role)
    {
        $user = factory(User::class)->create();
        $user->attachRoles([$role]);
        $this->asUser($user);
    }
}

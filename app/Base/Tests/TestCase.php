<?php

namespace Base\Tests;

use Base\Modules\ModulesService;
use Base\Providers\ModuleServiceProvider;
use Illuminate\Routing\Middleware\ThrottleRequests;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        AdditionalAssertions;

    protected $loadModules = [];

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
        $this->withoutMiddleware(ThrottleRequests::class);
        $this->beforeTest();
    }
}

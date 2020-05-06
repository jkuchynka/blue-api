<?php

namespace Base\Tests;

use Illuminate\Container\Container;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Base\Services\Modules;
use Base\Providers\ModuleServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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
        // Ensure loaded modules before app is setup
        if ($this->loadModules) {
            Modules::setEnabledModules($this->loadModules);
        }
        parent::setUp();
        $this->beforeTest();

    }

    /**
     * Output json response
     * @param  Response $response
     * @return void
     */
    protected function debugJson($response)
    {
        print_r(json_decode($response->content(), true));
    }
}

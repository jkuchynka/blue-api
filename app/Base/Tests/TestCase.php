<?php

namespace Base\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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

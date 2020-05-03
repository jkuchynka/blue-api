<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function debugJson($response)
    {
        print_r(json_decode($response->content(), true));
    }
}

<?php

namespace Base\Tests\Unit\Http\Support;

use Base\Http\Support\Http;
use Base\Tests\TestCase;

class HttpTest extends TestCase
{
    public function test_get_filter_by_type()
    {
        $this->assertEquals('=', Http::getFilter('eq')['alias']);
    }

    public function test_get_filter_by_alias()
    {
        $this->assertEquals('=', Http::getFilter('=')['alias']);
    }

    public function test_get_filter_map()
    {
        $map = Http::getFilterMap();
        $this->assertEquals('eq', $map['eq']['key']);
        $this->assertEquals('eq', $map['=']['key']);
    }
}

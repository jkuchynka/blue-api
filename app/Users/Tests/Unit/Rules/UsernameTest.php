<?php

namespace App\Users\Tests\Unit\Rules;

use App\Users\Rules\Username;
use Base\Tests\TestCase;

class UsernameTest extends TestCase
{
    protected $min = 5;

    protected $max = 24;

    protected function passes($value)
    {
        $rule = new Username;
        return $rule->passes('username', $value);
    }

    public function test_fails()
    {
        $this->assertFalse($this->passes(''));
        $this->assertFalse($this->passes('foo'));
        $this->assertFalse($this->passes('foo-bar'));
        $this->assertFalse($this->passes('foobar$'));
        $this->assertFalse($this->passes(str_repeat('a', $this->max + 1)));
    }

    public function test_passes()
    {
        $this->assertTrue($this->passes('fooba'));
        $this->assertTrue($this->passes('foobar_123'));
        $this->assertTrue($this->passes(str_repeat('a', $this->max)));
    }

    public function test_message()
    {
        $rule = new Username;
        $this->assertStringContainsString($this->min, $rule->message());
        $this->assertStringContainsString($this->max, $rule->message());
    }
}

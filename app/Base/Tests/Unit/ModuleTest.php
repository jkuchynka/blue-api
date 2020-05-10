<?php

namespace Base\Tests\Unit;

use Base\Modules\Module;

class ModuleTest extends \Base\Tests\TestCase
{
    protected $loadModules = ['base'];

    public function test_set_default_config()
    {
        $module = new Module;
        $ret = $module->setDefaultConfig('foo_bar');

        $this->assertInstanceOf(Module::class, $ret);

        $this->assertEquals('Database/Migrations', $module['paths.migrations']);
        $this->assertEquals('foo_bar', $module['key']);
        $this->assertEquals('FooBar', $module['name']);
        $this->assertEquals('App\\FooBar', $module['namespace']);

        $module->setDefaultConfig('base');
        $this->assertEquals('Base', $module['namespace']);
    }
}

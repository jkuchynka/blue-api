<?php

namespace Base\Tests\Unit;

use Adbar\Dot;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Yaml\Yaml;
use org\bovigo\vfs\vfsStream;
use Base\Services\Modules;

class ModulesTest extends \Base\Tests\TestCase
{
    protected $loadModules = ['base'];

    public function test_get_enabled_modules()
    {
        $modules = new Modules;
        $enabled = $modules->getEnabledModules();
        $this->assertEquals(['base'], $enabled);
        $modules->loadModules($enabled);
        $config = $modules->getModules();
        $this->assertIsArray($config);
        $this->assertInstanceOf(Dot::class, $config['base']);
    }

    public function test_get_module_config_default()
    {
        $modules = new Modules;
        $config = $modules->moduleConfigDefault('foo_bar');
        $this->assertIsArray($config);
        $this->assertEquals('Database/Migrations', $config['paths']['migrations']);
        $this->assertEquals('foo_bar', $config['key']);
        $this->assertEquals('FooBar', $config['name']);
        $this->assertStringContainsString('FooBar', $config['paths']['module']);
        $this->assertEquals('App\\FooBar', $config['namespace']);

        $config = $modules->moduleConfigDefault('base');
        $this->assertEquals('Base', $config['namespace']);
    }

    public function test_get_modules_path()
    {
        // Default
        $modules = new Modules();
        $this->assertEquals(base_path() . '/app', $modules->getModulesPath());

        $options = [
            ['modules', base_path() . '/modules'],
            ['/modules', '/modules'],
            ['vfs://root/modules', 'vfs://root/modules']
        ];
        foreach ($options as $option) {
            $repo = new Repository([
                'modules' => [
                    'modulesPath' => $option[0]
                ]
            ]);
            $modules = new Modules($repo);
            $this->assertEquals($option[1], $modules->getModulesPath());
        }
    }

    public function test_load_modules()
    {
        $repo = new Repository([
            'modules' => [
                'modules' => [
                    'foo' => [],
                    'bar' => [],
                    'baz' => []
                ]
            ]
        ]);
        $modules = new Modules($repo);
        $modules->loadModules(['foo', 'bar', 'baz']);
        $config = $modules->getModules();

        $this->assertEquals('foo', $config['foo']['key']);
        $this->assertEquals('Bar', $config['bar']['name']);
        $this->assertEquals('App\\Baz', $config['baz']['namespace']);
    }

    public function test_load_modules_with_yaml_config()
    {
        $root = vfsStream::setup();
        $repo = new Repository([
            'modules' => [
                'modules' => [
                    'foo' => [
                        'paths' => [
                            'module' => $root->url()
                        ]
                    ]
                ]
            ]
        ]);
        vfsStream::newFile('foo.config.yml')
            ->withContent('
version: 123
description: foobar
paths:
    migrations: db-migrations
                ')
            ->at($root);
        $modules = new Modules($repo);
        $modules->loadModules(['foo']);
        $foo = $modules->getModule('foo');
        $this->assertEquals('123', $foo['version']);
        $this->assertEquals('foobar', $foo['description']);
        $this->assertEquals('db-migrations', $foo['paths.migrations']);
    }

    public function test_load_modules_with_app_config()
    {
        $root = vfsStream::setup();
        $repo = new Repository([
            'modules' => [
                'modules' => [
                    'foo' => [
                        'version' => '123.123',
                        'paths' => [
                            'module' => $root->url(),
                            'migrations' => 'Database',
                            'controllers' => 'CTRL'
                        ]
                    ]
                ]
            ]
        ]);
        vfsStream::newFile('foo.config.yml')
            ->withContent('
version: 123
description: foobar
paths:
    migrations: db-migrations
                ')
            ->at($root);
        $modules = new Modules($repo);
        $modules->loadModules(['foo']);
        $foo = $modules->getModule('foo');
        $this->assertEquals('123.123', $foo['version']);
        $this->assertEquals('Database', $foo['paths.migrations']);
        $this->assertEquals('CTRL', $foo['paths.controllers']);
    }

    public function test_load_module_routes_from_yaml()
    {
        $yaml = '
routes:
    -
        route: foo
        method: get
        controller: FooController
';
        $root = vfsStream::setup('root', null, [
            'Foo' => [
                'foo.config.yml' => $yaml
            ]
        ]);
        $repo = new Repository([
            'modules' => [
                'modulesPath' => $root->url(),
                'modules' => [
                    'foo' => []
                ]
            ]
        ]);

        $modules = new Modules($repo);
        $modules->loadModules(['foo']);

        $foo = $modules->getModule('foo');
        $this->assertEquals('foo', $foo['routes.0.route']);
    }

    public function test_load_module_dependencies()
    {
        $repo = new Repository([
            'modules' => [
                'modules' => [
                    'foo' => [
                        'dependsOn' => ['bar']
                    ]
                ]
            ]
        ]);
        $modules = new Modules($repo);
        $modules->loadModules(['foo']);
        $config = $modules->getModules();
        $this->assertInstanceOf(Dot::class, $config['bar']);
    }

    public function _test_route_collision_throws_exception()
    {

    }
}

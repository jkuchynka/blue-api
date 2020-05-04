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

    protected function beforeTest()
    {
        // $this->modules = $this->createStub(Modules::class);
        // $this->modules->method('get_')
    }

    public function test_get_enabled_modules()
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
        $this->assertEquals(['foo', 'bar', 'baz'], $modules->getEnabledModules());
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
        $modules->loadModules();
        $config = $modules->getModules();
        $this->assertInstanceOf(Dot::class, $config);
        $this->assertEquals('foo', $config['foo.key']);
        $this->assertEquals('Bar', $config['bar.name']);
        $this->assertEquals('App\\Baz', $config['baz.namespace']);
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
        $modules->loadModules();
        $config = $modules->getModules();
        $this->assertEquals('123', $config['foo.version']);
        $this->assertEquals('foobar', $config['foo.description']);
        $this->assertEquals('db-migrations', $config['foo.paths.migrations']);
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
        $modules->loadModules();
        $config = $modules->getModules();
        $this->assertEquals('123.123', $config['foo.version']);
        $this->assertEquals('Database', $config['foo.paths.migrations']);
        $this->assertEquals('CTRL', $config['foo.paths.controllers']);
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
        $modules->loadModules();

        // Route is only in module config
        $config = $modules->getModules();
        $this->assertEquals('foo', $config['foo.routes.0.route']);

        // $routeCollection = Route::getRoutes();

        // // Adds prefix
        // $route = $routeCollection->getByName('base.testing');
        // $this->assertEquals('base/testing', $route->uri());

        // // Base API route GET /
        // $route = $routeCollection->getByName('base.index');
        // $this->assertEquals('/', $route->uri());
        // $response = $this->json('GET', '/');
        // $response->assertStatus(200);
    }

    public function _test_route_collision_throws_exception()
    {

    }
}

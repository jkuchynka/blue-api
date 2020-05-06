<?php

namespace Blue\Tests\Unit;

use Adbar\Dot;
use Illuminate\Support\Facades\Route;
use Base\Exceptions\InvalidRouteException;
use Base\Providers\RouteServiceProvider;
use Base\Services\Modules;
use Base\Services\Routes;

class RoutingTest extends \Base\Tests\TestCase
{
    protected $loadModules = ['base'];

    protected function setUp(): void
    {
        // Disable loading module routes
        RouteServiceProvider::setLoadRoutes(false);
        parent::setUp();
        // Re-enable route loading
        RouteServiceProvider::setLoadRoutes(true);
    }

    public function test_routes_config_route_sets_uri()
    {
        $modules = new Modules;
        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $routes = new Routes;

        $options = [
            [['uri' => ''], 'foo'],
            [['uri' => 'bar'], 'foo/bar'],
            [['uri' => '/bar'], '/bar'],
            [['uri' => 'bar/baz/qux'], 'foo/bar/baz/qux']
        ];

        foreach ($options as $option) {
            $route = $routes->routeConfig($option[0], $foo);
            $this->assertEquals($option[1], $route['uri']);
        }
    }

    public function test_routes_config_route_sets_method()
    {
        $modules = new Modules;
        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $routes = new Routes;

        $options = [
            [['uri' => ''], 'get'],
            [['uri' => '', 'method' => 'get'], 'get'],
            [['uri' => '', 'method' => 'GET'], 'get'],
            [['uri' => '', 'method' => 'post'], 'post']
        ];

        foreach ($options as $option) {
            $route = $routes->routeConfig($option[0], $foo);
            $this->assertEquals($option[1], $route['method']);
        }
    }

    public function test_routes_config_route_sets_uses()
    {
        $modules = new Modules;
        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $routes = new Routes;

        $options = [
            [['uri' => '', 'uses' => 'FooBarController@test'], 'App\\Foo\\Http\\Controllers\\FooBarController@test'],
            [['uri' => '', 'uses' => 'test'], 'App\\Foo\\Http\\Controllers\\FooController@test'],
            [['uri' => 'foo/bar'], 'App\\Foo\\Http\\Controllers\\FooController@fooBar']
        ];

        foreach ($options as $option) {
            $route = $routes->routeConfig($option[0], $foo);
            $this->assertEquals($option[1], $route['uses']);
        }

        $foo['routesController'] = 'FooBarController';
        $routes = new Routes;
        $route = $routes->routeConfig(['uri' => ''], $foo);
        $this->assertEquals('App\\Foo\\Http\\Controllers\\FooBarController@foo', $route['uses']);

        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $foo['paths.controllers'] = '';
        $routes = new Routes;

        $route = $routes->routeConfig(['uri' => ''], $foo);
        $this->assertEquals('App\\Foo\\FooController@foo', $route['uses']);

        $route = $routes->routeConfig(['uri' => '', 'uses' => 'App\\Bar\\BarController'], $foo);
        $this->assertEquals('App\\Bar\\BarController@foo', $route['uses']);
    }

    public function test_routes_config_route_sets_name()
    {
        $modules = new Modules;
        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $routes = new Routes;

        $options = [
            [['uri' => ''], 'foo'],
            [['uri' => '{foo}'], 'foo'],
            [['uri' => '', 'method' => 'post'], 'foo'],
            [['uri' => '{foo}', 'method' => 'put'], 'foo'],
            [['uri' => '{foo}', 'method' => 'delete'], 'foo'],
            [['uri' => '', 'method' => 'delete'], 'foo'],
            [['uri' => '', 'name' => 'foobar'], 'foo.foobar'],
            [['uri' => 'bar'], 'foo.bar'],
            [['uri' => 'bar', 'method' => 'resource'], 'foo.bar']
        ];

        foreach ($options as $option) {
            $route = $routes->routeConfig($option[0], $foo);
            $this->assertEquals($option[1], $route['name']);
        }
    }

    public function test_routes_config_handles_resource_method()
    {
        $modules = new Modules;
        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $routes = new Routes;
        $route = $routes->routeConfig([
            'uri' => '',
            'method' => 'resource'
        ], $foo);

        $this->assertEquals('resource', $route['method']);
        $this->assertEquals('foo', $route['name']);
        $this->assertEquals('App\\Foo\\Http\\Controllers\\FooController', $route['uses']);

        $route = $routes->routeConfig([
            'uri' => '/foobar',
            'method' => 'resource',
            'uses' => 'FooBarController'
        ], $foo);

        $this->assertEquals('resource', $route['method']);
        $this->assertEquals('foo', $route['name']);
        $this->assertEquals('App\\Foo\\Http\\Controllers\\FooBarController', $route['uses']);
    }

    public function test_routes_loads_resource_routes()
    {
        $modules = new Modules;
        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $foo['routes'] = [
            [
                'uri' => '',
                'method' => 'resource'
            ]
        ];
        $config = ['foo' => $foo];
        $routes = new Routes($config);
        $routes->loadRoutes();

        $routeCollection = Route::getRoutes();
        $route = $routeCollection->getByName('foo.index');

        $this->assertInstanceOf(\Illuminate\Routing\Route::class, $route);
    }

    public function test_routes_invalid_resource_config_throws_exception()
    {
        $this->expectException(InvalidRouteException::class);
        $modules = new Modules;
        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $foo['routes'] = [
            [
                'uri' => '',
                'method' => 'resource',
                'uses' => 'FooBarController@test'
            ]
        ];
        $config = ['foo' => $foo];
        $routes = new Routes($config);
        $routes->loadRoutes();
    }

    public function test_route_invalid_config_throws_exception()
    {
        $this->expectException(InvalidRouteException::class);
        $modules = new Modules;
        $foo = $modules->moduleConfigDefault('foo');
        $foo = new Dot($foo);
        $foo['routes'] = [
            [
                'name' => 'foo'
            ]
        ];
        $config = ['foo' => $foo];
        $routes = new Routes($config);
        $routes->loadRoutes();
    }

    /**
     * @todo
     */
    public function _test_route_collision_throws_exception()
    {

    }
}

<?php

namespace Base\Modules;

use Adbar\Dot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Base\Exceptions\InvalidRouteException;
use Base\Services\Routes;

class ModulesRoutes
{
    protected $modules;

    public function __construct(array $modules = [])
    {
        $this->modules = $modules;
    }

    public function loadRoutes()
    {
        $prefix = config('modules.routes.prefix');
        $middleware = config('modules.routes.middleware');
        foreach ($this->modules as $key => $module) {
            $routes = $module->get('routes', []);

            // Add module routes as group
            Route::group([
                'middleware' => $middleware,
                'prefix' => $prefix
            ], function () use ($module, $routes) {
                foreach ($routes as $route) {
                    $this->validateRoute($route);
                    $config = $this->routeConfig($route, $module);
                    $method = $config['method'];
                    if ($method == 'resource') {
                        Route::apiResource($config['uri'], $config['uses'], [
                            'as' => $config['name']
                        ])->names([
                            'index' => $config['name'] . '.index',
                            'store' => $config['name'] . '.store',
                            'show' => $config['name'] . '.show',
                            'update' => $config['name'] . '.update',
                            'destroy' => $config['name'] . '.destroy'
                        ]);
                        Route::delete($config['uri'], $config['uses'].'@destroyMany')
                            ->name($config['name'].'.destroyMany');
                    } else {
                        Route::$method($config['uri'], [
                            'as' => $config['name'],
                            'uses' => $config['uses']
                        ]);
                    }
                }
            });
        }
    }

    public function routeConfig($route, Dot $module)
    {
        // Route URI should be prefixed by module key
        // or routesPrefix setting, only if relative URI
        $uri = $route['uri'];
        if ( ! $uri || $uri[0] !== '/') {
            $prefix = $module->get('routesPrefix', $module['key']);
            $uri = $uri ? $prefix . '/' . $uri : $prefix;
        }

        // Convert :param syntax to {param}
        $uri = preg_replace('/:([^\/]*)/', '{$1}', $uri);

        // Method defaults to get
        $method = isset($route['method']) ? strtolower($route['method']) : 'get';

        // Action defaults based on method
        switch ($method) {
            case 'resource':
                $action = null;
            break;
            case 'post':
                $action = 'store';
            break;
            case 'put':
                $action = 'update';
            break;
            case 'delete':
                $action = $this->uriHasParams($uri) ? 'destroy' : 'destroyMany';
            break;
            default:
                $action = $this->uriHasParams($uri) ? 'show' : 'index';
        }

        // Setup name
        $names = [$module['key']];
        if ( ! empty($route['name'])) {
            $names[] = $route['name'];
        } else {
            $tempUri = explode('/', $route['uri']);
            while ($temp = array_shift($tempUri)) {
                // Skip params
                if ( ! Str::contains($temp, '{')) {
                    $names[] = Str::camel($temp);
                }
            }
        }
        $name = implode('.', $names);

        // Setup controller
        $uses = empty($route['uses']) ? null : $route['uses'];
        if ($uses) {
            // Does uses specify controller?
            if ( ! Str::contains($uses, 'Controller')) {
                // Uses is the controller function
                $uses = $module['routesController'] . '@' . $uses;
            }
        } else {
            $uses = $module['routesController'];
        }
        // Does uses specify function?
        if ($method != 'resource' && ! Str::contains($uses, '@')) {
            $uses .= '@';
            if (empty($route['uri'])) {
                $uses .= $module['key'];
            } else {
                $function = Str::of($route['uri'])
                    ->replace('/', '_')
                    ->camel();
                $uses .= $function;
            }
        }

        // Add namespace to uses controller if full namespace not
        // already defined
        if ( ! Str::contains($uses, '\\')) {
            $namespace = ! empty($route['namespace']) ? $route['namespace'] : $module['paths.controllers'] ? $module['namespace'] . '\\' . $module['paths.controllers'] : $module['namespace'];
            $namespace = Str::of($namespace)->replace('/', '\\');
            $uses = $namespace . '\\' . $uses;
        }

        return [
            'uri' => $uri,
            'method' => $method,
            'name' => $name,
            'uses' => $uses
        ];
    }

    protected function uriHasParams($uri)
    {
        return preg_match('/.*?\{.*\}/', $uri);
    }

    protected function validateRoute($route)
    {
        if ( ! isset($route['uri'])) {
            throw new InvalidRouteException('Route config is invalid. Missing uri. ' . print_r($route, 1));
        }
        if (isset($route['method']) && isset($route['uses']) && $route['method'] == 'resource' && Str::contains($route['uses'], '@')) {
            throw new InvalidRouteException('Route config is invalid. Resource route should point to controller. ' . print_r($route, 1));
        }
    }
}

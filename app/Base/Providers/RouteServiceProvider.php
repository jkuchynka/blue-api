<?php

namespace Base\Providers;

use Adbar\Dot;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Traits\ForwardsCalls;
use Base\Services\Modules;

/**
 * @mixin \Illuminate\Routing\Router
 */
class RouteServiceProvider extends ServiceProvider
{
    use ForwardsCalls;

    protected $modules;

    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Modules $modules)
    {
        $this->modules = $modules;

        $this->setRootControllerNamespace();

        if ($this->routesAreCached()) {
            $this->loadCachedRoutes();
        } else {
            $this->loadRoutes();

            $this->app->booted(function () {
                $this->app['router']->getRoutes()->refreshNameLookups();
                $this->app['router']->getRoutes()->refreshActionLookups();
            });
        }
    }

    /**
     * Set the root controller namespace for the application.
     *
     * @return void
     */
    protected function setRootControllerNamespace()
    {
        if (! is_null($this->namespace)) {
            $this->app[UrlGenerator::class]->setRootControllerNamespace($this->namespace);
        }
    }

    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    protected function routesAreCached()
    {
        return $this->app->routesAreCached();
    }

    /**
     * Load the cached routes for the application.
     *
     * @return void
     */
    protected function loadCachedRoutes()
    {
        $this->app->booted(function () {
            require $this->app->getCachedRoutesPath();
        });
    }

    /**
     * Load the application routes.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $modules = $this->modules->getModules();
        foreach ($modules as $key => $config) {
            $module = new Dot($config);
            $routes = $module->get('routes', []);
            $namespace = $module['namespace'];
            if ($module['paths.controllers']) {
                $namespace .= '\\' . $module['paths.controllers'];
            }
            Route::group([
                'as' => $module['key'],
                'namespace' => $namespace,
                'middleware' => 'api'
            ], function () use ($module, $routes) {
                $prefix = $module->get('routesPrefix', $module['key']);
                foreach ($routes as $route) {
                    $method = isset($route['method']) ? strtolower($route['method']) : 'get';
                    $name = isset($route['name']) ? $route['name'] : 'index';
                    $controller = isset($route['controller']) ? $route['controller'] : $module['name'] . 'Controller';
                    $function = isset($route['function']) ? $route['function'] : 'get';
                    // $namespace = $module['namespace'] . '\\' . $module['paths.controllers'];
                    // Prefix relative route URIs
                    $uri = $route['route'];
                    if ($uri[0] !== '/') {
                        $uri = $prefix . '/' . $uri;
                    }
                    Route::get($uri, [
                        'as' => '.' . $name,
                        'uses' => $controller . '@' . $function,
                       //  'namespace' => $namespace
                    ]);
                }
            });
        }
    }

    /**
     * Pass dynamic methods onto the router instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo(
            $this->app->make(Router::class), $method, $parameters
        );
    }
}

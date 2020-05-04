<?php

namespace Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Config\Repository;
use Symfony\Component\Yaml\Yaml;
use Base\Services\Modules;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Modules::class, function ($app) {
            $config = $app->make(Repository::class);
            $yaml = $app->make(Yaml::class);
            $modules = new Modules($config, $yaml);
            $modules->loadModules();
            return $modules;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

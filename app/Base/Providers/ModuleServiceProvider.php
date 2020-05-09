<?php

namespace Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use Base\Services\Modules;
use Base\Database\SeedCommand;
use Base\Console\Commands\ConsoleMakeCommand;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('modules', function ($app) {
            $config = $app->make(Repository::class);
            $yaml = $app->make(Yaml::class);
            $modules = new Modules($config, $yaml);
            $modules->loadModules($modules->getEnabledModules());

            return $modules;
        });

        $this->app->singleton('command.seed', function ($app) {
            return new SeedCommand($app['db']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $modules = $this->app->make('modules');
        $factory = $this->app->make(EloquentFactory::class);
        $migrator = $this->app->make('migrator');

        $modulesConfig = $modules->getModules();
        foreach ($modulesConfig as $module) {
            // Load factories from modules
            $path = $module['paths.module'] . '/' . $module['paths.factories'];
            if (is_dir($path)) {
                foreach (Finder::create()->files()->name('*Factory.php')->in($path) as $file) {
                    require $file->getRealPath();
                }
            }

            // Register module migration paths
            $migrator->path($module['paths.module'] . '/' . $module['paths.migrations']);
        }
    }
}

<?php

namespace Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use Base\Modules\ModulesService;
use Illuminate\Database\Migrations\MigrationCreator;
use Base\Database\SeedCommand;
use Base\Console\Commands\ConsoleMakeCommand;

class ModulesServiceProvider extends ServiceProvider
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
            $modulesService = new ModulesService($config, $yaml);
            $modulesService->loadModules($modulesService->getEnabledModules());

            return $modulesService;
        });

        $this->app->singleton('command.seed', function ($app) {
            return new SeedCommand($app['db']);
        });

        // Fix unresolvable dependency error when resolving $customStubPath
        // in MigrationCreator
        $this->app->when(MigrationCreator::class)
            ->needs('$customStubPath')
            ->give(function ($app) {
                return $app->basePath('stubs');
            });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $modulesService = $this->app->make('modules');
        $factory = $this->app->make(EloquentFactory::class);
        $migrator = $this->app->make('migrator');
        $viewFactory = $this->app->make(ViewFactory::class);

        $modules = $modulesService->getModules();
        foreach ($modules as $module) {

            // Load module factories
            $path = $module->path('factories');
            if (is_dir($path)) {
                foreach (Finder::create()->files()->name('*Factory.php')->in($path) as $file) {
                    require $file->getRealPath();
                }
            }

            // Register module migration paths
            $migrator->path($module->path('migrations'));

            // Register module view paths. Instead of actual namespace (App\Auth),
            // this should be the name of the module, or trailing part of
            // namespace (Auth)
            $viewFactory->addNamespace($module['name'], $module->path('views'));
        }
    }
}

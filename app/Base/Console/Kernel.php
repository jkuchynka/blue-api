<?php

namespace Base\Console;

use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load('');

        // @todo: Allow for modular closure commands
        // require base_path('routes/console.php');
    }

    /**
     * Reimplements the load function to load commands
     * from modules, which might have a different namespace
     *
     * @param  array|string $paths
     * @return void
     */
    protected function load($paths)
    {
        // Load commands from enabled modules
        $modules = resolve('modules');
        $moduleConfigs = $modules->getModules();

        foreach ($moduleConfigs as $module) {
            $path = $module['paths.module'] . '/Console/Commands';
            if (is_dir($path)) {
                $namespace ='';// $module['namespace'];
                foreach ((new Finder)->in($path)->files() as $command) {
                    $command = $namespace.str_replace(
                        ['/', '.php'],
                        ['\\', ''],
                        Str::after($command->getPathname(), realpath(app_path()).DIRECTORY_SEPARATOR)
                    );

                    if (is_subclass_of($command, Command::class) &&
                        ! (new ReflectionClass($command))->isAbstract()) {
                        Artisan::starting(function ($artisan) use ($command) {
                            $artisan->resolve($command);
                        });
                    }
                }
            }
        }
    }
}

<?php

namespace Base\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Console\ConsoleMakeCommand as BaseConsoleMakeCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ConsoleMakeCommand extends BaseConsoleMakeCommand
{
    /**
     * The module config
     *
     * @var Dot
     */
    protected $module;

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $modules = resolve('modules');
        $this->module = $modules->getModule($this->getModuleInput());

        return parent::handle();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = $this->module['namespace'];
        $namespace .= $this->module['paths.console.commands'] ? '\\' . str_replace('/', '\\', $this->module['paths.console.commands']) : '';
        return $namespace;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The name or key of the module'],
            ['name', InputArgument::REQUIRED, 'The name of the command'],
        ];
    }

    /**
     * Get the desired module key.
     *
     * @return string
     */
    protected function getModuleInput()
    {
        return trim($this->argument('module'));
    }
}

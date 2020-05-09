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
        $namespace = $rootNamespace;
        $namespace .= $this->module['paths.console.commands'] ? '\\' . str_replace('/', '\\', $this->module['paths.console.commands']) : '';
        return $namespace;
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->module['namespace'];
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->module['paths.module'] . '/' . str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/stubs/console.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($relativePath, '/')))
            ? $customPath
            : __DIR__.$relativePath;
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

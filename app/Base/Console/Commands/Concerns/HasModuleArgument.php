<?php

namespace Base\Console\Commands\Concerns;

use Symfony\Component\Console\Input\InputArgument;

trait HasModuleArgument
{
    protected $module;

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        $arguments = parent::getArguments();
        $moduleArgument = ['module', InputArgument::REQUIRED, 'The name or key of the module'];
        array_unshift($arguments, $moduleArgument);
        return $arguments;
    }

    /**
     * Get the current module config
     *
     * @return Dot
     */
    protected function getModule()
    {
        if (! $this->module) {
            $modules = resolve('modules');
            $module = trim($this->argument('module'));
            $this->module = $modules->getModule($module);
        }
        return $this->module;
    }
}

<?php

namespace Base\Console\Commands\Concerns;

use Illuminate\Support\Str;

trait GeneratesForModule
{
    /**
     * Get the path for the built class
     *
     * @return string
     */
    abstract protected function getTargetPath();

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $path = $this->getTargetPath();
        $module = $this->getModule();
        $namespace = $rootNamespace;
        $namespace .= $path ? '\\' . str_replace('/', '\\', $path) : '';
        return $namespace;
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

        return $this->getModule()['paths.module'] . '/' . str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getModule()['namespace'];
    }
}

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
     * Get the replacement variables for the stub
     *
     * @param string $name
     * @return array
     */
    protected function getReplacements($name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $namespace = $this->getNamespace($name);
        $rootNamespace = $this->rootNamespace();
        $userModel = $this->userProviderModel();

        $replacements = [
            'DummyClass' => $class,
            '{{ class }}' => $class,
            '{{class}}' => $class,

            'DummyNamespace' => $namespace,
            '{{ namespace }}' => $namespace,
            '{{namespace}}' => $namespace,

            'DummyRootNamespace' => $rootNamespace,
            '{{ rootNamespace }}' => $rootNamespace,
            '{{rootNamespace}}' => $rootNamespace,

            'NamespacedDummyUserModel' => $userModel,
            '{{ namespacedUserModel }}' => $userModel,
            '{{namespacedUserModel}}' => $userModel
        ];

        if ($this->hasOption('model')) {
            $model = $this->option('model') ? $this->option('model') : 'Model';
            $namespaceModel = $this->getModule()['namespace'] . rtrim('\\' . str_replace('/', '\\', $this->getModule()['paths.models']), '\\') . '\\' . $model;

            $model = class_basename($namespaceModel);

            $replacements = array_merge($replacements, [
                'NamespacedDummyModel' => $namespaceModel,
                '{{ namespacedModel }}' => $namespaceModel,
                '{{namespacedModel}}' => $namespaceModel,
                'DummyModel' => $model,
                '{{ model }}' => $model,
                '{{model}}' => $model,
            ]);
        }

        return $replacements;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $replacements = $this->getReplacements($name);

        $stub = str_replace(
            array_keys($replacements), array_values($replacements), $stub
        );

        return $stub;
    }

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

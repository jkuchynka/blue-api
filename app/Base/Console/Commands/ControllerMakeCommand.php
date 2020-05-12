<?php

namespace Base\Console\Commands;

use Illuminate\Routing\Console\ControllerMakeCommand as BaseCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends BaseCommand
{
    use Concerns\HasModuleArgument,
        Concerns\GeneratesForModule;

    /**
     * Get the path for the built class
     *
     * @return string
     */
    protected function getTargetPath()
    {
        return $this->getModule()->path('controllers');
    }

    /**
     * Get the replacement variables for the stub
     *
     * @param array $replacements
     * @return array
     */
    protected function getReplacements($replacements)
    {
        $module = $this->getModule();

        $controllerNamespace = $module['namespace'] . '\\' . rtrim(str_replace('/', '\\', $module['paths.controllers']), '\\');

        $replacements = array_merge($replacements, [
            '{{ controllerNamespace }}' => $controllerNamespace,
            "use {$controllerNamespace}\Controller;\n" => '',
            '{{ namespacedModel }}' => $this->module->namespace('models') . '\\Model'
        ]);

        if ($this->option('parent')) {
            $replacements = array_merge($replacements, $this->buildParentReplacements());
        }

        if ($this->option('model')) {
            $replacements = $this->buildModelReplacements($replacements);
        }

        return $replacements;
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        $module = $this->getModule();
        $modelNamespace = $module['namespace'];
        $modelNamespace .= rtrim(str_replace('/', '\\', '\\' . $module['paths.models']), '\\') . '\\';

        if (! Str::startsWith($model, $module['namespace'])) {
            $model = $modelNamespace.$model;
        }

        return $model;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        // Model and resource controllers both correspond to
        // a full resourceful controller with query builder setup
        // The api option is redundant here, so it will use
        // the same stub as the resource controller

        $stub = null;

        if ($this->option('parent')) {
            $stub = 'controller.nested.stub';
        } elseif ($this->option('model')) {
            $stub = 'controller.model.stub';
        } elseif ($this->option('invokable')) {
            $stub = 'controller.invokable.stub';
        } elseif ($this->option('resource')) {
            $stub = 'controller.stub';
        }

        if ($this->option('api') && is_null($stub)) {
            $stub = 'controller.api.stub';
        } elseif ($this->option('api') && ! is_null($stub) && ! $this->option('invokable')) {
            $stub = str_replace('.stub', '.api.stub', $stub);
        }

        if ($this->option('api') && $this->option('querybuilder')) {
            $stub = str_replace('.stub', '.querybuilder.stub', $stub);
        }

        $stub = $stub ?? 'controller.plain.stub';

        return __DIR__.'/stubs/controller/'.$stub;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        $options[] = ['querybuilder', 'b', InputOption::VALUE_NONE, 'Generate an api controller with query builder methods'];
        return $options;
    }
}

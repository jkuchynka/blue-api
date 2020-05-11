<?php

namespace Base\Modules;

use Adbar\Dot;
use Illuminate\Support\Str;

class Module extends Dot
{
    /**
     * Set default module config
     *
     * @param string $key
     * @return $this
     */
    public function setDefaultConfig(string $key)
    {
        $config = [
            'key' => $key,
            'name' => Str::studly($key),
            'version' => '0.1',
            'dependsOn' => [],
            'seeds' => false,
            'seedsWeight' => 10,
            'paths' => [
                'commands' => 'Console/Commands',
                'controllers' => 'Http/Controllers',
                'factories' => 'Database/Factories',
                'migrations' => 'Database/Migrations',
                'models' => 'Models',
                'resources' => 'Http/Resources',
                'seeds' => 'Database/Seeds',
            ],
            'routesPrefix' => $key,
            'routes' => []
        ];
        $config['namespace'] = $key === 'base' ? 'Base' : 'App\\' . $config['name'];
        $config['routesController'] = $config['name'] . 'Controller';
        $this->items = $config;

        return $this;
    }

    /**
     * Get the module's namespace for a type
     *
     * @param string $type
     * @return string
     */
    public function namespace(string $type)
    {
        return $this['namespace'].rtrim('\\', $this['paths.'.$type].'\\');
    }

    /**
     * Get the full module path
     *
     * @param string $type
     * @return string
     */
    public function path(string $type)
    {
        return $this['paths.module'].'/'.$this['paths.'.$type];
    }
}

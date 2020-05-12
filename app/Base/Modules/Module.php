<?php

namespace Base\Modules;

use Adbar\Dot;
use Base\Helpers\Common;
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
     * Get the module's full namespace for a type
     *
     * @param string $type
     * @return string
     */
    public function namespace(string $type = null)
    {
        return $type ?
            Common::namespaceCombine(
                $this['namespace'],
                Common::namespaceFromPath($this['paths.'.$type])
            ) :
            $this['namespace'];
    }

    /**
     * Get the full module path for a type
     *
     * @param string $type
     * @return string
     */
    public function path(string $type = null)
    {
        $path = $type ?
            $this['paths.module'].'/'.$this['paths.'.$type] :
            $this['paths.module'];
        return rtrim($path, '/');
    }
}

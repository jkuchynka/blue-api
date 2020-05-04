<?php

namespace Base\Services;

use Adbar\Dot;
use Illuminate\Config\Repository;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class Modules
{
    protected $config;
    protected $configRepository;
    protected $yaml;

    public function __construct(Repository $config = null, Yaml $yaml = null)
    {
        $this->config = new Dot;
        $this->configRepository = $config ? $config : new Repository;
        $this->yaml = $yaml ? $yaml : new Yaml;
    }

    /**
     * Get the enabled modules and config for this app,
     * set in modules config.
     *
     * @return array Keys of enabled modules
     */
    public function getEnabledModules(): array
    {
        $enabled = $this->configRepository->get('modules.modules', []);
        return array_keys($enabled);
    }

    /**
     * Get the modules path
     *
     * @return string
     */
    public function getModulesPath(): string
    {
        $path = $this->configRepository->get('modules.modulesPath', 'app');
        if ($path[0] === '/' || Str::contains($path, '://')) {
            return $path;
        }
        return base_path() . '/' . $path;
    }

    /**
     * Get all enabled modules and setup their config
     *
     * @return void
     */
    public function loadModules(): void
    {
        // Setup each module's config from default, yaml and app level
        foreach ($this->getEnabledModules() as $key) {
            $this->config[$key] = $this->moduleConfigDefault($key);

            // Check config/modules settings for app level settings
            // These will override any yaml settings, except for module path
            $appConfig = $this->configRepository->get('modules.modules.' . $key, []);

            if (isset($appConfig['paths']) && isset($appConfig['paths']['module'])) {
                $this->config[$key . '.paths.module'] = $appConfig['paths']['module'];
            }

            // Config from yaml
            $filename = $this->config[$key . '.paths.module'] . '/' . $key . '.config.yml';

            if (file_exists($filename)) {
                $otherConfig = $this->yaml->parseFile($filename);
                $this->config->mergeRecursiveDistinct($key, $otherConfig);
            }

            $this->config->mergeRecursiveDistinct($key, $appConfig);
        }
    }

    /**
     * Get module config defaults
     * @todo: Allow setting this in config
     *
     * @return array
     */
    public function moduleConfigDefault($key): array
    {
        $config = [
            'key' => $key,
            'name' => Str::studly($key),
            'version' => '0.1',
            'paths' => [
                'migrations' => 'Database/Migrations',
                'factories' => 'Database/Factories',
                'seeds' => 'Database/Seeds',
                'controllers' => 'Http/Controllers'
            ]
        ];
        $config['paths']['module'] = $this->getModulesPath() . '/' . $config['name'];
        $config['namespace'] = $key === 'base' ? 'Base' : 'App\\' . $config['name'];
        return $config;
    }

    /**
     * Get all enabled modules with configs
     *
     * @return Dot
     */
    public function getModules(): Dot
    {
        return $this->config;
    }
}

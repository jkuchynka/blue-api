<?php

namespace Base\Modules;

use Base\Exceptions\ModuleNotFoundException;
use Illuminate\Config\Repository;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class ModulesService
{
    /**
     * Config repository
     *
     * @var Repository
     */
    protected $configRepository;

    /**
     * Loaded modules
     *
     * @var array
     */
    protected $modules = [];

    /**
     * Yaml parser
     *
     * @var Yaml
     */
    protected $yaml;

    /**
     * Explicitly enabled modules
     *
     * @var array
     */
    protected static $enabledModules = [];

    public function __construct(Repository $config = null, Yaml $yaml = null)
    {
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
        if (! empty(static::$enabledModules)) {
            return static::$enabledModules;
        }
        $enabled = $this->configRepository->get('modules.modules', []);
        return array_keys($enabled);
    }

    /**
     * Explicitly set the modules to enable (used for testing)
     *
     * @param array $modules Module keys
     */
    public static function setEnabledModules(array $modules): void
    {
        static::$enabledModules = $modules;
    }

    /**
     * Get the modules path
     *
     * @return string
     */
    public function getModulesPath(): string
    {
        $path = $this->configRepository->get('modules.paths.modules', 'app');
        if ($path[0] === '/' || Str::contains($path, '://')) {
            return $path;
        }
        return base_path().'/'.$path;
    }

    /**
     * Load modules and setup their config
     *
     * @param array $modules
     * @return void
     */
    public function loadModules(array $modules): void
    {
        $this->modules = [];
        $this->doLoadModules($modules);
    }

    /**
     * Load modules and setup their config
     *
     * @param array $modules
     * @return void
     */
    protected function doLoadModules(array $modules): void
    {
        // Setup each module's config from default, yaml then app
        foreach ($modules as $key) {
            $module = new Module;
            $module->setDefaultConfig($key);

            // Check if app overrides the module path
            $path = $this->configRepository->get('modules.modules.'.$key.'.paths.module', null);

            if ($path) {
                $module['paths.module'] = $path;
            } else {
                $module['paths.module'] = $this->getModulesPath().'/'.$module['name'];
            }

            // Get module settings from yaml
            $filename = $module['paths.module'].'/'.$key.'.config.';

            if ((($path = $filename.'yaml') && file_exists($path)) ||
                (($path = $filename.'yml') && file_exists($path))
            ) {
                $yamlConfig = $this->yaml->parseFile($path);
                $module->mergeRecursiveDistinct($yamlConfig);
            }

            // Load app config
            $module->mergeRecursiveDistinct(
                $this->configRepository->get('modules.modules.'.$key, [])
            );

            $this->modules[$key] = $module;

            // If this module depends on other modules,
            // make sure they are loaded as well
            $keys = array_diff($module['dependsOn'], $modules, array_keys($this->modules));
            if ($keys) {
                $this->doLoadModules($keys);
            }
        }
    }

    /**
     * Get a loaded module by key
     *
     * @param  string $key
     * @return Dot
     */
    public function getModule($key): Module
    {
        if (isset($this->modules[$key])) {
            return $this->modules[$key];
        }
        throw new ModuleNotFoundException('Module: '.$key.' not found or loaded.');
    }

    /**
     * Get all enabled modules with configs
     *
     * @return Dot
     */
    public function getModules(): array
    {
        return $this->modules;
    }
}

<?php

namespace Base\Tests\Feature\Console;

use Base\Modules\ModulesService;
use Base\Tests\TestCase;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;
use Illuminate\Config\Repository;
use Symfony\Component\Yaml\Yaml;

abstract class CommandsTestCase extends TestCase
{
    protected $loadModules = ['base', 'foo_bar'];

    protected $root;

    protected function beforeTest()
    {
        $this->root = vfsStream::setup();

        // Rebind modulesService to our own with custom config
        $this->app->singleton('modules', function ($app) {
            $config = $app->make(Repository::class);
            $config->set('modules', [
                'modules' => [
                    'base' => [],
                    'foo_bar' => [
                        'paths' => [
                            'module' => vfsStream::url('root/FooBar')
                        ]
                    ]
                ]
            ]);
            $yaml = $app->make(Yaml::class);
            $modulesService = new ModulesService($config, $yaml);
            $modulesService->loadModules($modulesService->getEnabledModules());

            return $modulesService;
        });
    }

    protected function tearDown(): void
    {
        $this->root = null;
    }

    /**
     * Assert that the command generates a file at a path
     *
     * @param  string $path
     * @return void
     */
    protected function assertCommandPath($path)
    {
        if (! $this->root->hasChild($path)) {
            $visitor = new vfsStreamStructureVisitor;
            $visitor->visitDirectory($this->root);
            $this->fail('Command expected new class at path: '.$path.', filesystem: '.print_r($visitor->getStructure(), true));
        }
    }
}

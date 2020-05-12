<?php

namespace Base\Tests\Feature;

use Base\Modules\ModulesService;
use Base\Tests\TestCase;
use org\bovigo\vfs\vfsStream;
use Illuminate\Config\Repository;
use Symfony\Component\Yaml\Yaml;

class ConsoleCommandsTest extends TestCase
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

    public function test_console_make_command()
    {
        $this->artisan('make:command', [
            'module' => 'foo_bar',
            'name' => 'FooBarCommand'
        ]);

        $path = 'FooBar/Console/Commands/FooBarCommand.php';
        $this->assertTrue($this->root->hasChild($path));
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Console\\Commands;', $contents);
        $this->assertStringContainsString('class FooBarCommand ', $contents);
        $this->assertStringContainsString('$name = \'foo_bar:foo-bar', $contents);
    }

    public function test_controller_make_command()
    {
        $this->artisan('make:controller', [
            'module' => 'foo_bar',
            'name' => 'FooBarController'
        ]);

        $path = 'FooBar/Http/Controllers/FooBarController.php';
        $this->assertTrue($this->root->hasChild($path));
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Http\\Controllers;', $contents);
        $this->assertStringContainsString('class FooBarController ', $contents);
    }

    public function test_controller_make_command_nested()
    {
        // Nested
        $this->artisan('make:controller', [
            'module' => 'foo_bar',
            'name' => 'FooBarNestedController',
            '--parent' => 'ParentModel',
            '--no-interaction' => true
        // @todo: Should be better way to test this,
        // --no-interaction doesn't seem to work here
        ])->expectsQuestion('A App\FooBar\Models\ParentModel model does not exist. Do you want to generate it?', false);

        $path = 'FooBar/Http/Controllers/FooBarNestedController.php';
        $this->assertTrue($this->root->hasChild($path));
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Http\\Controllers;', $contents);
        $this->assertStringContainsString('class FooBarNestedController ', $contents);
        $this->assertStringContainsString('use App\\FooBar\\Models\\Model;', $contents);
        $this->assertStringContainsString('use App\\FooBar\\Models\\ParentModel;', $contents);
    }

    public function test_seeder_make_command()
    {
        $this->artisan('make:seeder', [
            'module' => 'foo_bar',
            'name' => 'FooBarSeeder'
        ]);

        $path = 'FooBar/Database/Seeds/FooBarSeeder.php';
        $this->assertTrue($this->root->hasChild($path));
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Database\\Seeds;', $contents);
        $this->assertStringContainsString('class FooBarSeeder ', $contents);
    }
}

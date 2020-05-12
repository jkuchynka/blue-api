<?php

namespace Base\Tests\Feature\Console;

class ConsoleCommandsTest extends CommandsTestCase
{
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

    public function test_factory_make_command()
    {
        $this->artisan('make:factory', [
            'module' => 'foo_bar',
            'name' => 'FooBarFactory'
        ]);

        $path = 'FooBar/Database/Factories/FooBarFactory.php';
        $this->assertTrue($this->root->hasChild($path));
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('use App\\FooBar\\Models\\Model', $contents);
        $this->assertStringContainsString('define(Model', $contents);

        $this->artisan('make:factory', [
            'module' => 'foo_bar',
            'name' => 'FooFactory',
            '--model' => 'Foo'
        ]);

        $path = 'FooBar/Database/Factories/FooFactory.php';
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('use App\\FooBar\\Models\\Foo', $contents);
        $this->assertStringContainsString('define(Foo', $contents);
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

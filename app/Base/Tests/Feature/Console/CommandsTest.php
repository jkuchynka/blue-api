<?php

namespace Base\Tests\Feature\Console;

class ConsoleCommandsTest extends CommandsTestCase
{
    public function test_channel_make_command()
    {
        $this->artisan('make:channel', [
            'module' => 'foo_bar',
            'name' => 'FooBarChannel'
        ]);

        $path = 'FooBar/Broadcasting/FooBarChannel.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Broadcasting;', $contents);
        $this->assertStringContainsString('use App\\Users\\User;', $contents);
        $this->assertStringContainsString('class FooBarChannel', $contents);
        $this->assertStringContainsString('User $user', $contents);
    }

    public function test_console_make_command()
    {
        $this->artisan('make:command', [
            'module' => 'foo_bar',
            'name' => 'FooBarCommand'
        ]);

        $path = 'FooBar/Console/Commands/FooBarCommand.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Console\\Commands;', $contents);
        $this->assertStringContainsString('class FooBarCommand ', $contents);
        $this->assertStringContainsString('$name = \'foo_bar:foo-bar', $contents);
    }

    public function test_event_make_command()
    {
        $this->artisan('make:event', [
            'module' => 'foo_bar',
            'name' => 'FooBarEvent'
        ]);

        $path = 'FooBar/Events/FooBarEvent.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Events;', $contents);
        $this->assertStringContainsString('class FooBarEvent', $contents);
    }

    public function test_exception_make_command()
    {
        $this->artisan('make:exception', [
            'module' => 'foo_bar',
            'name' => 'FooBarException'
        ]);

        $path = 'FooBar/Exceptions/FooBarException.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Exceptions;', $contents);
        $this->assertStringContainsString('class FooBarException ', $contents);
    }

    public function test_factory_make_command()
    {
        $this->artisan('make:factory', [
            'module' => 'foo_bar',
            'name' => 'FooBarFactory'
        ]);

        $path = 'FooBar/Database/Factories/FooBarFactory.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('use App\\FooBar\\Models\\Model', $contents);
        $this->assertStringContainsString('define(Model', $contents);

        $this->artisan('make:factory', [
            'module' => 'foo_bar',
            'name' => 'FooFactory',
            '--model' => 'Foo'
        ]);

        $path = 'FooBar/Database/Factories/FooFactory.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('use App\\FooBar\\Models\\Foo', $contents);
        $this->assertStringContainsString('define(Foo', $contents);
    }

    public function test_job_make_command()
    {
        $this->artisan('make:job', [
            'module' => 'foo_bar',
            'name' => 'FooBarJob'
        ]);

        $path = 'FooBar/Jobs/FooBarJob.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Jobs;', $contents);
        $this->assertStringContainsString('class FooBarJob ', $contents);
    }

    public function test_listener_make_command()
    {
        $this->artisan('make:listener', [
            'module' => 'foo_bar',
            'name' => 'FooBarListener'
        ]);

        $path = 'FooBar/Listeners/FooBarListener.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Listeners;', $contents);
        $this->assertStringContainsString('class FooBarListener', $contents);
    }

    public function test_listener_make_command_event()
    {
        $this->artisan('make:listener', [
            'module' => 'foo_bar',
            'name' => 'FooBarListener',
            '--event' => 'FooBarEvent'
        ]);

        $path = 'FooBar/Listeners/FooBarListener.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Listeners;', $contents);
        $this->assertStringContainsString('use App\\FooBar\\Events\\FooBarEvent;', $contents);
        $this->assertStringContainsString('class FooBarListener', $contents);
        $this->assertStringContainsString('FooBarEvent $event', $contents);
    }

    public function test_migration_make_command()
    {
        $this->artisan('make:migration', [
            'module' => 'foo_bar',
            'name' => 'create_foo_table'
        ]);

        $path = 'FooBar/Database/Migrations';
        $this->assertCommandPath($path);

        $file = $this->root
            ->getChild('FooBar')
            ->getChild('Database')
            ->getChild('Migrations')
            ->getChildren()[0];
        $contents = $file->getContent();

        $this->assertStringContainsString('create_foo_table', $file->getName());
        $this->assertStringContainsString('class CreateFooTable ', $contents);
    }

    public function test_resource_make_command()
    {
        $this->artisan('make:resource', [
            'module' => 'foo_bar',
            'name' => 'FooBarResource'
        ]);

        $path = 'FooBar/Http/Resources/FooBarResource.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Http\\Resources;', $contents);
        $this->assertStringContainsString('class FooBarResource ', $contents);

        $this->artisan('make:resource', [
            'module' => 'foo_bar',
            'name' => 'FooBarCollection',
            '--collection' => true
        ]);

        $path = 'FooBar/Http/Resources/FooBarCollection.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Http\\Resources;', $contents);
        $this->assertStringContainsString('class FooBarCollection ', $contents);
    }

    public function test_seeder_make_command()
    {
        $this->artisan('make:seeder', [
            'module' => 'foo_bar',
            'name' => 'FooBarSeeder'
        ]);

        $path = 'FooBar/Database/Seeds/FooBarSeeder.php';
        $this->assertCommandPath($path);
        $contents = $this->root->getChild($path)->getContent();

        $this->assertStringContainsString('namespace App\\FooBar\\Database\\Seeds;', $contents);
        $this->assertStringContainsString('class FooBarSeeder ', $contents);
    }
}

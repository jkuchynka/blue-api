<?php

namespace Base\Console\Commands;

use Illuminate\Foundation\Console\ResourceMakeCommand as BaseCommand;
use Illuminate\Support\Str;

class ResourceMakeCommand extends BaseCommand
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
        return $this->getModule()->path('resources');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->collection()
                    ? __DIR__.'/stubs/resource-collection.stub'
                    : __DIR__.'/stubs/resource.stub';
    }
}

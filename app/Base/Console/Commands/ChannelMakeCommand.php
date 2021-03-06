<?php

namespace Base\Console\Commands;

use Illuminate\Foundation\Console\ChannelMakeCommand as BaseCommand;

class ChannelMakeCommand extends BaseCommand
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
        return $this->getModule()->path('channels');
    }
}

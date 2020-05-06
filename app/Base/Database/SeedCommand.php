<?php

namespace Base\Database;

use Illuminate\Database\Console\Seeds\SeedCommand as IllSeedCommand;

class SeedCommand extends IllSeedCommand
{
    /**
     * Get the console command options. Change default seeder
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the root seeder', 'App\Base\Database\DatabaseSeeder'],

            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed'],

            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production'],
        ];
    }
}

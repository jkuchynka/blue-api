<?php

namespace App\Base\Database;

use Adbar\Dot;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call seeders from all modules that have seeding enabled
        $modules = resolve('modules');
        $modulesConfig = $modules->getModules();
        $groupedSeeds = new Dot;
        foreach ($modulesConfig as $module) {
            if ($module['seeds']) {
                $weight = $module['seedsWeight'];
                $class = $module['namespace'];
                if ($module['paths.seeds']) {
                    $class .= '\\';
                    $parts = explode('/', $module['paths.seeds']);
                    $class .= implode('\\', $parts);
                }
                $class .= '\\' . $module['name'] . 'Seeder';
                $groupedSeeds->add($weight, []);
                $groupedSeeds->push($weight, $class);
            }
        }
        foreach ($groupedSeeds as $weight => $seeds) {
            foreach ($seeds as $class) {
                $this->call($class);
            }
        }
    }
}

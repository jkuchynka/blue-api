<?php

namespace App\Filtersets\Database\Seeds;

use App\Filtersets\Models\Filterset;
use Illuminate\Database\Seeder;

class FiltersetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Filterset::class, 12)->create();
    }
}

<?php

namespace App\Files\Database\Seeds;

use App\Files\Models\File;
use Illuminate\Database\Seeder;

class FilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(File::class, 12)->create();
    }
}

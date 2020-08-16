<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Files\Models\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    $ext = $faker->fileExtension;
    return [
        'user_id' => 1,
        'name' => $faker->word.'.'.$ext,
        'filename' => $faker->unixTime.'.'.$ext,
        'mime' => $faker->mimeType
    ];
});

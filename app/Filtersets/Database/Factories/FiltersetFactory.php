<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filtersets\Models\Filterset;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'group' => $faker->name,
        'user_id' => 1
    ];
});

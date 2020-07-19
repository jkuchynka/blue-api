<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filtersets\Models\Filterset;
use Faker\Generator as Faker;

$factory->define(Filterset::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'group' => $faker->text(20),
        'user_id' => 1
    ];
});

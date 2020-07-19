<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filtersets\Models\FiltersetFilter;
use Faker\Generator as Faker;

$factory->define(FiltersetFilter::class, function (Faker $faker) {
    return [
        'field' => $faker->text(20),
        'operator' => '=',
        'value' => $faker->text(10)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Messages\ContactMessage;
use Faker\Generator as Faker;

$factory->define(ContactMessage::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'subject' => $faker->sentence,
        'message' => $faker->text
    ];
});

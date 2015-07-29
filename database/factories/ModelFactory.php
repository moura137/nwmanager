<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use NwManager\Entities;

$factory->define(Entities\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Entities\Client::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'responsible' => $faker->name,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});

$factory->define(Entities\Project::class, function ($faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'progress' => rand(0,100),
        'status' => $faker->randomElement(['1', '2', '3']),
        'due_date' => $faker->dateTime('now'),
    ];
});

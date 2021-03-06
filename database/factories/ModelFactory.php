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
        'obs' => $faker->text,
        'site' => $faker->url,
        'facebook' => 'facebook.com/'.$faker->username,
        'twitter' => '@'.$faker->username,
        'googleplus' => 'googleplus.com/'.$faker->username,
        'skype' => $faker->username,
    ];
});

$factory->define(Entities\Project::class, function ($faker) {
    return [
        'client_id' => rand(1,5),
        'owner_id' => rand(1,6),
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'progress' => rand(0,100),
        'status' => $faker->randomElement(['1', '2', '3']),
        'due_date' => $faker->dateTime('now'),
    ];
});

$factory->define(Entities\ProjectNote::class, function ($faker) {
    return [
        'project_id' => rand(1,10),
        'title' => $faker->sentence,
        'note' => $faker->text,
        'user_id' => rand(1,6),
    ];
});

$factory->define(Entities\ProjectTask::class, function ($faker) {
    return [
        'project_id' => rand(1,10),
        'name' => $faker->word,
        'start_date' => $faker->dateTime('now'),
        'due_date' => $faker->dateTime('now'),
        'status' => $faker->randomElement(['0', '1']),
    ];
});

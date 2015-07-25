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

$factory->define(CursoLaravel\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CursoLaravel\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});

$factory->define(CursoLaravel\Entities\Project::class, function (Faker\Generator $faker) {
    return [
        'owner_id' => factory(\CursoLaravel\Entities\User::class)->create()->id,
        'client_id' => factory(\CursoLaravel\Entities\Client::class)->create()->id,
        'name' => $faker->name,
        'description' => $faker->sentence,
        'progress' => 0,
        'status' => true,
        'due_date' => $faker->dateTime
    ];
});

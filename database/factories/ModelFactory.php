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

$factory->define(App\DataAccess\Eloquent\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\DataAccess\Eloquent\Entry::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->randomNumber(),
        'title' => $faker->randomLetter,
        'body' => $faker->randomLetter
    ];
});

$factory->define(App\DataAccess\Eloquent\Comment::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->randomNumber(),
        'comment' => $faker->text(200),
        'name' => $faker->name
    ];
});

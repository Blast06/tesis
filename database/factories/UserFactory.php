<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'verified_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Website::class, function (Faker $faker) {
    return [
        'name' => 'new website '. $faker->unique()->randomNumber,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'user_id' => factory(App\Models\User::class)->create()
    ];
});

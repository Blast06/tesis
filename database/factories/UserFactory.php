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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'verified_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Website::class, function (Faker $faker) {
    return [
        'name' => 'new website '. $faker->randomNumber,
        'username' => $faker->unique()->userName,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'user_id' => factory(App\User::class)->create()
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => str_slug($faker->unique()->word)
    ];
});

$factory->define(App\SubCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => str_slug($faker->unique()->word),
        'category_id' => factory(\App\Category::class)->create()
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(4),
        'price' => $faker->randomNumber,
        'category_id' => factory(\App\SubCategory::class)->create()
    ];
});



$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' =>  (string) \Illuminate\Support\Str::uuid(),
        'type' => "Notification\Test",
        'notifiable_id' => function () {
            return auth()->id() ?: factory(\App\User::class)->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => [
            'body' => 'Test Body'
        ],
    ];
});
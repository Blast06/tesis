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
        'password' => 'secret',
        'verified_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Website::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'username' => $faker->unique()->userName,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'user_id' => !\App\User::all()->isEmpty() && !App::environment('testing') ? \App\User::all()->random()->id : factory(App\User::class)->create(),
        'location' => $faker->randomElement([
            'Santo Domingo',
            'Santiago',
            'San Pedro de Macorís',
            'Puerto Plata',
            'La Romana',
            'San Cristóbal',
            'San Francisco de Macorís',
            'Higuey',
            'Barahona',
            'Bani',
            'San Juan',
            'Bonao',
            'Moca',
            'Azua',
            'Cotui',
            'La vega',
            'Nagua',
            'Salcedo'
        ]),
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\SubCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'category_id' => !\App\Category::all()->isEmpty() && !App::environment('testing') ? \App\Category::all()->random()->id : factory(\App\Category::class)->create()
    ];
});

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->paragraph,
        'price' => $faker->randomElement([$faker->randomNumber(3), $faker->randomNumber(4), $faker->randomNumber(5)]),
        'sub_category_id' => !\App\SubCategory::all()->isEmpty() && !App::environment('testing') ? \App\SubCategory::all()->random()->id : factory(\App\SubCategory::class)->create(),
        'website_id' => !\App\Website::all()->isEmpty() && !App::environment('testing') ? \App\Website::all()->random()->id : factory(\App\Website::class)->create(),
        'status' => \App\Article::STATUS_AVAILABLE,
        'shipping_place' => $faker->randomElement([
            'En cualquier ciudad de rep. dom.'.
            'Santo Domingo',
            'Santiago',
            'San Pedro de Macorís',
            'Puerto Plata',
            'La Romana',
            'San Cristóbal',
            'San Francisco de Macorís',
            'Higuey',
            'Barahona',
            'Bani',
            'San Juan',
            'Bonao',
            'Moca',
            'Azua',
            'Cotui',
            'La vega',
            'Nagua',
            'Salcedo'
        ]),
    ];

});

$factory->define(App\Conversation::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create(),
        'website_id' => factory(\App\Website::class)->create(),
    ];
});

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'conversation_id' => factory(\App\Conversation::class)->create(),
        'user_send' => factory(\App\User::class)->create(),
        'message' => $faker->paragraph(2),
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

$factory->define(App\Review::class, function (Faker $faker) {
    return [
        'article_id' => !\App\Article::all()->isEmpty() && !App::environment('testing') ? \App\Article::all()->random()->id : factory(\App\Article::class)->create(),
        'user_id' => factory(\App\User::class)->create(),
        'rating' => $faker->randomElement([1, 2, 3, 4 ,5]),
        'comment' => $faker->randomElement([$faker->paragraph(2), null]),
    ];
});

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'price' => $faker->randomNumber(3),
        'quantity' => $faker->randomNumber(1),
        'user_id' => !\App\User::all()->isEmpty() && !App::environment('testing') ? \App\User::all()->random()->id : factory(\App\User::class)->create(),
        'article_id' => !\App\Article::all()->isEmpty() && !App::environment('testing') ? \App\Article::all()->random()->id : factory(\App\Article::class)->create(),
        'website_id' => !\App\Website::all()->isEmpty() && !App::environment('testing') ? \App\Website::all()->random()->id : factory(\App\Website::class)->create(),
    ];
});
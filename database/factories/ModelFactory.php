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

$factory->define(App\UserRole::class, function (Faker\Generator $faker) {
    return [
        'user_role'     => "Client",
        'description'   => "Client",
        'status'        => 1,
    ];
});

$factory->define(App\ContactType::class, function (Faker\Generator $faker) {
    return [
        'contact_type'  => "Mobile",
        'status'        => 1,
    ];
});

$factory->define(App\AddressType::class, function (Faker\Generator $faker) {
    return [
        'address_type'  => "Home",
        'status'        => 1,
    ];
});

$factory->define(App\UserRole::class, function (Faker\Generator $faker) {
    return [
        'user_role'     => "Client",
        'description'   => "Client",
        'status'        => 1,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'    => $faker->unique()->firstName,
        'last_name'     => $faker->unique()->lastName,
        'email'         => $faker->unique()->email,
        'date_of_birth' => $faker->unique()->date(),
        'gender'        => $faker->numberBetween(1, 2),
        'nic'           => $faker->unique()->randomNumber(),
        'user_role_id'  => 1,
        'status'        => 1,
        'password'      => app('hash')->make('12345'),
    ];
});


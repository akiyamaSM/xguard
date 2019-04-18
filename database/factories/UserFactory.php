<?php

use Faker\Generator as Faker;

$factory->define(xguard\User::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'avatar' => null,
        'address' => $faker->address,
        'country_id' => function () use ($faker) {
            return $faker->randomElement(xguard\Country::pluck('id')->toArray());
        },
        'role_id' => function () {
            return factory(\xguard\Role::class)->create()->id;
        },
        'status' => xguard\Support\Enum\UserStatus::ACTIVE,
        'birthday' => $faker->date()
    ];
});

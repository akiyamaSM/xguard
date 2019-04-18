<?php

use Faker\Generator as Faker;
use xguard\Services\Logging\UserActivity\Activity;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\xguard\User::class)->create()->id;
        },
        'description' => substr($faker->paragraph, 0, 255),
        'ip_address' => $faker->ipv4,
        'user_agent' => $faker->userAgent
    ];
});

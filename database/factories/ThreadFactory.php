<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use Faker\Generator as Faker;

$factory->define(
    Thread::class,
    function (Faker $faker) {
        return [
            'user_id' => function () {
                return factory(App\User::class)->create()->id;
            },
            'channel_id' => function () {
                return factory(App\Channel::class)->create()->id;
            },
            'title' => $faker->sentence,
            'body' => $faker->paragraph(),
        ];
    }
);

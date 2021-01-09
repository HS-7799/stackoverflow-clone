<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Like;
use App\Reply;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        "user_id" => App\User::all()->random()->id,
        "reply_id" => Reply::all()->random()->id,
    ];
});

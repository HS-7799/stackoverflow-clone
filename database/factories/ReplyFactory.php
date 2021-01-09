<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use App\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        "user_id" => App\User::all()->random()->id,
        "question_id" => Question::all()->random()->id,
        "body" => $faker->paragraph
    ];
});

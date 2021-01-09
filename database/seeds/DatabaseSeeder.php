<?php

use App\Question;
use App\User;
use App\Category;
use App\Reply;
use App\Like;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1_email = "hamza@example.com";
        $user1_name = "hamza elharsi";

        $user2_email = "test@example.com";
        $user2_name = "test test";

        // 10 users
        factory(User::class)->create(['email' => $user1_email,'name' => $user1_name]);
        factory(User::class)->create(['email' => $user2_email,'name' => $user2_name]);
        factory(User::class,8)->create();

        //5 categories

        factory(Category::class,5)->create();

        //12 questions

        factory(Question::class,3)->create(['user_id' => 1 ]);
        factory(Question::class,3)->create(['user_id' => 2 ]);
        factory(Question::class,6)->create();

        //50 reply

        factory(Reply::class,50)->create();

        //200 likes

        factory(Like::class,200)->create();





    }
}

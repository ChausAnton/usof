<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;


class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'author' => 'Admin',
            'user_id' => 1,
            'post_id' => 1,
            'content' => Str::random(10)
        ]);
        DB::table('comments')->insert([
            'author' => 'User1',
            'user_id' => 2,
            'post_id' => 1,
            'rating' => 2,
            'content' => Str::random(10)
        ]);
        DB::table('comments')->insert([
            'author' => 'User2',
            'user_id' => 3,
            'post_id' => 1,
            'content' => Str::random(10)
        ]);
        DB::table('comments')->insert([
            'author' => 'User3',
            'user_id' => 4,
            'post_id' => 2,
            'content' => Str::random(10)
        ]);
        DB::table('comments')->insert([
            'author' => 'User4',
            'user_id' => 5,
            'post_id' => 2,
            'content' => Str::random(10)
        ]);
    }
}

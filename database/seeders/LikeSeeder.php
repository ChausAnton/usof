<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
            'author' => 'Admin',
            'user_id' => 1,
            'post_id' => 1,
            'type' => 'dislike',
        ]);
        DB::table('likes')->insert([
            'author' => 'User1',
            'user_id' => 2,
            'post_id' => 1,
            'type' => 'dislike',
        ]);
        DB::table('likes')->insert([
            'author' => 'User2',
            'user_id' => 3,
            'post_id' => 1,
            'type' => 'dislike',
        ]);
        DB::table('likes')->insert([
            'author' => 'User3',
            'user_id' => 4,
            'comment_id' => 2,
            'type' => 'like',
        ]);
        DB::table('likes')->insert([
            'author' => 'User4',
            'user_id' => 5,
            'comment_id' => 2,
            'type' => 'like',
        ]);
    }
}

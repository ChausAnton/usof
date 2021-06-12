<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10)
        ]);
        DB::table('categories')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10)
        ]);
        DB::table('categories')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10)
        ]);
        DB::table('categories')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10)
        ]);
        DB::table('categories')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10)
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'login' => "Admin",
            'real_name' => Str::random(10),
            'email' => "anton271993@ukr.net",
            'password' => Hash::make('2222'),
            'role' => "admin"
        ]);
    }
}

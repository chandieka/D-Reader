<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an Admin
        DB::table('users')->insert([
            'name' => "admin",
            'email' => "admin@dreader.com",
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
            'created_at' => Date::now()->toDateTimeString(),
            'updated_at' => Date::now()->toDateTimeString(),
        ]);
    }
}

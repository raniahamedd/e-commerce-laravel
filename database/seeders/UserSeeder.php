<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    // useing Model
        User::create([
            'name' => "Rania Hamed",
            'email' => 'rania@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '597982030'
        ]);

     // using Query Builder DB Fasade
        DB::table('users')->insert([
            'name' => 'suha Hamed',
            'email' => 'suha@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '597999830'
        ]);
    }
}

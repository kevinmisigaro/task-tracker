<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::create([
            'name' => 'Lionel Messi',
            'email' => 'messi@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 1
        ]);

        User::create([
            'name' => 'Sergi Roberto',
            'email' => 'sergi@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 2
        ]);

        User::create([
            'name' => 'Gerard Pique',
            'email' => 'pique@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 2
        ]);
    }
}

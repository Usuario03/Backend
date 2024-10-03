<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Histories;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Crear el primer usuario
        User::create([
            'identification_number' => '123456',
            'first_name' => 'User',
            'last_name' => 'User',
            'email' => 'user@gmail.com',
            'phone_number' => '3182222222',
            'password' => bcrypt('123456'),
        ]);
    }
}

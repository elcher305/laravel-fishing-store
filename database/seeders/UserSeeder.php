<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Администратор
        User::create([
            'name' => 'elv',
            'email' => 'admin@fishing.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // обычный пользователь
        User::create([
            'name' => 'elvira',
            'email' => 'elvira@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

    }
}

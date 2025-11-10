<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Создаем основного администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@fishingstore.ru',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // пароль: password
            'role' => 'admin',
            'phone' => '+7 (999) 999-99-99',
            'is_active' => true,
            'remember_token' => Str::random(10),
        ]);

        // Создаем несколько случайных пользователей
        User::factory(10)->create();

        $this->command->info('Администраторы и пользователи созданы успешно!');
        $this->command->info('Email администратора: admin@fishingstore.ru');
        $this->command->info('Пароль администратора: password');

    }
}

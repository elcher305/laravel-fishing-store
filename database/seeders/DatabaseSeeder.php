<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            AdminSeeder::class,
        ]);

        $this->command->info('✅ Все данные успешно созданы!');
        $this->command->info('👤 Администратор: admin@fishingstore.ru / password');
        $this->command->info('👤 Пользователь: user@fishingstore.ru / user123');
        $this->command->info('🎣 Создано категорий: ' . \App\Models\Category::count());
        $this->command->info('🏷️ Создано брендов: ' . \App\Models\Brand::count());
        $this->command->info('📦 Создано товаров: ' . \App\Models\Product::count());

    }
}

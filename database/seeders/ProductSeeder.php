<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Прикормка DUNAEV BLACK Series 1 ит BREAM',
                'description' => 'Серия Black, для леща, вес: 500г',
                'price' => 230.00,
                'stock' => 50,
                'category' => 'Прикормка',
                'brand' => 'DUNAEV',
                'weight' => 500,
            ],
            [
                'name' => 'Шнур Дунаев Braid PE X4 150 м.',
                'description' => 'Плетеный шнур для спиннинга',
                'price' => 600.00,
                'stock' => 25,
                'category' => 'Шнур',
                'brand' => 'DUNAEV',
                'weight' => 150,
            ],
            [
                'name' => 'Премиум крючок Дунаев',
                'description' => 'Качественный крючок для рыбы',
                'price' => 145.00,
                'stock' => 100,
                'category' => 'Крючки',
                'brand' => 'DUNAEV',
                'weight' => 10,
            ],
            [
                'name' => 'Кольцо заводное Dunaev size #7',
                'description' => 'Заводное кольцо для снастей',
                'price' => 100.00,
                'stock' => 75,
                'category' => 'Аксессуары',
                'brand' => 'DUNAEV',
                'weight' => 5,
            ],
            [
                'name' => 'Спиннинг Shimano Catana',
                'description' => 'Универсальный спиннинг',
                'price' => 3500.00,
                'stock' => 10,
                'category' => 'Спиннинг',
                'brand' => 'Shimano',
                'weight' => 200,
            ],
            [
                'name' => 'Катушка Daiwa Regal',
                'description' => 'Безынерционная катушка',
                'price' => 2800.00,
                'stock' => 15,
                'category' => 'Катушки',
                'brand' => 'Daiwa',
                'weight' => 300,
            ],
            [
                'name' => 'Поплавок для фидера',
                'description' => 'Чувствительный поплавок',
                'price' => 85.00,
                'stock' => 60,
                'category' => 'Поплавок',
                'brand' => 'Sensas',
                'weight' => 15,
            ],
            [
                'name' => 'Зимняя удочка',
                'description' => 'Удочка для зимней рыбалки',
                'price' => 1200.00,
                'stock' => 8,
                'category' => 'Зимняя рыбалка',
                'brand' => 'Salmo',
                'weight' => 250,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Кольцо заводное Dunaev size #7',
                'price' => 100,
                'stock' => 50,
                'badge' => 'ЗАВОДНОЕ',
                'sizes' => json_encode(['3.5мм', '4мм', '5мм', '6мм', '7мм']),
                'category' => 'Аксессуары'
            ],
            [
                'name' => 'Шнур Дунаев Braid PE X4 150 м.',
                'price' => 600,
                'stock' => 20,
                'badge' => 'ШНУР',
                'sizes' => json_encode(['0.38мм', '0.20мм', '0.12мм', '0.08мм']),
                'category' => 'Спиннинг'
            ],
            [
                'name' => 'Премиум крючок Дунаев',
                'price' => 145,
                'stock' => 0,
                'badge' => 'ПРЕМИУМ',
                'sizes' => json_encode(['0.41мм', '0.33мм', '0.30мм', '0.28мм']),
                'category' => 'Крючки'
            ],
            [
                'name' => 'Прикормка DUNAEV BLACK',
                'price' => 268,
                'stock' => 100,
                'badge' => 'ПРИКОРМКА',
                'sizes' => json_encode(['0.41мм', '0.33мм', '0.30мм', '0.28мм']),
                'category' => 'Приманки'
            ],
            // Добавьте больше товаров по аналогии
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}

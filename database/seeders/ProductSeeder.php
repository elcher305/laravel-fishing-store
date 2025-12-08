<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Спиннинг Shimano Catana 240',
                'description' => 'Качественный спиннинг для начинающих рыболовов. Длина 2.4 метра.',
                'price' => 4500.00,
                'quantity' => 15,
                'category' => 'Удилища',
                'characteristics' => [
                    ['key' => 'Длина', 'value' => '2.4 м'],
                    ['key' => 'Тест', 'value' => '10-40 г'],
                    ['key' => 'Строй', 'value' => 'Средний'],
                    ['key' => 'Материал', 'value' => 'Карбон']
                ]
            ],
            [
                'name' => 'Катушка Daiwa Regal 2500',
                'description' => 'Безынерционная катушка с передним фрикционом.',
                'price' => 3200.00,
                'quantity' => 8,
                'category' => 'Катушки',
                'characteristics' => [
                    ['key' => 'Размер', 'value' => '2500'],
                    ['key' => 'Подшипники', 'value' => '5+1'],
                    ['key' => 'Вес', 'value' => '285 г']
                ]
            ],
            [
                'name' => 'Плетеный шнур Power Pro 0.15mm',
                'description' => 'Прочный плетеный шнур зеленого цвета. Длина 150 метров.',
                'price' => 1800.00,
                'quantity' => 25,
                'category' => 'Лески и шнуры',
                'characteristics' => [
                    ['key' => 'Диаметр', 'value' => '0.15 мм'],
                    ['key' => 'Длина', 'value' => '150 м'],
                    ['key' => 'Разрывная нагрузка', 'value' => '15 кг'],
                    ['key' => 'Цвет', 'value' => 'Зеленый']
                ]
            ],
            [
                'name' => 'Набор воблеров Rapala',
                'description' => 'Набор из 5 воблеров разных цветов и размеров.',
                'price' => 2900.00,
                'quantity' => 12,
                'category' => 'Приманки',
                'characteristics' => [
                    ['key' => 'Количество', 'value' => '5 шт'],
                    ['key' => 'Тип', 'value' => 'Воблеры'],
                    ['key' => 'Глубина погружения', 'value' => '1-3 м']
                ]
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}

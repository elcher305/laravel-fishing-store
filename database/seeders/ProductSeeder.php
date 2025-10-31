<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $fishingCategories = [
            'Спиннинги' => [
                'Телескопические',
                'Штекерные',
                'Карбоновые'
            ],
            'Катушки' => [
                'Безынерционные',
                'Мультипликаторные',
                'Инерционные'
            ],
            'Лески и шнуры' => [
                'Плетеные шнуры',
                'Монофильные лески',
                'Флюорокарбоновые'
            ],
            'Приманки' => [
                'Воблеры',
                'Блесны',
                'Силиконовые приманки',
                'Попперы'
            ]
        ];

        $fishingBrands = ['Shimano', 'Daiwa', 'Salmo', 'ZipBaits', 'Pontoon21', 'Jackall'];

        // Создаем бренды
        foreach ($fishingBrands as $brandName) {
            Brand::create([
                'name' => $brandName,
                'slug' => \Str::slug($brandName),
                'is_active' => true
            ]);
        }

        // Создаем категории
        foreach ($fishingCategories as $parentName => $children) {
            $parent = Category::create([
                'name' => $parentName,
                'slug' => \Str::slug($parentName),
                'is_active' => true
            ]);

            foreach ($children as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => \Str::slug($childName),
                    'parent_id' => $parent->id,
                    'is_active' => true
                ]);
            }
        }

        // Создаем товары
        $products = [
            [
                'name' => 'Катушка Shimano Stradic 4000',
                'price' => 15000,
                'category_id' => Category::where('name', 'Безынерционные')->first()->id,
                'brand_id' => Brand::where('name', 'Shimano')->first()->id,
            ],
            [
                'name' => 'Спиннинг Daiwa Exceler 210',
                'price' => 8000,
                'category_id' => Category::where('name', 'Штекерные')->first()->id,
                'brand_id' => Brand::where('name', 'Daiwa')->first()->id,
            ],
            // Добавьте больше рыболовных товаров...
        ];

        foreach ($products as $productData) {
            Product::create(array_merge($productData, [
                'slug' => \Str::slug($productData['name']),
                'description' => 'Качественный товар для рыбалки...',
                'stock_quantity' => rand(5, 50),
                'is_active' => true,
                'sku' => 'FP' . rand(1000, 9999),
            ]));
        }
    }
}

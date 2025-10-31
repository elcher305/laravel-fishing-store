<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class FishingProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'product_name' => 'Спиннинг Shimano Catana CX 210ML',
                'price' => 4500,
                'category' => 'Медиум',
                'brand' => 'Shimano',
                'fishing_type' => 'spinning',
                'target_fish' => 'щука, окунь, судак',
                'features' => ['Длина: 2.10м', 'Тест: 5-25г', 'Строй: средний']
            ],
            [
                'product_name' => 'Катушка Daiwa BG 5000',
                'price' => 12000,
                'category' => 'Безынерционные',
                'brand' => 'Daiwa',
                'fishing_type' => 'spinning',
                'target_fish' => 'морская рыба, сом',
                'features' => ['Размер: 5000', 'Подшипники: 6+1', 'Фрикцион: передний']
            ],
            [
                'product_name' => 'Воблер Jackall Rerange 110',
                'price' => 1800,
                'category' => 'Воблеры',
                'brand' => 'Jackall',
                'fishing_type' => 'spinning',
                'target_fish' => 'щука, окунь, жерех',
                'features' => ['Длина: 110мм', 'Вес: 14г', 'Заглубление: 1.5м']
            ],
            // Добавьте больше рыболовных товаров...
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            $brand = Brand::where('name', $productData['brand'])->first();

            if ($category && $brand) {
                Product::create([
                    'product_name' => $productData['product_name'],
                    'slug' => \Str::slug($productData['product_name']),
                    'description' => 'Качественный товар для рыбалки. ' . $productData['product_name'],
                    'short_description' => 'Профессиональное рыболовное снаряжение',
                    'price' => $productData['price'],
                    'sku' => 'FP' . rand(1000, 9999),
                    'stock_quantity' => rand(5, 50),
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'fishing_type' => $productData['fishing_type'],
                    'target_fish' => $productData['target_fish'],
                    'features' => $productData['features'],
                    'is_active' => true
                ]);
            }
        }
    }
}

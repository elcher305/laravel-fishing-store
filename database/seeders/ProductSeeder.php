<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        $brands = Brand::all();

        $products = [
            // Спиннинги
            [
                'name' => 'Shimano Catana CX Spinning Rod 2.4m',
                'slug' => 'shimano-catana-spinning-24',
                'description' => 'Качественное спиннинговое удилище для начинающих и опытных рыболовов. Отлично подходит для ловли на различные приманки.',
                'price' => 4500,
                'old_price' => 5200,
                'category_id' => $categories->where('slug', 'spinning-rods')->first()->id,
                'brand_id' => $brands->where('slug', 'shimano')->first()->id,
                'features' => json_encode([
                    'Длина' => '2.4 м',
                    'Тест' => '5-25 г',
                    'Строй' => 'Средний',
                    'Материал' => 'Карбон',
                    'Вес' => '145 г'
                ])
            ],
            [
                'name' => 'Daiwa Ninja Spinning Rod 2.7m',
                'slug' => 'daiwa-ninja-spinning-27',
                'description' => 'Профессиональное спиннинговое удилище для твичинга и джига. Отличная чувствительность и мощность.',
                'price' => 7800,
                'category_id' => $categories->where('slug', 'spinning-rods')->first()->id,
                'brand_id' => $brands->where('slug', 'daiwa')->first()->id,
                'features' => json_encode([
                    'Длина' => '2.7 м',
                    'Тест' => '10-40 г',
                    'Строй' => 'Быстрый',
                    'Материал' => 'Карбон',
                    'Вес' => '165 г'
                ])
            ],

            // Катушки
            [
                'name' => 'Shimano Nexave FA 4000',
                'slug' => 'shimano-nexave-fa-4000',
                'description' => 'Надежная безынерционная катушка для спиннинговой ловли. Плавный ход и качественная укладка лески.',
                'price' => 3200,
                'old_price' => 3800,
                'category_id' => $categories->where('slug', 'spinning-reels')->first()->id,
                'brand_id' => $brands->where('slug', 'shimano')->first()->id,
                'features' => json_encode([
                    'Размер' => '4000',
                    'Подшипники' => '4+1',
                    'Вес' => '320 г',
                    'Передаточное число' => '5.2:1',
                    'Фрикцион' => 'Передний'
                ])
            ],
            [
                'name' => 'Daiwa Regal LT 2500',
                'slug' => 'daiwa-regal-lt-2500',
                'description' => 'Легкая и мощная катушка с технологией LT. Идеальна для ультралайта и лайта.',
                'price' => 5600,
                'category_id' => $categories->where('slug', 'spinning-reels')->first()->id,
                'brand_id' => $brands->where('slug', 'daiwa')->first()->id,
                'features' => json_encode([
                    'Размер' => '2500',
                    'Подшипники' => '6+1',
                    'Вес' => '210 г',
                    'Передаточное число' => '5.8:1',
                    'Фрикцион' => 'Задний'
                ])
            ],

            // Воблеры
            [
                'name' => 'Pontoon 21 Crackjack 58',
                'slug' => 'pontoon-21-crackjack-58',
                'description' => 'Популярный воблер для ловли окуня и щуки. Отличная игра на равномерной проводке.',
                'price' => 650,
                'category_id' => $categories->where('slug', 'crankbaits')->first()->id,
                'brand_id' => $brands->where('slug', 'pontoon-21')->first()->id,
                'features' => json_encode([
                    'Длина' => '58 мм',
                    'Вес' => '5 г',
                    'Заглубление' => '0.5-1 м',
                    'Тип' => 'Поппер',
                    'Цвет' => 'Mat Tiger'
                ])
            ],
            [
                'name' => 'Megabass Vision 110',
                'slug' => 'megabass-vision-110',
                'description' => 'Легендарный воблер от Megabass. Идеален для ловли активного хищника.',
                'price' => 2200,
                'category_id' => $categories->where('slug', 'crankbaits')->first()->id,
                'brand_id' => $brands->where('slug', 'megabass')->first()->id,
                'features' => json_encode([
                    'Длина' => '110 мм',
                    'Вес' => '14 г',
                    'Заглубление' => '1-1.5 м',
                    'Тип' => 'Крэнк',
                    'Цвет' => 'Gill'
                ])
            ],

            // Силиконовые приманки
            [
                'name' => 'Salmo Slim 10cm',
                'slug' => 'salmo-slim-10cm',
                'description' => 'Узкотелая силиконовая приманка для ловли судака и щуки. Отличная игра на джиг-головке.',
                'price' => 180,
                'category_id' => $categories->where('slug', 'soft-baits')->first()->id,
                'brand_id' => $brands->where('slug', 'salmo')->first()->id,
                'features' => json_encode([
                    'Длина' => '10 см',
                    'Вес' => '12 г',
                    'Материал' => 'Силикон',
                    'Количество в упаковке' => '5 шт',
                    'Цвет' => 'Motor Oil'
                ])
            ],

            // Крючки
            [
                'name' => 'Owner Cutting Point 5310',
                'slug' => 'owner-cutting-point-5310',
                'description' => 'Острые и надежные крючки для ловли хищной рыбы. Отличное качество заточки.',
                'price' => 450,
                'category_id' => $categories->where('slug', 'hooks')->first()->id,
                'brand_id' => $brands->where('slug', 'owner')->first()->id,
                'features' => json_encode([
                    'Размер' => '1/0',
                    'Тип' => 'Офсетный',
                    'Материал' => 'Сталь',
                    'Количество в упаковке' => '10 шт',
                    'Покрытие' => 'Black Nickel'
                ])
            ],

            // Плетеные шнуры
            [
                'name' => 'Daiwa J-Braid 8x Grand 0.12mm',
                'slug' => 'daiwa-jbraid-8x-012',
                'description' => 'Качественный плетеный шнур с 8-жильной структурой. Отличная прочность и минимальная растяжимость.',
                'price' => 1200,
                'category_id' => $categories->where('slug', 'braided-lines')->first()->id,
                'brand_id' => $brands->where('slug', 'daiwa')->first()->id,
                'features' => json_encode([
                    'Диаметр' => '0.12 мм',
                    'Разрывная нагрузка' => '12 кг',
                    'Длина' => '150 м',
                    'Материал' => 'Полиэтилен',
                    'Цвет' => 'Зеленый'
                ])
            ],

            // Эхолоты
            [
                'name' => 'Lowrance Hook2 4x Bullet',
                'slug' => 'lowrance-hook2-4x-bullet',
                'description' => 'Простой и надежный эхолот для начинающих рыболовов. Отличное качество изображения.',
                'price' => 12500,
                'old_price' => 14500,
                'category_id' => $categories->where('slug', 'fish-finders')->first()->id,
                'brand_id' => $brands->where('slug', 'shimano')->first()->id,
                'features' => json_encode([
                    'Диагональ экрана' => '4 дюйма',
                    'Разрешение' => '480x272',
                    'GPS' => 'Есть',
                    'Луч' => 'Двухлучевой',
                    'Глубина сканирования' => '150 м'
                ])
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

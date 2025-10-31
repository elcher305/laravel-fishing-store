<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class FishingCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Спиннинги',
                'children' => ['Ультралайт', 'Лайт', 'Медиум', 'Хэви', 'Троллинговые']
            ],
            [
                'name' => 'Катушки',
                'children' => ['Безынерционные', 'Мультипликаторные', 'Инерционные', 'Электрические']
            ],
            [
                'name' => 'Приманки',
                'children' => ['Воблеры', 'Блесны', 'Силиконовые приманки', 'Попперы', 'Джеркбейты']
            ],
            [
                'name' => 'Лески и шнуры',
                'children' => ['Плетеные шнуры', 'Монофильные лески', 'Флюорокарбоновые']
            ],
            [
                'name' => 'Крючки и оснастка',
                'children' => ['Крючки', 'Грузила', 'Поплавки', 'Вертлюги', 'Каребаны']
            ],
            [
                'name' => 'Экипировка',
                'children' => ['Одежда', 'Обувь', 'Головные уборы', 'Перчатки']
            ],
            [
                'name' => 'Аксессуары',
                'children' => ['Подсаки', 'Садки', 'Коробки', 'Чехлы', 'Ящики']
            ]
        ];

        foreach ($categories as $categoryData) {
            $parent = Category::create([
                'name' => $categoryData['name'],
                'slug' => \Str::slug($categoryData['name']),
                'is_active' => true
            ]);

            foreach ($categoryData['children'] as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => \Str::slug($childName),
                    'parent_id' => $parent->id,
                    'is_active' => true
                ]);
            }
        }
    }
}

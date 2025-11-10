<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Спиннинги', 'slug' => 'spinning-rods'],
            ['name' => 'Фидерные удилища', 'slug' => 'feeder-rods'],
            ['name' => 'Поплавочные удочки', 'slug' => 'float-rods'],
            ['name' => 'Безынерционные катушки', 'slug' => 'spinning-reels'],
            ['name' => 'Мультипликаторные катушки', 'slug' => 'multiplier-reels'],
            ['name' => 'Плетеные шнуры', 'slug' => 'braided-lines'],
            ['name' => 'Монофильные лески', 'slug' => 'monofilament-lines'],
            ['name' => 'Воблеры', 'slug' => 'crankbaits'],
            ['name' => 'Вращающиеся блесны', 'slug' => 'spinners'],
            ['name' => 'Колеблющиеся блесны', 'slug' => 'spoons'],
            ['name' => 'Силиконовые приманки', 'slug' => 'soft-baits'],
            ['name' => 'Крючки', 'slug' => 'hooks'],
            ['name' => 'Грузила', 'slug' => 'sinkers'],
            ['name' => 'Поплавки', 'slug' => 'floats'],
            ['name' => 'Эхолоты', 'slug' => 'fish-finders'],
            ['name' => 'Подсачеки', 'slug' => 'landing-nets'],
            ['name' => 'Садки', 'slug' => 'keep-nets'],
            ['name' => 'Ящики рыболовные', 'slug' => 'fishing-boxes'],
            ['name' => 'Одежда и обувь', 'slug' => 'clothing-footwear'],
        ];


        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

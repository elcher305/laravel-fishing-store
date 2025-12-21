<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Удочки',
                'slug' => 'rods',
                'description' => 'Спиннинги, маховые удочки, фидеры'
            ],
            [
                'name' => 'Катушки',
                'slug' => 'reels',
                'description' => 'Безынерционные, инерционные катушки'
            ],
            [
                'name' => 'Лески и шнуры',
                'slug' => 'lines',
                'description' => 'Монофил, плетеные шнуры, флюрокарбон'
            ],
            [
                'name' => 'Приманки',
                'slug' => 'lures',
                'description' => 'Блесны, воблеры, силиконовые приманки'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

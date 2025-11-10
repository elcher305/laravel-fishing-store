<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Shimano', 'slug' => 'shimano'],
            ['name' => 'Daiwa', 'slug' => 'daiwa'],
            ['name' => 'Salmo', 'slug' => 'salmo'],
            ['name' => 'Pontoon 21', 'slug' => 'pontoon-21'],
            ['name' => 'ZipBaits', 'slug' => 'zipbaits'],
            ['name' => 'Megabass', 'slug' => 'megabass'],
            ['name' => 'Jackall', 'slug' => 'jackall'],
            ['name' => 'Yo-Zuri', 'slug' => 'yo-zuri'],
            ['name' => 'Rapala', 'slug' => 'rapala'],
            ['name' => 'Kuusamo', 'slug' => 'kuusamo'],
            ['name' => 'Owner', 'slug' => 'owner'],
            ['name' => 'Gamakatsu', 'slug' => 'gamakatsu'],
            ['name' => 'Sensas', 'slug' => 'sensas'],
            ['name' => 'Traper', 'slug' => 'traper'],
            ['name' => 'Fox', 'slug' => 'fox'],
            ['name' => 'Preston', 'slug' => 'preston'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}

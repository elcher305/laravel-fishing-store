<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class FishingBrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Shimano', 'country' => 'Japan'],
            ['name' => 'Daiwa', 'country' => 'Japan'],
            ['name' => 'Salmo', 'country' => 'Poland'],
            ['name' => 'ZipBaits', 'country' => 'Japan'],
            ['name' => 'Pontoon21', 'country' => 'Russia'],
            ['name' => 'Jackall', 'country' => 'Japan'],
            ['name' => 'Yo-Zuri', 'country' => 'Japan'],
            ['name' => 'Megabass', 'country' => 'Japan'],
            ['name' => 'Kuusamo', 'country' => 'Finland'],
            ['name' => 'Stinger', 'country' => 'Ukraine']
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => \Str::slug($brand['name']),
                'country' => $brand['country'],
                'is_active' => true
            ]);
        }
    }
}

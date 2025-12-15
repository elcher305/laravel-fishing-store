<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Показать каталог товаров (ваш HTML шаблон)
    public function index()
    {
        // Получаем все товары
        $products = Product::all();

        // Возвращаем представление с вашим HTML
        return view('catalog.catalog', compact('products'));
    }

    // Показать отдельный товар
    public function show(Product $product)
    {
        return view('catalog.show', compact('product'));
    }

    // Фильтрация товаров (если нужно)
    public function filter(Request $request)
    {
        $query = Product::query();

        // Фильтр по цене
        if ($request->has('price')) {
            switch ($request->price) {
                case 'low':
                    $query->where('price', '<', 500);
                    break;
                case 'medium':
                    $query->whereBetween('price', [1000, 3000]);
                    break;
                case 'high':
                    $query->where('price', '>', 3000);
                    break;
            }
        }

        // Фильтр по категории
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->get();

        return view('catalog.catalog', compact('products'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Параметры фильтрации
        $search = $request->input('search');
        $category = $request->input('category');
        $brands = $request->input('brands', []);
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $minRating = $request->input('min_rating');
        $inStock = $request->input('in_stock');
        $sort = $request->input('sort', 'newest');

        // Запрос товаров
        $products = Product::with(['category', 'brand']);

        // Применяем фильтры
        if ($search) {
            $products->search($search);
        }

        if ($category) {
            $products->category($category);
        }

        if (!empty($brands)) {
            $products->brand($brands);
        }

        if ($minPrice && $maxPrice) {
            $products->priceRange($minPrice, $maxPrice);
        }

        if ($minRating) {
            $products->rating($minRating);
        }

        if ($inStock) {
            $products->inStock();
        }

        // Сортировка
        switch ($sort) {
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            case 'rating':
                $products->orderBy('rating', 'desc');
                break;
            case 'popular':
                $products->orderBy('review_count', 'desc');
                break;
            case 'newest':
            default:
                $products->orderBy('created_at', 'desc');
                break;
        }

        $products = $products->paginate(12)->withQueryString();

        // Данные для фильтров
        $categories = Category::withCount('products')->get();
        $brandsList = Brand::withCount('products')->get();
        $maxProductPrice = Product::max('price');

        return view('catalog.index', compact(
            'products', 'categories', 'brandsList', 'maxProductPrice',
            'search', 'category', 'brands', 'minPrice', 'maxPrice',
            'minRating', 'inStock', 'sort'
        ));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'brand', 'reviews.user'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->with(['brand'])
            ->paginate(12);

        return view('catalog.category', compact('category', 'products'));
    }
}

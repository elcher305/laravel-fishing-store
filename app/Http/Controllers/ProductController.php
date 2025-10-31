<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images'])
            ->active()
            ->withCount('reviews');

        // Фильтрация по категории
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $categoryIds = $category->getAllCategoryIds();
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Фильтрация по бренду
        if ($request->has('brand') && $request->brand) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->brand_id);
            }
        }

        // Фильтрация по цене
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Фильтрация по наличию
        if ($request->has('in_stock')) {
            $query->inStock();
        }

        // Поиск
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Сортировка
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('product_name');
                break;
            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;
            case 'popular':
                $query->orderBy('reviews_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->get();
        $featuredProducts = Product::with(['images'])->featured()->active()->inStock()->limit(4)->get();

        return view('products.index', compact('products', 'categories', 'brands', 'featuredProducts'));
    }

    public function show($slug)
    {
        $product = Product::with([
            'category',
            'brand',
            'images',
            'reviews.user',
            'reviews' => function($query) {
                $query->approved()->latest();
            }
        ])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Увеличиваем счетчик просмотров
        $product->increment('views_count');

        $relatedProducts = $product->getRelatedProducts(4);

        // Средний рейтинг и распределение оценок
        $ratingStats = Review::where('product_id', $product->product_id)
            ->approved()
            ->select(
                DB::raw('AVG(rating) as average_rating'),
                DB::raw('COUNT(*) as total_reviews'),
                DB::raw('COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star'),
                DB::raw('COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star'),
                DB::raw('COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star'),
                DB::raw('COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star'),
                DB::raw('COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star')
            )
            ->first();

        return view('products.show', compact('product', 'relatedProducts', 'ratingStats'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('q');

        if (!$searchTerm) {
            return redirect()->route('products.index');
        }

        $products = Product::with(['category', 'brand', 'images'])
            ->search($searchTerm)
            ->active()
            ->paginate(12);

        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->get();

        return view('products.search', compact('products', 'categories', 'brands', 'searchTerm'));
    }

    public function byCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->active()
            ->firstOrFail();

        $products = Product::with(['category', 'brand', 'images'])
            ->whereIn('category_id', $category->getAllCategoryIds())
            ->active()
            ->paginate(12);

        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->get();

        return view('products.category', compact('products', 'categories', 'brands', 'category'));
    }

    public function byBrand($brandSlug)
    {
        $brand = Brand::where('slug', $brandSlug)
            ->active()
            ->firstOrFail();

        $products = Product::with(['category', 'brand', 'images'])
            ->where('brand_id', $brand->brand_id)
            ->active()
            ->paginate(12);

        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->get();

        return view('products.brand', compact('products', 'categories', 'brands', 'brand'));
    }

    public function newArrivals()
    {
        $products = Product::with(['category', 'brand', 'images'])
            ->new()
            ->active()
            ->latest()
            ->paginate(12);

        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->get();

        return view('products.new-arrivals', compact('products', 'categories', 'brands'));
    }

    public function featured()
    {
        $products = Product::with(['category', 'brand', 'images'])
            ->featured()
            ->active()
            ->latest()
            ->paginate(12);

        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->get();

        return view('products.featured', compact('products', 'categories', 'brands'));
    }

    public function onSale()
    {
        $products = Product::with(['category', 'brand', 'images'])
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->active()
            ->latest()
            ->paginate(12);

        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->get();

        return view('products.on-sale', compact('products', 'categories', 'brands'));
    }
}

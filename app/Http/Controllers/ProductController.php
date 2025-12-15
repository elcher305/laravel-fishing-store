<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Показать каталог товаров
    public function index(Request $request)
    {
        $query = Product::query();

        // Фильтрация по категории
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Фильтрация по бренду
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        // Фильтрация по цене
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Сортировка
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        $products = $query->paginate(12);
        $categories = Product::distinct()->pluck('category');
        $brands = Product::distinct()->pluck('brand');

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    // Показать детали товара
    public function show(Product $product)
    {
        $reviews = $product->reviews()
            ->with('user')
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $similarProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Проверяем, покупал ли пользователь этот товар
        $canReview = false;
        if (auth()->check()) {
            $canReview = auth()->user()->orders()
                    ->where('status', 'delivered')
                    ->whereHas('items', function ($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })
                    ->exists() &&
                !$product->reviews()->where('user_id', auth()->id())->exists();
        }

        return view('products.show', compact('product', 'reviews', 'similarProducts', 'canReview'));
    }


    public function create()
    {
        return view('admin.products.create'); // или ваша форма
    }

    // Сохраняем новый продукт
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обработка загрузки изображения (если есть)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Создаем продукт
        Product::create($validated);

        // Редирект с сообщением об успехе
        return redirect()->route('admin.products.index')
            ->with('success', 'Продукт успешно создан!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'creator']);

        // Поиск
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Фильтры
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'featured':
                    $query->featured();
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0);
                    break;
            }
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Генерация slug и sku
        $validated['slug'] = Product::generateSlug($validated['name']);
        $validated['sku'] = 'PROD-' . strtoupper(Str::random(8));

        // Обработка изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Булевые значения
        $validated['is_featured'] = $request->has('is_featured');
        $validated['in_stock'] = $validated['stock_quantity'] > 0;

        // Создание товара
        $product = Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно создан!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обновление slug если изменилось название
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Product::generateSlug($validated['name']);
        }

        // Обработка изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Булевые значения
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['in_stock'] = $validated['stock_quantity'] > 0;

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен!');
    }

    public function destroy(Product $product)
    {
        // Удаляем изображение
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно удален!');
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $product->updateStock($request->stock_quantity);

        return response()->json([
            'success' => true,
            'stock_status' => $product->stock_status_text
        ]);
    }

    public function toggleStatus(Product $product)
    {
        $product->is_active ? $product->deactivate() : $product->activate();

        return response()->json([
            'success' => true,
            'is_active' => $product->is_active,
            'message' => $product->is_active ? 'Товар активирован' : 'Товар деактивирован'
        ]);
    }

    public function toggleFeatured(Product $product)
    {
        $product->toggleFeatured();

        return response()->json([
            'success' => true,
            'is_featured' => $product->is_featured,
            'message' => $product->is_featured ? 'Товар добавлен в избранное' : 'Товар убран из избранного'
        ]);
    }
}

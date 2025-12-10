<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Метод для отображения списка товаров
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // Метод для отображения формы создания товара
    public function create()
    {
        return view('products.create');
    }

    // Метод для сохранения нового товара
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);


        // Обработка изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }



        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно добавлен.');
    }

    // Метод для отображения формы редактирования
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Метод для обновления товара
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);



        // Обработка изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно обновлен.');
    }

    // Метод для удаления товара
    public function destroy(Product $product)
    {
        // Удаляем изображение
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно удален.');
    }

    // Метод для отображения товара (опционально)
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}

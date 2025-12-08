<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Список всех товаров
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // Форма создания товара
    public function create()
    {
        $categories = $this->getCategories();
        return view('products.create', compact('categories'));
    }

    // Сохранение нового товара
    public function store(Request $request)
    {
        // Валидация
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string',
            'characteristics.*.key' => 'nullable|string',
            'characteristics.*.value' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Обработка изображения
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Подготовка характеристик
        $characteristics = [];
        if ($request->has('characteristics')) {
            foreach ($request->characteristics as $char) {
                if (!empty($char['key']) && !empty($char['value'])) {
                    $characteristics[] = [
                        'key' => $char['key'],
                        'value' => $char['value']
                    ];
                }
            }
        }

        // Создание товара
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'category' => $request->category,
            'characteristics' => !empty($characteristics) ? $characteristics : null,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно добавлен!');
    }

    // Просмотр товара
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Форма редактирования товара
    public function edit(Product $product)
    {
        $categories = $this->getCategories();
        return view('products.edit', compact('product', 'categories'));
    }

    // Обновление товара
    public function update(Request $request, Product $product)
    {
        // Валидация
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string',
            'characteristics.*.key' => 'nullable|string',
            'characteristics.*.value' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Обработка изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Сохраняем новое
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // Подготовка характеристик
        $characteristics = [];
        if ($request->has('characteristics')) {
            foreach ($request->characteristics as $char) {
                if (!empty($char['key']) && !empty($char['value'])) {
                    $characteristics[] = [
                        'key' => $char['key'],
                        'value' => $char['value']
                    ];
                }
            }
        }

        // Обновление товара
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category' => $request->category,
            'characteristics' => !empty($characteristics) ? $characteristics : null,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно обновлен!');
    }

    // Удаление товара
    public function destroy(Product $product)
    {
        // Удаляем изображение
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Мягкое удаление
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно удален!');
    }

    // Восстановление удаленного товара
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно восстановлен!');
    }

    // Полное удаление
    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        // Удаляем изображение
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->forceDelete();

        return redirect()->route('products.index')
            ->with('success', 'Товар полностью удален!');
    }

    // Список категорий товаров
    private function getCategories()
    {
        return [
            'Удилища' => 'Удилища',
            'Катушки' => 'Катушки',
            'Лески и шнуры' => 'Лески и шнуры',
            'Крючки' => 'Крючки',
            'Приманки' => 'Приманки',
            'Грузила и поплавки' => 'Грузила и поплавки',
            'Экипировка' => 'Экипировка',
            'Аксессуары' => 'Аксессуары',
            'Наживка' => 'Наживка',
            'Другое' => 'Другое'
        ];
    }
}

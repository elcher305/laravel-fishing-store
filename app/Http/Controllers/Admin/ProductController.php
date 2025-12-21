<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Controllers\Admin\StoreProductRequest;
use App\Http\Controllers\Admin\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // Обработка изображения
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Обработка характеристик
        if ($request->has('characteristics')) {
            $characteristics = [];
            foreach ($request->characteristics['key'] as $index => $key) {
                if (!empty($key) && !empty($request->characteristics['value'][$index])) {
                    $characteristics[$key] = $request->characteristics['value'][$index];
                }
            }
            $data['characteristics'] = $characteristics;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно добавлен');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Обработка изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Обработка характеристик
        if ($request->has('characteristics')) {
            $characteristics = [];
            foreach ($request->characteristics['key'] as $index => $key) {
                if (!empty($key) && !empty($request->characteristics['value'][$index])) {
                    $characteristics[$key] = $request->characteristics['value'][$index];
                }
            }
            $data['characteristics'] = $characteristics;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен');
    }

    public function destroy(Product $product)
    {
        // Удаляем изображение
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно удален');
    }



}

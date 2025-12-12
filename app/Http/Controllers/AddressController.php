<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Показать список адресов
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();

        return view('addresses.index', compact('addresses'));
    }

    // Показать форму создания адреса
    public function create()
    {
        return view('addresses.create');
    }

    // Сохранить новый адрес
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'full_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:50',
            'region' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:200',
            'house' => 'required|string|max:10',
            'apartment' => 'nullable|string|max:10',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'boolean',
        ]);

        // Если устанавливаем как адрес по умолчанию, снимаем флаг с других
        if ($request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address = Auth::user()->addresses()->create($request->all());

        return redirect()->route('addresses.index')
            ->with('success', 'Адрес успешно добавлен');
    }

    // Показать форму редактирования адреса
    public function edit(Address $address)
    {
        $this->authorize('update', $address);

        return view('addresses.edit', compact('address'));
    }

    // Обновить адрес
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $request->validate([
            'title' => 'required|string|max:100',
            'full_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:50',
            'region' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:200',
            'house' => 'required|string|max:10',
            'apartment' => 'nullable|string|max:10',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'boolean',
        ]);

        // Если устанавливаем как адрес по умолчанию, снимаем флаг с других
        if ($request->is_default) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($request->all());

        return redirect()->route('addresses.index')
            ->with('success', 'Адрес успешно обновлен');
    }

    // Удалить адрес
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        // Нельзя удалить адрес, если он используется в заказах
        if ($address->orders()->exists()) {
            return back()->with('error', 'Нельзя удалить адрес, который используется в заказах');
        }

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Адрес успешно удален');
    }
}

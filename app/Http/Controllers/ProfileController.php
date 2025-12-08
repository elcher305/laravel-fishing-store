<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // 1) Просматривать личный профиль
    public function show()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(5);

        return view('profile.show', compact('user', 'orders'));
    }

    // 2) Форма редактирования профиля
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // 3) Обновление профиля
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'fishing_experience' => 'required|in:beginner,amateur,professional',
            'favorite_fishing_type' => 'nullable|string|max:100',
            'about' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Обработка аватарки
        if ($request->hasFile('avatar')) {
            // Удаляем старую аватарку
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Сохраняем новую
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Обновляем данные пользователя
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'fishing_experience' => $request->fishing_experience,
            'favorite_fishing_type' => $request->favorite_fishing_type,
            'about' => $request->about
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Профиль успешно обновлен!');
    }

    // 4) Форма изменения пароля
    public function editPassword()
    {
        return view('profile.password');
    }

    // 5) Изменение пароля
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = Auth::user();

        // Проверяем текущий пароль
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Текущий пароль неверен'
            ]);
        }

        // Обновляем пароль
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Пароль успешно изменен!');
    }

    // 6) Удаление аватарки
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return back()->with('success', 'Аватарка удалена');
    }
}

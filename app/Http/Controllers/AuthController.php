<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Показать форму регистрации
    public function showRegister()
    {
        return view('auth.register');
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        // Простая валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Создаем пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Автоматически входим после регистрации
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Регистрация успешна!');
    }

    // Показать форму входа
    public function showLogin()
    {
        return view('auth.login');
    }

    // Обработка входа
    public function login(Request $request)
    {
        // Валидация
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Попытка аутентификации
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard')->with('success', 'Вход выполнен!');
        }

        // Если аутентификация не удалась
        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ])->onlyInput('email');
    }

    // Выход из системы
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Вы вышли из системы.');
    }

    // Показать форму восстановления пароля
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Отправить ссылку для сброса пароля (упрощенная версия)
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);


        return back()->with('status', 'Ссылка для сброса пароля отправлена на email (в реальном проекте).');
    }
}

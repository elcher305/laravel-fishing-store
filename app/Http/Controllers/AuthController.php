<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

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
        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Создание пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Автоматический вход после регистрации
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Регистрация успешна!');
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
            return redirect()->route('dashboard')->with('success', 'Добро пожаловать!');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ]);
    }

    // Выход
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

    // Отправка ссылки для восстановления
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Простая реализация - в реальном проекте используйте Laravel Password
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Здесь обычно отправляется email со ссылкой
            // Для простоты просто покажем сообщение
            return back()->with('status', 'Если email существует, мы отправили ссылку для сброса пароля.');
        }

        return back()->withErrors(['email' => 'Пользователь с таким email не найден.']);
    }

    // Показать форму сброса пароля
    public function showResetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Обработка сброса пароля
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Простая реализация - в реальном проекте проверяйте токен
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login')->with('success', 'Пароль успешно изменен!');
        }

        return back()->withErrors(['email' => 'Не удалось сбросить пароль.']);
    }
}

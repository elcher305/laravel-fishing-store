<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.form')->with('error', 'Для доступа к этой странице необходимо войти в систему');
        }

        if (!Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Требуются права администратора.');
        }

        return $next($request);
    }
}

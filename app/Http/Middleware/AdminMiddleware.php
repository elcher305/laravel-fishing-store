<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему');
        }

        if (!Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'У вас нет прав доступа к админ-панели');
        }

        return $next($request);
    }
}

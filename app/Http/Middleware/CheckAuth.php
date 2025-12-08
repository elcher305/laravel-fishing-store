<?php
// app/Http/Middleware/CheckAuth.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->route('login')
                ->with('error', 'Пожалуйста, войдите в систему');
        }

        return $next($request);
    }
}

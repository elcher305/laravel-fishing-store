<?php

namespace App\Http\Middleware;

use App\Providers\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MergeCarts
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !session('carts_merged')) {
            $this->cartService->mergeCarts(Auth::user());
            session(['carts_merged' => true]);
        }

        return $next($request);
    }
}

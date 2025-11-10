<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'total_orders' => Order::count(),
            'low_stock_products' => Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count(),
            'out_of_stock_products' => Product::where('stock_quantity', 0)->count(),
        ];

        $recentProducts = Product::with(['category', 'brand'])->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)
            ->where('stock_quantity', '>', 0)
            ->with('category')
            ->orderBy('stock_quantity')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'lowStockProducts'));
    }
}

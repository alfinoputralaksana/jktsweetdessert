<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        
        $recentOrders = Order::with('items')->latest()->limit(10)->get();
        $topProducts = Product::orderBy('sold_count', 'desc')->limit(5)->get();

        $monthlySales = Order::where('payment_status', 'paid')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalCategories',
            'totalRevenue',
            'recentOrders',
            'topProducts',
            'monthlySales'
        ));
    }
}

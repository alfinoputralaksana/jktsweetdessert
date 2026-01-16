<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $lowStockProducts = Product::where('stock', '<', 10)->where('is_active', true)->count();

        $recentOrders = Order::with('items')->orderBy('created_at', 'desc')->limit(10)->get();
        $lowStockItems = Product::where('stock', '<', 10)->where('is_active', true)->limit(5)->get();

        return view('karyawan.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'lowStockProducts',
            'recentOrders',
            'lowStockItems'
        ));
    }
}

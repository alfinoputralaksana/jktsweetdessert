<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orWhere('customer_email', $user->email)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $totalOrders = Order::where('user_id', $user->id)
            ->orWhere('customer_email', $user->email)
            ->count();

        $totalSpent = Order::where('user_id', $user->id)
            ->orWhere('customer_email', $user->email)
            ->where('payment_status', 'paid')
            ->sum('total');

        return view('user.dashboard', compact('user', 'orders', 'totalOrders', 'totalSpent'));
    }
}

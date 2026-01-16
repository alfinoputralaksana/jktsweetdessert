<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment_status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('payment_status', 'paid')->count();

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'paidOrders'
        ));
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['user', 'items.product'])
            ->firstOrFail();

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $orderNumber)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function processOrder($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Process order: set payment to paid and status to processing
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diproses',
                'order' => [
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil diproses');
    }

    public function shipOrder($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Update status to shipped (Di Antar)
        $order->update([
            'status' => 'shipped',
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diubah status menjadi Di Antar',
                'order' => [
                    'status' => $order->status,
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil diubah status menjadi Di Antar');
    }
}


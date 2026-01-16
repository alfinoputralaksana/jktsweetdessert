<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\MidtransService;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $products = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ];
                $subtotal += $product->price * $item['quantity'];
            }
        }

        // Shipping cost only for delivery
        $deliveryType = old('delivery_type', 'delivery');
        $shippingCost = 0;
        
        // If delivery and province is provided, calculate shipping
        if ($deliveryType === 'delivery' && old('customer_province')) {
            $shippingService = new ShippingService();
            $shippingResult = $shippingService->calculateShipping(
                old('customer_province'),
                old('customer_city', ''),
                old('customer_postal_code', ''),
                1.0,
                'zone', // Selalu gunakan zone-based
                old('customer_address', '')
            );
            $shippingCost = $shippingResult['cost'];
        } elseif ($deliveryType === 'delivery') {
            // Default shipping cost if province not selected yet
            $shippingCost = 0; // Akan dihitung otomatis saat user pilih provinsi
        }
        
        $total = $subtotal + $shippingCost;

        return view('orders.checkout', compact('products', 'subtotal', 'shippingCost', 'total', 'deliveryType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required_if:delivery_type,delivery|nullable|string',
            'customer_province' => 'required_if:delivery_type,delivery|nullable|string|max:255',
            'customer_city' => 'required_if:delivery_type,delivery|nullable|string|max:255',
            'customer_postal_code' => 'nullable|string|max:10',
            'delivery_type' => 'required|in:self_pickup,delivery',
            'payment_method' => 'required|in:qris,virtual_account,cash',
            'va_bank' => 'required_if:payment_method,virtual_account|nullable|in:bca,bni,mandiri,permata,bri,cimb,danamon',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $products = [];

            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                if (!$product || $product->stock < $item['quantity']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
                }
                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];
                $subtotal += $product->price * $item['quantity'];
            }

            // Calculate shipping cost for delivery
            $shippingCost = 0;
            if ($request->delivery_type === 'delivery') {
                $shippingService = new ShippingService();
                $shippingResult = $shippingService->calculateShipping(
                    $request->customer_province ?? '',
                    $request->customer_city ?? '',
                    $request->customer_postal_code ?? '',
                    1.0, // Default weight 1kg
                    'zone', // Selalu gunakan zone-based
                    $request->customer_address ?? ''
                );
                $shippingCost = $shippingResult['cost'];
            }
            $total = $subtotal + $shippingCost;

            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->delivery_type === 'self_pickup' ? 'Self Pickup' : ($request->customer_address ?? ''),
                'customer_province' => $request->delivery_type === 'self_pickup' ? null : ($request->customer_province ?? null),
                'customer_city' => $request->delivery_type === 'self_pickup' ? null : ($request->customer_city ?? null),
                'customer_postal_code' => $request->delivery_type === 'self_pickup' ? null : ($request->customer_postal_code ?? null),
                'delivery_type' => $request->delivery_type,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'shipping_provider' => 'Estimasi Manual',
                'total' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'payment_status' => 'pending',
                'notes' => $request->notes,
            ]);

            foreach ($products as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'price' => $item['product']->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['product']->price * $item['quantity'],
                ]);

                // Update stock and sold count
                $item['product']->decrement('stock', $item['quantity']);
                $item['product']->increment('sold_count', $item['quantity']);
            }

            // Handle payment gateway for QRIS and Virtual Account
            if (in_array($request->payment_method, ['qris', 'virtual_account'])) {
                $midtransService = new MidtransService();
                $paymentType = $request->payment_method === 'qris' ? 'qris' : 'bank_transfer';
                
                // Get bank code for Virtual Account
                $bankCode = null;
                if ($request->payment_method === 'virtual_account' && $request->va_bank) {
                    $bankCode = $request->va_bank;
                }
                
                try {
                    // Create transaction using Core API
                    $response = $midtransService->createTransaction($order, $paymentType, $bankCode);
                    
                    // Log full response for debugging
                    Log::info('Midtrans Response for Order: ' . $order->order_number, [
                        'response_type' => gettype($response),
                        'response' => is_object($response) ? json_encode($response) : $response
                    ]);
                    
                    // Extract payment information directly from response
                    $paymentInfo = $midtransService->extractPaymentInfo($response);
                    
                    // Log extracted payment info
                    Log::info('Extracted Payment Info', [
                        'order_id' => $order->order_number,
                        'payment_info' => $paymentInfo
                    ]);
                    
                    // Update order with payment information
                    $updateData = [
                        'midtrans_order_id' => $order->order_number,
                        'midtrans_transaction_id' => is_object($response) ? ($response->transaction_id ?? null) : null,
                        'virtual_account_number' => $paymentInfo['virtual_account_number'] ?? null,
                        'virtual_account_bank' => $paymentInfo['virtual_account_bank'] ?? null,
                        'qris_url' => $paymentInfo['qris_url'] ?? null,
                        'qris_image_url' => $paymentInfo['qris_image_url'] ?? null,
                        'payment_instructions' => $paymentInfo['payment_instructions'] ?? null,
                    ];
                    
                    // Handle expiry time
                    if (!empty($paymentInfo['payment_expired_at'])) {
                        $updateData['payment_expired_at'] = date('Y-m-d H:i:s', strtotime($paymentInfo['payment_expired_at']));
                    } else {
                        $updateData['payment_expired_at'] = now()->addHours(1);
                    }
                    
                    $order->update($updateData);
                    
                    // Log final saved data
                    Log::info('Payment info saved to database', [
                        'order_id' => $order->order_number,
                        'va_number' => $order->virtual_account_number,
                        'qris_url' => $order->qris_url ? 'exists' : 'null',
                        'qris_url_length' => $order->qris_url ? strlen($order->qris_url) : 0,
                    ]);
                    
                } catch (\Exception $e) {
                    $errorMessage = $e->getMessage();
                    
                    Log::error('Midtrans transaction creation failed', [
                        'order_id' => $order->order_number,
                        'error' => $errorMessage,
                    ]);
                    
                    // Set default expiry even if payment gateway fails
                    $order->update([
                        'payment_expired_at' => now()->addHours(1),
                    ]);
                    
                    // If it's an authentication error, show user-friendly message
                    if (strpos($errorMessage, 'Server Key') !== false || strpos($errorMessage, '401') !== false) {
                        DB::commit();
                        session()->forget('cart');
                        return redirect()->route('orders.success', $order->order_number)
                            ->with('error', 'Pesanan berhasil dibuat, namun terjadi kesalahan pada sistem pembayaran. Silakan hubungi customer service dengan Order Number: ' . $order->order_number);
                    }
                }
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('orders.success', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();
        
        // If payment method is QRIS or VA but data is missing, try to fetch from Midtrans
        if (in_array($order->payment_method, ['qris', 'virtual_account']) && 
            (empty($order->qris_url) && empty($order->virtual_account_number))) {
            
            try {
                $midtransService = new MidtransService();
                $transactionStatus = $midtransService->getTransactionStatus($order->order_number);
                
                if ($transactionStatus) {
                    $paymentInfo = $midtransService->extractPaymentInfo($transactionStatus);
                    
                    $order->update([
                        'virtual_account_number' => $paymentInfo['virtual_account_number'] ?? $order->virtual_account_number,
                        'virtual_account_bank' => $paymentInfo['virtual_account_bank'] ?? $order->virtual_account_bank,
                        'qris_url' => $paymentInfo['qris_url'] ?? $order->qris_url,
                        'payment_instructions' => $paymentInfo['payment_instructions'] ?? $order->payment_instructions,
                    ]);
                    
                    // Refresh order
                    $order->refresh();
                }
            } catch (\Exception $e) {
                Log::error('Failed to fetch payment info in success page: ' . $e->getMessage());
            }
        }
        
        return view('orders.success', compact('order'));
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items.product')->firstOrFail();
        return view('orders.show', compact('order'));
    }

    public function history(Request $request)
    {
        $user = auth()->user();
        
        $query = Order::where(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('customer_email', $user->email);
        });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment_status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number
        if ($request->filled('search')) {
            $query->where('order_number', 'like', "%{$request->search}%");
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->with('items')->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $totalOrders = Order::where(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('customer_email', $user->email);
        })->count();

        $totalSpent = Order::where(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('customer_email', $user->email);
        })->where('payment_status', 'paid')->sum('total');

        return view('orders.history', compact('orders', 'totalOrders', 'totalSpent'));
    }

    public function confirmOrder($orderNumber)
    {
        $user = auth()->user();
        
        $order = Order::where('order_number', $orderNumber)
            ->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->firstOrFail();

        // Only allow confirmation if order is shipped (Di Antar)
        if ($order->status !== 'shipped') {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan hanya bisa dikonfirmasi jika status sudah Di Antar'
                ], 400);
            }
            return redirect()->back()->with('error', 'Pesanan hanya bisa dikonfirmasi jika status sudah Di Antar');
        }

        // Update status to delivered (completed)
        $order->update([
            'status' => 'delivered',
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikonfirmasi selesai',
                'order' => [
                    'status' => $order->status,
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi selesai');
    }

    /**
     * Calculate shipping cost based on address
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'province' => 'required|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'address' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0.1',
        ]);

        $shippingService = new ShippingService();
        $weight = $request->weight ?? 1.0; // Default 1kg untuk dessert
        
        $result = $shippingService->calculateShipping(
            $request->province,
            $request->city ?? '',
            $request->postal_code ?? '',
            $weight,
            'zone', // Selalu gunakan zone-based
            $request->address ?? ''
        );

        return response()->json([
            'success' => true,
            'shipping_cost' => $result['cost'],
            'estimated_days' => $result['estimated_days'],
            'estimated_minutes' => $result['estimated_minutes'] ?? null,
            'zone' => $result['zone'],
            'provider' => $result['provider'] ?? 'Estimasi Manual',
            'message' => $result['message'],
            'distance_km' => $result['distance_km'] ?? null
        ]);
    }
}

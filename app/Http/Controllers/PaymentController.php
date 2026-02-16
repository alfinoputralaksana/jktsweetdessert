<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        try {
            $midtransService = new MidtransService();
            $transactionStatus = $midtransService->getTransactionStatus($request->order_id);

            if (!$transactionStatus) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            $order = Order::where('order_number', $request->order_id)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            DB::beginTransaction();
            try {
                $status = $transactionStatus->transaction_status;
                $fraudStatus = $transactionStatus->fraud_status ?? null;

                if ($status == 'capture') {
                    if ($fraudStatus == 'challenge') {
                        $order->payment_status = 'pending';
                    } else if ($fraudStatus == 'accept') {
                        $order->payment_status = 'paid';
                        $order->status = 'processing';
                    }
                } else if ($status == 'settlement') {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                } else if ($status == 'pending') {
                    $order->payment_status = 'pending';
                } else if ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                    $order->payment_status = 'failed';
                    $order->status = 'cancelled';
                }

                $order->save();
                DB::commit();

                return response()->json(['message' => 'Payment status updated']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Payment callback error: ' . $e->getMessage());
                return response()->json(['message' => 'Error processing payment'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Payment callback error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing payment'], 500);
        }
    }

    public function notification(Request $request)
    {
        // Handle Midtrans notification
        try {
            $notificationBody = $request->all();
            $orderId = $notificationBody['order_id'] ?? null;
            $signatureKey = $notificationBody['signature_key'] ?? null;

            Log::info('Midtrans notification received', [
                'order_id' => $orderId,
                'status' => $notificationBody['transaction_status'] ?? null,
                'timestamp' => now(),
            ]);

            // Validate signature key for security (mengecek bahwa notifikasi benar-benar dari Midtrans)
            $serverKey = config('services.midtrans.server_key');
            if (!empty($signatureKey) && !empty($serverKey)) {
                $transactionId = $notificationBody['transaction_id'] ?? '';
                $statusCode = $notificationBody['status_code'] ?? '';
                $grossAmount = $notificationBody['gross_amount'] ?? '';
                
                // Hitung expected signature key
                $expectedSignatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
                
                if ($signatureKey !== $expectedSignatureKey) {
                    Log::warning('Invalid signature key for notification', [
                        'order_id' => $orderId,
                        'provided_signature' => substr($signatureKey, 0, 20) . '...',
                        'expected_signature' => substr($expectedSignatureKey, 0, 20) . '...',
                    ]);
                    return response()->json(['message' => 'Invalid signature'], 401);
                }
            }

            if (!$orderId) {
                Log::warning('Notification received without order_id');
                return response()->json(['message' => 'Invalid notification'], 400);
            }

            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                Log::warning('Order not found for notification', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            $midtransService = new MidtransService();
            $transactionStatus = $midtransService->getTransactionStatus($orderId);

            if (!$transactionStatus) {
                Log::warning('Transaction status not found in Midtrans', ['order_id' => $orderId]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            Log::info('Processing payment notification', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus->transaction_status,
                'fraud_status' => $transactionStatus->fraud_status ?? null,
            ]);

            DB::beginTransaction();
            try {
                $status = $transactionStatus->transaction_status;
                $fraudStatus = $transactionStatus->fraud_status ?? null;

                if ($status == 'capture') {
                    if ($fraudStatus == 'challenge') {
                        $order->payment_status = 'pending';
                    } else if ($fraudStatus == 'accept') {
                        $order->payment_status = 'paid';
                        $order->status = 'processing';
                    }
                } else if ($status == 'settlement') {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                } else if ($status == 'pending') {
                    $order->payment_status = 'pending';
                } else if ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                    $order->payment_status = 'failed';
                    $order->status = 'cancelled';
                }

                // Update payment info
                $paymentInfo = $midtransService->extractPaymentInfo($transactionStatus);
                $order->update([
                    'virtual_account_number' => $paymentInfo['virtual_account_number'] ?? $order->virtual_account_number,
                    'qris_url' => $paymentInfo['qris_url'] ?? $order->qris_url,
                    'payment_instructions' => $paymentInfo['payment_instructions'] ?? $order->payment_instructions,
                ]);

                $order->save();
                DB::commit();

                Log::info('Payment notification processed successfully', [
                    'order_id' => $orderId,
                    'new_payment_status' => $order->payment_status,
                ]);

                return response()->json(['message' => 'Notification processed']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Payment notification error: ' . $e->getMessage(), [
                    'order_id' => $orderId,
                    'exception' => (string)$e,
                ]);
                return response()->json(['message' => 'Error processing notification'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Payment notification error: ' . $e->getMessage(), [
                'exception' => (string)$e,
            ]);
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }

    // Retry generating QRIS if it didn't generate during checkout
    public function retryQrisGeneration($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        // Only allow retry for pending orders with no QRIS URL yet
        if ($order->payment_status !== 'pending' || $order->payment_method !== 'qris') {
            return redirect()->back()->with('error', 'Retry hanya tersedia untuk order QRIS yang belum dibayar');
        }
        
        try {
            $service = new MidtransService();
            $response = $service->createTransaction($order, 'qris', 'dana');
            $info = $service->extractPaymentInfo($response);
            
            // Update order with payment information
            $order->update([
                'midtrans_order_id' => $order->order_number,
                'midtrans_transaction_id' => $response->transaction_id ?? null,
                'qris_url' => $info['qris_url'] ?? null,
                'qris_image_url' => $info['qris_image_url'] ?? null,
                'payment_instructions' => $info['payment_instructions'] ?? null,
                'payment_expired_at' => $info['payment_expired_at'] ?? now()->addHours(1),
            ]);
            
            Log::info('QRIS generated successfully on retry', [
                'order_id' => $order->order_number,
                'has_qris_url' => !empty($order->qris_url),
            ]);
            
            return redirect()->route('orders.success', $order->order_number)
                ->with('success', 'QR Code berhasil dibuat! Silakan scan untuk melakukan pembayaran.');
                
        } catch (\Exception $e) {
            Log::error('Retry QRIS generation failed', [
                'order_id' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
            
            return redirect()->back()->with('error', 'Gagal membuat QR Code. Silakan hubungi customer service.');
        }
    }

    /**
     * API endpoint: Get payment status untuk polling
     */
    public function getPaymentStatus($orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }

            // Check status di Midtrans jika masih pending
            if ($order->payment_status === 'pending') {
                \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
                
                try {
                    $transactionStatus = \Midtrans\Transaction::status($orderNumber);
                    
                    // Jika sudah settlement/capture, update database
                    if (in_array($transactionStatus->transaction_status, ['settlement', 'capture'])) {
                        if ($transactionStatus->transaction_status == 'capture' && 
                            isset($transactionStatus->fraud_status) && 
                            $transactionStatus->fraud_status != 'accept') {
                            // Challenge fraud - stay pending
                        } else {
                            $order->payment_status = 'paid';
                            $order->status = 'processing';
                            $order->save();
                            
                            \Log::info('Payment status updated via polling', [
                                'order_id' => $orderNumber,
                                'new_status' => 'paid'
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    \Log::warning('Could not check Midtrans status', ['error' => $e->getMessage()]);
                }
            }

            return response()->json([
                'order_number' => $order->order_number,
                'payment_status' => $order->payment_status,
                'order_status' => $order->status,
                'total' => $order->total,
                'customer_name' => $order->customer_name,
            ]);
        } catch (\Exception $e) {
            \Log::error('getPaymentStatus error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * Test QRIS compatibility dengan DANA
     */
    public function testDanaQris(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $order = null;

        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)->first();
            
            if (!$order) {
                return back()->with('error', 'Order tidak ditemukan: ' . $orderNumber);
            }
            
            if ($order->payment_method !== 'qris') {
                return back()->with('error', 'Order ini bukan menggunakan QRIS payment method');
            }
        }

        return view('payment.test-dana-qris', compact('order'));
    }
}


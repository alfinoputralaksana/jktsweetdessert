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

            if (!$orderId) {
                return response()->json(['message' => 'Invalid notification'], 400);
            }

            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $midtransService = new MidtransService();
            $transactionStatus = $midtransService->getTransactionStatus($orderId);

            if (!$transactionStatus) {
                return response()->json(['message' => 'Transaction not found'], 404);
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

                // Update payment info
                $paymentInfo = $midtransService->extractPaymentInfo($transactionStatus);
                $order->update([
                    'virtual_account_number' => $paymentInfo['virtual_account_number'] ?? $order->virtual_account_number,
                    'qris_url' => $paymentInfo['qris_url'] ?? $order->qris_url,
                    'payment_instructions' => $paymentInfo['payment_instructions'] ?? $order->payment_instructions,
                ]);

                $order->save();
                DB::commit();

                return response()->json(['message' => 'Notification processed']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Payment notification error: ' . $e->getMessage());
                return response()->json(['message' => 'Error processing notification'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Payment notification error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }
}


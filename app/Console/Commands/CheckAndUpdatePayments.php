<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;

class CheckAndUpdatePayments extends Command
{
    protected $signature = 'payment:check-and-update';
    protected $description = 'Check pending payments di Midtrans dan update database jika sudah settlement';

    public function handle()
    {
        $this->info('🔍 Checking pending payments...');
        
        // Get all pending orders
        $pendingOrders = Order::where('payment_status', 'pending')
            ->whereIn('payment_method', ['qris', 'virtual_account'])
            ->get();
        
        if ($pendingOrders->isEmpty()) {
            $this->info('✅ Tidak ada pending orders');
            return;
        }
        
        $this->info("📋 Found {$pendingOrders->count()} pending orders. Checking...");
        
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        
        $updated = 0;
        
        foreach ($pendingOrders as $order) {
            try {
                $transactionStatus = \Midtrans\Transaction::status($order->order_number);
                
                if (in_array($transactionStatus->transaction_status, ['settlement', 'capture'])) {
                    // Check fraud status if capture
                    if ($transactionStatus->transaction_status == 'capture' && 
                        isset($transactionStatus->fraud_status) && 
                        $transactionStatus->fraud_status != 'accept') {
                        continue; // Skip challenged fraud
                    }
                    
                    // Update order
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                    $order->save();
                    
                    $this->line("✅ Updated: {$order->order_number} → PAID");
                    Log::info('Payment updated via command', [
                        'order_number' => $order->order_number,
                        'midtrans_status' => $transactionStatus->transaction_status
                    ]);
                    
                    $updated++;
                }
            } catch (\Exception $e) {
                $this->line("❌ Error checking {$order->order_number}: {$e->getMessage()}");
                Log::error('Payment check error', [
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        $this->info("\n✅ Done! Updated $updated orders");
    }
}

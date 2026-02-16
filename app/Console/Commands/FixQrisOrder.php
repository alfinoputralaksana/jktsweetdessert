<?php

namespace App\Console\Commands;

use App\Services\MidtransService;
use App\Models\Order;
use Illuminate\Console\Command;

class FixQrisOrder extends Command
{
    protected $signature = 'fix:qris {orderId}';
    protected $description = 'Fix QRIS data for order (hit API and update database)';

    public function handle()
    {
        $orderId = $this->argument('orderId');
        $order = Order::find($orderId);

        if (!$order) {
            $this->error("Order with ID {$orderId} not found");
            return;
        }

        $this->info("=== Fixing QRIS Order ===");
        $this->line("Order Number: {$order->order_number}");

        $service = new MidtransService();

        try {
            $this->info("Creating transaction with Midtrans...");
            $response = $service->createTransaction($order, 'qris', 'dana');
            
            $this->info("Extracting payment info...");
            $info = $service->extractPaymentInfo($response);
            
            $this->info("Updating order database...");
            $order->update([
                'midtrans_transaction_id' => $response->transaction_id ?? null,
                'midtrans_order_id' => $order->order_number,
                'qris_url' => $info['qris_url'] ?? null,
                'qris_image_url' => $info['qris_image_url'] ?? null,
                'payment_instructions' => $info['payment_instructions'] ?? null,
                'payment_expired_at' => $info['payment_expired_at'] ?? now()->addHours(1),
            ]);
            
            $this->info("✓ Order updated successfully!");
            $this->line("QRIS URL: " . ($order->qris_url ? "EXISTS (" . strlen($order->qris_url) . " chars)" : "NULL"));
            $this->line("QRIS Image URL: " . ($order->qris_image_url ? "EXISTS" : "NULL"));
            $this->line("Payment expired: " . $order->payment_expired_at);
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}

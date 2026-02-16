<?php

namespace App\Console\Commands;

use App\Services\MidtransService;
use App\Models\Order;
use Illuminate\Console\Command;

class TestMidtransApi extends Command
{
    protected $signature = 'test:midtrans {orderId}';
    protected $description = 'Test Midtrans API with specific order';

    public function handle()
    {
        $orderId = $this->argument('orderId');
        $order = Order::find($orderId);

        if (!$order) {
            $this->error("Order with ID {$orderId} not found");
            return;
        }

        $this->info("=== Testing Midtrans API ===");
        $this->line("Order Number: {$order->order_number}");
        $this->line("Amount: {$order->total}");
        $this->newLine();

        $service = new MidtransService();

        try {
            $this->info("Creating QRIS transaction...");
            $response = $service->createTransaction($order, 'qris', 'dana');
            
            $this->info("✓ Transaction created!");
            $this->line("Response type: " . gettype($response));
            
            if (is_object($response)) {
                $this->line("\nResponse Properties:");
                foreach (get_object_vars($response) as $key => $value) {
                    if (is_string($value) && strlen($value) > 50) {
                        $this->line("  $key: " . substr($value, 0, 50) . "...");
                    } elseif (is_array($value)) {
                        $this->line("  $key: [array with " . count($value) . " items]");
                    } else {
                        $this->line("  $key: " . json_encode($value));
                    }
                }
            }
            
            $this->newLine();
            $this->info("Extracting payment info...");
            $info = $service->extractPaymentInfo($response);
            
            $this->line("Extracted Payment Info:");
            foreach ($info as $key => $value) {
                if (is_string($value) && strlen($value) > 50) {
                    $this->line("  $key: " . substr($value, 0, 50) . "...");
                } else {
                    $this->line("  $key: " . json_encode($value));
                }
            }
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            $this->line("Code: " . $e->getCode());
        }
    }
}

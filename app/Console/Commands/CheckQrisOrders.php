<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class CheckQrisOrders extends Command
{
    protected $signature = 'qris:check {limit=10}';
    protected $description = 'Check recent QRIS orders and their payment status';

    public function handle()
    {
        $limit = $this->argument('limit') ?? 10;
        
        $orders = Order::where('payment_method', 'qris')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        if ($orders->isEmpty()) {
            $this->info('❌ No QRIS orders found');
            return;
        }

        $this->newLine();
        $this->info('═══════════════════════════════════════════════════════════════════════════════');
        $this->info('QRIS ORDERS STATUS');
        $this->info('═══════════════════════════════════════════════════════════════════════════════');
        $this->newLine();

        $headers = [
            'Order #',
            'Channel',
            'Amount',
            'Payment Status',
            'QRIS Code',
            'Image',
            'Created',
        ];

        $rows = [];
        foreach ($orders as $order) {
            $rows[] = [
                $order->order_number,
                strtoupper($order->qris_channel ?? '-'),
                'Rp ' . number_format($order->total, 0, ',', '.'),
                ucfirst($order->payment_status),
                $order->qris_url ? '✓ (' . strlen($order->qris_url) . 'c)' : '✗ NULL',
                $order->qris_image_url ? '✓' : '✗',
                $order->created_at->format('Y-m-d H:i'),
            ];
        }

        $this->table($headers, $rows);
        $this->newLine();

        // Summary
        $pending = $orders->where('payment_status', 'pending')->count();
        $paid = $orders->where('payment_status', 'paid')->count();
        $failed = $orders->where('payment_status', 'failed')->count();
        $withQris = $orders->whereNotNull('qris_url')->count();

        $this->newLine();
        $this->info('📊 Summary:');
        $this->line("   • Total QRIS Orders: {$orders->count()}");
        $this->line("   • Pending: {$pending}");
        $this->line("   • Paid: {$paid}");
        $this->line("   • Failed: {$failed}");
        $this->line("   • With QRIS Code: {$withQris}");
        $this->newLine();

        // Issues
        $noQris = $orders->whereNull('qris_url')->count();
        $noImage = $orders->whereNotNull('qris_url')->whereNull('qris_image_url')->count();

        if ($noQris > 0 || $noImage > 0) {
            $this->newLine();
            $this->warn('⚠️  Issues Found:');
            if ($noQris > 0) {
                $this->line("   • {$noQris} order(s) missing QRIS code");
                $this->line("     → Run: php artisan fix:qris <ORDER_ID>");
            }
            if ($noImage > 0) {
                $this->line("   • {$noImage} order(s) missing QR image URL");
            }
        } else {
            $this->newLine();
            $this->info('✓ All QRIS orders have proper QRIS codes');
        }

        // DANA specific
        $danaOrders = $orders->where('qris_channel', 'dana');
        if ($danaOrders->isNotEmpty()) {
            $this->newLine();
            $this->info('💳 DANA Orders:');
            foreach ($danaOrders as $order) {
                $status = '✓' . ucfirst($order->payment_status);
                if ($order->payment_status === 'pending' && !$order->qris_url) {
                    $status = '❌ Missing QRIS code';
                }
                $this->line("   • {$order->order_number}: {$status}");
            }
        }

        $this->newLine();
        $this->info('═══════════════════════════════════════════════════════════════════════════════');
        $this->info('To test DANA QRIS compatibility:');
        $this->line('   • Web: http://localhost:8000/payment/test-dana-qris?order_number=ORD-xxx');
        $this->line('   • CLI: php artisan test:midtrans <ORDER_ID>');
        $this->newLine();
    }
}

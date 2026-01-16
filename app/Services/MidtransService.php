<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\Order;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        $serverKey = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production', false);
        
        if (empty($serverKey)) {
            throw new \Exception('Midtrans Server Key tidak ditemukan. Pastikan MIDTRANS_SERVER_KEY sudah di-set di file .env');
        }
        
        // Validate key format
        if ($isProduction) {
            // Production key should start with "Mid-server-"
            if (!str_starts_with($serverKey, 'Mid-server-')) {
                \Log::warning('Production mode detected but Server Key format seems incorrect. Expected: Mid-server-xxx');
            }
        } else {
            // Sandbox key should start with "SB-Mid-server-"
            if (!str_starts_with($serverKey, 'SB-Mid-server-')) {
                \Log::warning('Sandbox mode detected but Server Key format seems incorrect. Expected: SB-Mid-server-xxx');
            }
        }
        
        Config::$serverKey = $serverKey;
        Config::$isProduction = $isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Create transaction using Core API for QRIS or Virtual Account
     * 
     * @param Order $order
     * @param string $paymentType
     * @param string|null $bankCode Bank code for Virtual Account (bca, bni, mandiri, permata, etc.)
     * @return mixed
     */
    public function createTransaction(Order $order, string $paymentType, ?string $bankCode = null)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
            ],
            'item_details' => $this->buildItemDetails($order),
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s O'),
                'unit' => 'minutes',
                'duration' => 60, // 60 minutes expiry
            ],
        ];

        try {
            // Use Core API for direct payment methods
            if ($paymentType === 'qris') {
                // For QRIS, use Core API which returns qr_string directly
                $params['payment_type'] = 'qris';
                $response = CoreApi::charge($params);
            } elseif ($paymentType === 'bank_transfer') {
                // For Virtual Account, validate and use bank code from user selection
                // Supported banks: bca, bni, mandiri, permata, bri, cimb, danamon
                $supportedBanks = ['bca', 'bni', 'mandiri', 'permata', 'bri', 'cimb', 'danamon'];
                
                // Validate bank code
                if ($bankCode && !in_array(strtolower($bankCode), $supportedBanks)) {
                    throw new \Exception("Bank '{$bankCode}' tidak didukung. Bank yang didukung: " . implode(', ', $supportedBanks));
                }
                
                // Use selected bank or default to BCA
                $selectedBank = $bankCode ? strtolower($bankCode) : 'bca';
                
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = [
                    'bank' => $selectedBank
                ];
                
                \Log::info('Creating Virtual Account transaction', [
                    'order_id' => $order->order_number,
                    'bank' => $selectedBank,
                    'amount' => $order->total
                ]);
                
                $response = CoreApi::charge($params);
            } else {
                throw new \Exception('Unsupported payment type');
            }
            
            return $response;
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Check for authentication errors
            if (strpos($errorMessage, '401') !== false || strpos($errorMessage, 'Unknown Merchant') !== false) {
                $isProduction = config('services.midtrans.is_production', false);
                $serverKey = config('services.midtrans.server_key');
                
                \Log::error('Midtrans Authentication Error', [
                    'error' => $errorMessage,
                    'is_production' => $isProduction,
                    'server_key_prefix' => substr($serverKey, 0, 20) . '...',
                    'suggestion' => $isProduction 
                        ? 'Pastikan menggunakan Production Server Key yang dimulai dengan "Mid-server-"'
                        : 'Pastikan menggunakan Sandbox Server Key yang dimulai dengan "SB-Mid-server-"'
                ]);
                
                throw new \Exception('Server Key Midtrans tidak valid. ' . 
                    ($isProduction 
                        ? 'Pastikan menggunakan Production Server Key dari dashboard Midtrans.'
                        : 'Pastikan menggunakan Sandbox Server Key dari dashboard Midtrans.'));
            }
            
            \Log::error('Midtrans Error: ' . $errorMessage);
            throw $e;
        }
    }

    /**
     * Get transaction status
     */
    public function getTransactionStatus($orderId)
    {
        try {
            return Transaction::status($orderId);
        } catch (\Exception $e) {
            \Log::error('Midtrans Status Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Build item details for Midtrans
     */
    private function buildItemDetails(Order $order)
    {
        $items = [];
        
        // Load items if not already loaded
        if (!$order->relationLoaded('items')) {
            $order->load('items');
        }
        
        foreach ($order->items as $item) {
            $items[] = [
                'id' => (string) $item->product_id,
                'price' => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name' => $item->product_name,
            ];
        }

        // Add shipping cost if delivery
        if ($order->delivery_type === 'delivery' && $order->shipping_cost > 0) {
            $items[] = [
                'id' => 'shipping',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        return $items;
    }

    /**
     * Extract payment information from Midtrans response
     */
    public function extractPaymentInfo($response)
    {
        $paymentInfo = [
            'virtual_account_number' => null,
            'qris_url' => null,
            'payment_instructions' => null,
            'payment_expired_at' => null,
        ];

        // Log response for debugging
        \Log::info('Midtrans Response: ' . json_encode($response));

        // Handle Virtual Account
        if (isset($response->va_numbers) && !empty($response->va_numbers)) {
            $vaNumbers = is_array($response->va_numbers) ? $response->va_numbers : [$response->va_numbers];
            $va = $vaNumbers[0];
            
            if (is_object($va)) {
                $paymentInfo['virtual_account_number'] = $va->va_number ?? null;
                $bank = strtolower($va->bank ?? '');
                $bankName = strtoupper($va->bank ?? 'BANK');
            } else {
                $paymentInfo['virtual_account_number'] = $va['va_number'] ?? null;
                $bank = strtolower($va['bank'] ?? '');
                $bankName = strtoupper($va['bank'] ?? 'BANK');
            }
            
            // Simpan bank code untuk referensi
            $paymentInfo['virtual_account_bank'] = $bank;
            
            if ($paymentInfo['virtual_account_number']) {
                $paymentInfo['payment_instructions'] = "Transfer ke Virtual Account {$bankName}: " . $paymentInfo['virtual_account_number'];
            }
        }

        // Handle QRIS - qr_string contains the QRIS data string
        if (isset($response->qr_string) && !empty($response->qr_string)) {
            // qr_string from Midtrans is the actual QRIS data that can be scanned
            // Store it as-is for QR code generation
            $paymentInfo['qris_url'] = $response->qr_string;
            $paymentInfo['payment_instructions'] = "Scan QRIS untuk melakukan pembayaran menggunakan aplikasi e-wallet (GoPay, OVO, DANA, LinkAja) atau mobile banking";
        }
        
        // Alternative: Check actions array for QR code URL
        if (empty($paymentInfo['qris_url']) && isset($response->actions) && is_array($response->actions)) {
            foreach ($response->actions as $action) {
                if (isset($action->url) && (strpos(strtolower($action->url), 'qr') !== false || strpos(strtolower($action->url), 'qris') !== false)) {
                    $paymentInfo['qris_url'] = $action->url;
                    break;
                }
            }
        }
        
        // If we have qr_string, also try to get QR code image URL from Midtrans
        // Priority: generate-qr-code-v2 (khusus GoPay) > generate-qr-code (umum)
        if (!empty($paymentInfo['qris_url']) && isset($response->qr_string)) {
            if (isset($response->actions)) {
                $qrImageUrl = null;
                $qrImageUrlV2 = null;
                
                foreach ($response->actions as $action) {
                    if (isset($action->name) && isset($action->url)) {
                        $actionName = strtolower($action->name);
                        
                        // Prioritaskan generate-qr-code-v2 untuk GoPay (lebih kompatibel)
                        if ($actionName === 'generate-qr-code-v2') {
                            $qrImageUrlV2 = $action->url;
                        } elseif ($actionName === 'generate-qr-code' || $actionName === 'qr-code') {
                            $qrImageUrl = $action->url;
                        }
                    }
                }
                
                // Gunakan V2 jika tersedia (lebih baik untuk GoPay), fallback ke yang umum
                $paymentInfo['qris_image_url'] = $qrImageUrlV2 ?? $qrImageUrl;
            }
        }

        // Handle expiry time
        if (isset($response->expiry_time)) {
            $paymentInfo['payment_expired_at'] = $response->expiry_time;
        } elseif (isset($response->transaction_time)) {
            // Default expiry: 1 hour from transaction time
            $paymentInfo['payment_expired_at'] = date('Y-m-d H:i:s', strtotime($response->transaction_time . ' +1 hour'));
        }

        return $paymentInfo;
    }
}


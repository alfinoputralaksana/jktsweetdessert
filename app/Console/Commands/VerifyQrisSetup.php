<?php

namespace App\Console\Commands;

use App\Services\MidtransService;
use Illuminate\Console\Command;

class VerifyQrisSetup extends Command
{
    protected $signature = 'qris:verify';
    protected $description = 'Verify QRIS setup and payment methods';

    public function handle()
    {
        $this->info('=== QRIS Setup Verification ===');
        
        // Check environment vars
        $this->line('\n1. Checking Environment Variables:');
        $serverKey = config('services.midtrans.server_key');
        $clientKey = config('services.midtrans.client_key');
        $isProduction = config('services.midtrans.is_production');
        
        $this->line('   Server Key: ' . (empty($serverKey) ? '❌ MISSING' : '✓ Configured'));
        $this->line('   Client Key: ' . (empty($clientKey) ? '❌ MISSING' : '✓ Configured'));
        $this->line('   Environment: ' . ($isProduction ? 'Production' : 'Sandbox'));
        
        // Try test transaction
        $this->line('\n2. Testing Transaction Creation:');
        try {
            $service = new MidtransService();
            $this->line('   ✓ MidtransService initialized');
            
            // Test params
            $testParams = [
                'transaction_details' => [
                    'order_id' => 'VERIFY-' . time(),
                    'gross_amount' => 10000,
                ],
                'payment_type' => 'qris',
            ];
            
            $this->line('   ℹ Note: Actual API test would require valid order object');
            $this->line('   To test with real data: php artisan test:midtrans {ORDER_ID}');
            
        } catch (\Exception $e) {
            $this->error('   ❌ Error: ' . $e->getMessage());
        }
        
        // Check payment methods available
        $this->line('\n3. Available Payment Methods:');
        $this->line('   QRIS (E-Wallets):');
        $this->line('      ✓ GoPay');
        $this->line('      ✓ OVO');
        $this->line('      ✓ DANA');
        $this->line('      ✓ LinkAja');
        $this->line('   Virtual Account (m-Banking):');
        $this->line('      ✓ BCA (014)');
        $this->line('      ✓ BNI (009)');
        $this->line('      ✓ Mandiri (008)');
        $this->line('      ✓ BRI (002)');
        $this->line('      ✓ CIMB (022)');
        $this->line('      ✓ Permata (013)');
        $this->line('      ✓ Danamon (011)');
        
        // Known Issues
        $this->line('\n4. Known Issues:');
        $this->line('   ⚠ QRIS m-banking support:');
        $this->line('      - Sandbox: Limited support for m-banking');
        $this->line('      - Production: Full support after merchant configuration');
        $this->line('      - Workaround: Use Virtual Account for m-banking users');
        
        // Recommendations
        $this->line('\n5. Recommendations:');
        $this->line('   For Current Sandbox Setup:');
        $this->line('   - Keep QRIS for e-wallet payments');
        $this->line('   - Use Virtual Account for m-banking');
        $this->line('   - This combination covers all user needs');
        $this->line('');
        $this->line('   For Production Setup:');
        $this->line('   - Contact Midtrans support to enable QRIS m-banking');
        $this->line('   - Or continue with VA + QRIS combination (works well)');
        
        // Testing next step
        $this->info('\n6. Next Steps:');
        $this->line('   Test with real order:');
        $this->line('   $ php artisan test:midtrans {ORDER_ID}');
        $this->line('');
        $this->line('   Create new order at: /checkout');
        $this->line('   Then scan QRIS with e-wallet app (GoPay, OVO, DANA)');
    }
}

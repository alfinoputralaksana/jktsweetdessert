#!/bin/bash

# QRIS DANA Payment Fix - Test Script
# Script untuk menguji apakah payment flow sudah bekerja dengan baik

echo "================================"
echo "QRIS DANA Payment System Test"
echo "================================"
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Test 1: Check Server Key
echo -e "${YELLOW}[Test 1] Checking Midtrans Server Key${NC}"
if grep -q "MIDTRANS_SERVER_KEY" .env; then
    SERVER_KEY=$(grep "MIDTRANS_SERVER_KEY" .env | cut -d '=' -f2)
    if [[ $SERVER_KEY == SB-Mid-server-* ]]; then
        echo -e "${GREEN}✓ Server Key format valid (Sandbox)${NC}"
        echo "  Key: ${SERVER_KEY:0:20}...${SERVER_KEY: -5}"
    elif [[ $SERVER_KEY == Mid-server-* ]]; then
        echo -e "${GREEN}✓ Server Key format valid (Production)${NC}"
        echo "  Key: ${SERVER_KEY:0:20}...${SERVER_KEY: -5}"
    else
        echo -e "${RED}✗ Server Key format invalid${NC}"
        echo "  Expected: SB-Mid-server-xxx or Mid-server-xxx"
        echo "  Got: $SERVER_KEY"
    fi
else
    echo -e "${RED}✗ MIDTRANS_SERVER_KEY not found in .env${NC}"
fi
echo ""

# Test 2: Check PHP Config
echo -e "${YELLOW}[Test 2] Checking services.midtrans configuration${NC}"
php -r "
require 'vendor/autoload.php';
\$config = include 'config/services.php';
if (isset(\$config['midtrans'])) {
    echo \"\033[32m✓ Midtrans configuration exists\033[0m\n\";
    if (isset(\$config['midtrans']['server_key'])) {
        echo \"  Server Key: \" . substr(\$config['midtrans']['server_key'], 0, 20) . \"...\n\";
    }
    if (isset(\$config['midtrans']['is_production'])) {
        \$mode = \$config['midtrans']['is_production'] ? 'PRODUCTION' : 'SANDBOX';
        echo \"  Mode: \$mode\n\";
    }
} else {
    echo \"\033[31m✗ Midtrans configuration not found\033[0m\n\";
}
"
echo ""

# Test 3: Check Database Tables
echo -e "${YELLOW}[Test 3] Checking Database Tables${NC}"
php -r "
require 'vendor/autoload.php';
\\\$app = require_once 'bootstrap/app.php';
\\\$db = \\\$app->make('db');

try {
    // Check orders table
    \\\$orders = \\\$db->table('orders')->count();
    echo \"\033[32m✓ Orders table exists\033[0m\n\";
    echo \"  Total orders: \$orders\n\";
    
    // Check QRIS orders
    \\\$qrisOrders = \\\$db->table('orders')->where('payment_method', 'qris')->count();
    echo \"  QRIS orders: \$qrisOrders\n\";
    
    // Check failed/expired QRIS
    \\\$failedQris = \\\$db->table('orders')
        ->where('payment_method', 'qris')
        ->where('payment_status', 'failed')
        ->count();
    echo \"  Failed QRIS orders: \$failedQris\n\";
    
} catch (Exception \\\$e) {
    echo \"\033[31m✗ Database error: \" . \\\$e->getMessage() . \"\033[0m\n\";
}
"
echo ""

# Test 4: Check Log File
echo -e "${YELLOW}[Test 4] Checking Recent Logs${NC}"
if [ -f storage/logs/laravel.log ]; then
    NOTIFICATION_COUNT=$(grep -c "Midtrans notification received" storage/logs/laravel.log 2>/dev/null || echo "0")
    echo -e "${GREEN}✓ Log file exists${NC}"
    echo "  Recent Midtrans notifications: $NOTIFICATION_COUNT"
    
    ERRORS=$(grep -c "Payment notification error\|Invalid signature" storage/logs/laravel.log 2>/dev/null || echo "0")
    if [ $ERRORS -gt 0 ]; then
        echo -e "${YELLOW}⚠ Found $ERRORS errors in logs${NC}"
        echo "  Recent errors:"
        grep "Payment notification error\|Invalid signature" storage/logs/laravel.log | tail -3
    else
        echo -e "${GREEN}✓ No recent payment errors${NC}"
    fi
else
    echo -e "${RED}✗ Log file not found${NC}"
fi
echo ""

# Test 5: Check PaymentController
echo -e "${YELLOW}[Test 5] Checking PaymentController Signature Verification${NC}"
if grep -q "signature_key" app/Http/Controllers/PaymentController.php; then
    if grep -q "expectedSignatureKey" app/Http/Controllers/PaymentController.php; then
        echo -e "${GREEN}✓ Signature verification implemented${NC}"
    else
        echo -e "${RED}✗ Signature verification incomplete${NC}"
    fi
else
    echo -e "${RED}✗ Signature verification not found${NC}"
fi
echo ""

# Test 6: Check MidtransService Expiry
echo -e "${YELLOW}[Test 6] Checking Payment Expiry Duration${NC}"
if grep -q "'duration' => 1440" app/Services/MidtransService.php; then
    echo -e "${GREEN}✓ Expiry duration set to 1440 minutes (24 hours)${NC}"
elif grep -q "'duration' => 60" app/Services/MidtransService.php; then
    echo -e "${RED}✗ Expiry duration still 60 minutes (should be 1440)${NC}"
else
    echo -e "${YELLOW}⚠ Could not determine expiry duration${NC}"
fi
echo ""

# Test 7: Test Webhook Endpoint
echo -e "${YELLOW}[Test 7] Testing Notification Endpoint${NC}"
echo "To test manually, run:"
echo ""
echo "curl -X POST http://localhost:8000/payment/notification \\"
echo "  -H \"Content-Type: application/json\" \\"
echo "  -d '{"
echo "    \"order_id\": \"TEST-20260210-000001\","
echo "    \"transaction_id\": \"test-transaction-123\","
echo "    \"transaction_status\": \"settlement\","
echo "    \"status_code\": \"200\","
echo "    \"gross_amount\": \"50000\","
echo "    \"signature_key\": \"test-signature\""
echo "  }'"
echo ""

echo "================================"
echo "Test Summary"
echo "================================"
echo ""
echo "✓ = Feature implemented correctly"
echo "✗ = Feature needs fixing"
echo "⚠ = Warning - check manually"
echo ""
echo "Next steps:"
echo "1. Ensure Webhook URL is set in Midtrans Dashboard"
echo "2. Test with actual QRIS transaction"
echo "3. Monitor logs for any errors"
echo "4. Check order status updates to 'processing' after payment"

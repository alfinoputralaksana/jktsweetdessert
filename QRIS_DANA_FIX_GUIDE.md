# QRIS DANA Payment Troubleshooting Guide

## 🚨 Gejala dan Solusi

### Gejala 1: "Transaksi Gagal" di Notifikasi Meski Sudah Bayar DANA

#### Root Causes:
1. **Webhook tidak terverifikasi** ← SUDAH DIPERBAIKI (signature verification ditambahkan)
2. **Expiry time terlalu pendek** ← SUDAH DIPERBAIKI (diperpanjang 24 jam)
3. **Server Key tidak valid** → CEK KONFIGURASI
4. **Network issue antara Midtrans dan server** → CEK LOGS

#### Diagnostic Steps:

**Step 1: Verifikasi Server Key**
```php
// Di Laravel Tinker:
php artisan tinker
config('services.midtrans.server_key')
// Output harus: SB-Mid-server-xxxxx (sandbox) atau Mid-server-xxxxx (production)
```

**Step 2: Cek Midtrans Dashboard**
1. Login ke https://dashboard.sandbox.midtrans.com
2. Lihat Home - Transaction List
3. Cari order number yang bermasalah
4. Verifikasi:
   - Status: harus "Settlement" atau "Capture" jika sudah bayar
   - Settlement time: kapan transaksi settlement
   - Payment method: QRIS atau DANA

**Step 3: Cek Application Logs**
```bash
# Di terminal, cek 50 baris terakhir dari log
tail -50 storage/logs/laravel.log | grep -i "midtrans\|payment\|notification"
```

Cari informasi:
- "Midtrans notification received" - webhook diterima?
- "Invalid signature key" - signature gagal?
- "Processing payment notification" - proses berhasil?

**Step 4: Check Database Order Status**
```php
php artisan tinker
App\Models\Order::where('order_number', 'ORD-xxx')->first()->payment_status
// Seharusnya: "paid" jika sudah settlement
// Jika masih "pending" atau "failed" = ada masalah
```

---

### Gejala 2: QR Code Tidak Muncul di Halaman Success

#### Kemungkinan Penyebab:
1. Response dari Midtrans tidak memiliki `qr_string`
2. Database tidak menyimpan `qris_url`
3. Browser error saat load gambar

#### Solusi:

**Cek di Database:**
```php
php artisan tinker
$order = App\Models\Order::where('order_number', 'ORD-xxx')->first();
$order->qris_url; // Harus ada value
$order->qris_image_url; // Harus ada value
```

**Jika kosong, refresh dari Midtrans:**
```php
$midtransService = new App\Services\MidtransService();
$status = $midtransService->getTransactionStatus('ORD-xxx');
$paymentInfo = $midtransService->extractPaymentInfo($status);
$order->update([
    'qris_url' => $paymentInfo['qris_url'],
    'qris_image_url' => $paymentInfo['qris_image_url'],
]);
```

**Check Logs untuk response dari Midtrans:**
```bash
grep "Midtrans Response" storage/logs/laravel.log | tail -5
```

---

### Gejala 3: Status Tetap "pending" Padahal Sudah Bayar

#### Diagnosis:

**Check 1: Apakah webhook diterima?**
```bash
grep "Midtrans notification received" storage/logs/laravel.log
# Jika tidak ada = webhook tidak sampai ke server
```

**Check 2: Notification URL di Midtrans**
1. Ke Settings → Configuration
2. Verifikasi "HTTP Notification URL" sudah tepat
3. Untuk development: `https://ngrok-url.ngrok.io/payment/notification`
4. Untuk production: `https://yourdomain.com/payment/notification`

**Check 3: Test webhook manual**
```bash
# Dari terminal (replace dengan order_id real):
curl -X POST http://localhost:8000/payment/notification \
  -H "Content-Type: application/json" \
  -d '{
    "order_id": "ORD-20260210-123456",
    "transaction_id": "test-123",
    "transaction_status": "settlement",
    "status_code": "200",
    "gross_amount": "50000",
    "signature_key": "xxx"
  }'
```

---

### Gejala 4: Error "Invalid signature"

#### Solusi:

Ini artinya signature key tidak cocok. Kemungkinan:

1. **Server Key salah di .env**
   ```bash
   # Check .env
   cat .env | grep MIDTRANS_SERVER_KEY
   # Harus match dengan dashboard Midtrans
   ```

2. **Mode sandbox/production tidak match**
   ```bash
   # Check di .env
   MIDTRANS_IS_PRODUCTION=false  # untuk sandbox
   # Server key harus SB-Mid-server-xxxxx
   ```

3. **Midtrans side testing**
   - Cek di Midtrans Dashboard → Settings → Notification Log
   - Lihat notification apa yang dikirim dan response apa yang diterima

---

## 🛠️ Maintenance & Prevention

### Daily Checks
```bash
# Check error logs
tail -100 storage/logs/laravel.log | grep -i "error\|exception"

# Check payment transactions
sqlite3 database/database.sqlite "SELECT order_number, payment_status, payment_method FROM orders WHERE payment_method='qris' LIMIT 10;"
```

### Weekly Review
```bash
# Check failed transactions
sqlite3 database/database.sqlite "SELECT order_number, created_at, payment_status FROM orders WHERE payment_status='failed' AND created_at >= datetime('now', '-7 days');"

# Check pending transactions (older than 24 hours should be expired)
sqlite3 database/database.sqlite "SELECT order_number, created_at, payment_status FROM orders WHERE payment_status='pending' AND payment_method='qris' AND created_at < datetime('now', '-24 hours');"
```

### Monitoring Best Practices
1. **Enable application monitoring**: Sentry, New Relic, atau DataDog
2. **Set up alerts**: Jika ada request ke `/payment/notification` dengan signature error
3. **Log rotation**: Pastikan logs tidak penuh (rotate setiap hari)
4. **Dashboard widget**: Buat widget untuk monitor payment success rate

---

## 📋 Post-Fix Verification Checklist

- [ ] Server Key valid dan verified
- [ ] Payment expiry time = 1440 minutes (24 jam)
- [ ] Notification endpoint returns 200 OK untuk valid requests
- [ ] Signature verification active
- [ ] Logging comprehensive untuk semua payment events
- [ ] Test QRIS transaction end-to-end
- [ ] Check order status updated ke "processing" saat payment settlement
- [ ] Database field qris_url dan qris_image_url terisi

---

## 📞 Support Contact

Jika masalah persisten:

1. **Cek Midtrans Status**
   - Dashboard: https://status.midtrans.com
   - Cek apakah ada maintenance

2. **Hubungi Midtrans Support**
   - Email: support@midtrans.com
   - Siapkan: Order ID, Transaction ID, Error logs

3. **Check Payment Method**
   - Pastikan QRIS/DANA sudah enabled di dashboard
   - Verifikasi business account QRIS sudah activated

---

## 🔍 Advanced Debugging

### Enable Query Log (Laravel)
```php
// Tambah di AppServiceProvider boot():
\DB::listen(function ($query) {
    \Log::debug('SQL: ' . $query->sql, $query->bindings);
});
```

### Enable Midtrans SDK Debug
```php
// Di MidtransService constructor:
if (config('app.debug')) {
    \Midtrans\Config::$is3ds = true;
    \Midtrans\Config::$isSanitized = true;
}
```

### Raw Midtrans API Test
```php
php artisan tinker

use Midtrans\Config;
use Midtrans\Transaction;

Config::$serverKey = 'SB-Mid-server-xxxx';
Config::$isProduction = false;

// Get transaction status
$status = Transaction::status('ORD-20260210-123456');
dd($status);
```

---

Last Updated: February 2026

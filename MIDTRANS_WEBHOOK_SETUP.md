# Midtrans Webhook Configuration - QRIS DANA Issue Fix

## 🔧 Masalah yang Diperbaiki

### Sebelumnya:
1. ❌ Transaksi QRIS DANA sering menunjukkan status "failed" atau "expired"
2. ❌ Notifikasi dari Midtrans tidak diverifikasi dengan signature key
3. ❌ Durasi expiry terlalu pendek (60 menit)
4. ❌ Logging tidak lengkap untuk tracking payment notifications

### Sesudah:
1. ✅ Signature verification ditambahkan untuk validasi notifikasi
2. ✅ Durasi expiry diperpanjang menjadi 24 jam
3. ✅ Comprehensive logging untuk debugging
4. ✅ Secure webhook endpoint dengan signature checking

## 📋 Langkah Setup Webhook di Midtrans Dashboard

### 1. Buka Midtrans Dashboard
- Sandbox: https://dashboard.sandbox.midtrans.com
- Production: https://dashboard.midtrans.com

### 2. Navigasi ke Configuration
- Pergi ke **Settings** → **Configuration**

### 3. Set Notification URL
Masukkan URL notification endpoints berikut:

```
HTTP Notification URL (Sandbox):
https://yourdomain.com/payment/notification

HTTP Notification URL (Production - jika sudah live):
https://yourdomain.com/payment/notification
```

Untuk development lokal, gunakan ngrok:
```bash
# Expose localhost:8000 ke internet
ngrok http 8000

# Gunakan URL seperti:
https://xxxxxx-xx-xxx-xxx-xx.ngrok.io/payment/notification
```

### 4. Set Callback URL (Optional - untuk page redirect)
```
Redirect URL:
https://yourdomain.com/orders/success/{order_id}
```

### 5. Simpan Configuration

## 🔐 Security Features

### Signature Key Verification
Setiap notifikasi dari Midtrans sekarang diverifikasi dengan:
```php
$expectedSignatureKey = hash('sha512', 
    $orderId . $statusCode . $grossAmount . $serverKey
);
```

Jika signature tidak cocok, notifikasi akan ditolak (401 Unauthorized).

## 📊 Payment Status Mapping

| Status Midtrans | Order Payment Status | Order Status | Deskripsi |
|---|---|---|---|
| `settlement` | `paid` | `processing` | Pembayaran berhasil |
| `capture` (accept) | `paid` | `processing` | Pembayaran berhasil (kartu kredit) |
| `capture` (challenge) | `pending` | `pending` | Pembayaran dalam review |
| `pending` | `pending` | `pending` | Menunggu pembayaran (QRIS/VA) |
| `deny` / `expire` / `cancel` | `failed` | `cancelled` | Pembayaran gagal/expired |

## ✅ Testing QRIS DANA

### Test dengan Sandbox
1. Buat order dengan payment method QRIS
2. Scan QR Code dengan DANA (test mode)
3. Verifikasi di Midtrans Dashboard → Home
4. Cek status order di aplikasi

### Log File
Semua transaksi dicatat di:
```
storage/logs/laravel.log
```

Cari dengan filter:
```
"Midtrans notification received"
"Processing payment notification"
"Payment notification processed successfully"
```

## 🐛 Debugging

### Cek Payment Status Manual
```bash
# Di Laravel Tinker atau PHP:
$order = App\Models\Order::where('order_number', 'ORD-xxxxx')->first();
echo $order->payment_status; // Lihat status terkini
```

### Check Midtrans Dashboard
1. Buka Transaction List
2. Cari order number
3. Verifikasi status adalah "Settlement" atau "Capture"

### Common Issues

#### Issue: QRIS Code Tidak Muncul
**Solusi:**
- Refresh page
- Lihat di console developer apakah ada error
- Cek di laravel.log apakah response dari Midtrans valid

#### Issue: Status Tetap "pending" Padahal Sudah Bayar
**Solusi:**
1. Cek apakah endpoint `/payment/notification` terhubung ke Midtrans
2. Cek di Midtrans Dashboard → Settings → Notification Log
3. Verifikasi Server Key dan Client Key di .env

#### Issue: Signature Key Invalid
**Solusi:**
1. Pastikan Server Key di .env sudah benar
2. Cek formatnya:
   - Sandbox: harus mulai dengan `SB-Mid-server-`
   - Production: harus mulai dengan `Mid-server-`

## 📱 Customer Experience

### Untuk QRIS DANA:
1. Customer membuat order
2. Lihat halaman success dengan QR Code QRIS
3. Scan dengan app DANA
4. Bayar
5. Status otomatis update di database via webhook
6. Customer bisa lihat status di order history

### Timeline:
- **0-24 jam**: QRIS code berlaku (diperpanjang dari 60 menit)
- **24+ jam**: QRIS code expired (automatic status = failed)

## 🔄 Deployment Checklist

Sebelum go to production:

- [ ] Set `MIDTRANS_IS_PRODUCTION=true` di `.env`
- [ ] Ganti `MIDTRANS_SERVER_KEY` dengan Production key
- [ ] Ganti `MIDTRANS_CLIENT_KEY` dengan Production key
- [ ] Update webhook URL di Midtrans Dashboard ke production domain
- [ ] Test satu transaksi untuk verifikasi
- [ ] Monitor logs untuk 24 jam pertama
- [ ] Beri tahu customer tentang perubahan

## 📚 Referensi
- [Midtrans Documentation](https://docs.midtrans.com)
- [Midtrans Payment Status](https://docs.midtrans.com/en/reference/transaction-status-lifecycle)
- [QRIS - Instant Payment](https://docs.midtrans.com/en/reference/qris-overview)

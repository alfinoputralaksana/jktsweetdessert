# Troubleshooting Midtrans Error 401

## Error yang Terjadi
```
"status_code":"401","status_message":"Unknown Merchant server_key/id"
```

## Penyebab
Server Key Midtrans yang digunakan **tidak valid** atau **tidak sesuai dengan environment**.

## Solusi

### 1. Cek Format Server Key

**Untuk Sandbox (Testing):**
- Server Key harus dimulai dengan: `SB-Mid-server-`
- Contoh: `SB-Mid-server-xxxxxxxxxxxxx`

**Untuk Production (Go Live):**
- Server Key harus dimulai dengan: `Mid-server-`
- Contoh: `Mid-server-xxxxxxxxxxxxx`

### 2. Pastikan Key Benar di .env

Buka file `.env` di root project dan pastikan:

```env
# Untuk Sandbox (Testing)
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false

# ATAU untuk Production
MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=true
```

### 3. Cara Mendapatkan Key yang Benar

1. Login ke **https://dashboard.midtrans.com**
2. Pastikan Anda berada di mode yang benar:
   - **Sandbox Mode** untuk testing (gratis)
   - **Production Mode** untuk go live (perlu verifikasi)
3. Klik **Settings** → **Access Keys**
4. Copy **Server Key** dan **Client Key**
5. Pastikan format sesuai:
   - Sandbox: Dimulai dengan `SB-Mid-server-`
   - Production: Dimulai dengan `Mid-server-`

### 4. Clear Config Cache

Setelah mengubah `.env`, jalankan:

```bash
php artisan config:clear
```

### 5. Cek Key yang Digunakan

Untuk melihat key yang sedang digunakan (tanpa menampilkan full key), cek log file:
- File: `storage/logs/laravel.log`
- Cari: "server_key_prefix"

### 6. Common Mistakes

❌ **SALAH:**
- Menggunakan Production key di Sandbox mode
- Menggunakan Sandbox key di Production mode
- Key ada spasi di awal/akhir
- Key tidak lengkap (terpotong)

✅ **BENAR:**
- Sandbox key untuk testing (`SB-Mid-server-...`)
- Production key untuk go live (`Mid-server-...`)
- Key tanpa spasi
- Key lengkap dari dashboard

### 7. Test Kembali

Setelah memperbaiki key:
1. Clear config: `php artisan config:clear`
2. Buat order baru dengan payment QRIS atau Virtual Account
3. Cek log file untuk memastikan tidak ada error 401 lagi

## Jika Masih Error

1. **Double check** key dari dashboard Midtrans
2. **Copy-paste** ulang key ke `.env` (jangan ketik manual)
3. **Pastikan** tidak ada karakter tersembunyi atau spasi
4. **Restart** web server (Laragon/Apache/Nginx)
5. **Clear** semua cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

## Support

Jika masih bermasalah:
- Cek dokumentasi Midtrans: https://docs.midtrans.com
- Hubungi support Midtrans melalui dashboard
- Pastikan akun Midtrans sudah aktif dan terverifikasi


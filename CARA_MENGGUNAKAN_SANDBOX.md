# Cara Menggunakan Sandbox Midtrans

## Apa itu Sandbox?

**Sandbox** adalah mode testing dari Midtrans yang:
- ✅ **GRATIS** - Tidak ada biaya
- ✅ **AMAN** - Tidak menggunakan uang sungguhan
- ✅ **LENGKAP** - Semua fitur payment tersedia untuk testing
- ✅ **MUDAH** - Tidak perlu verifikasi akun

**Sangat cocok untuk development dan testing sebelum go live!**

---

## Langkah-langkah Setup Sandbox

### 1. Daftar/Login ke Midtrans Dashboard

1. Buka: **https://dashboard.midtrans.com**
2. Klik **"Sign Up"** jika belum punya akun
3. Isi form pendaftaran:
   - Email
   - Password
   - Nama
   - Nomor telepon
   - Nama bisnis
   - Kategori bisnis

### 2. Aktifkan Sandbox Mode

Setelah login:

1. Di dashboard, cari **toggle switch** di pojok kanan atas
2. Pastikan toggle menunjukkan **"Sandbox"** (bukan "Production")
3. Jika masih Production, klik toggle untuk switch ke Sandbox

**Atau:**

1. Klik menu **"Settings"** di sidebar kiri
2. Pilih **"Environment"** atau **"Switch Environment"**
3. Pilih **"Sandbox"**

### 3. Ambil Sandbox Keys

1. Klik menu **"Settings"** di sidebar
2. Pilih **"Access Keys"** atau **"API Keys"**
3. Di halaman ini Anda akan melihat:
   - **Server Key (Sandbox)**: Dimulai dengan `SB-Mid-server-`
   - **Client Key (Sandbox)**: Dimulai dengan `SB-Mid-client-`

4. **Copy** kedua key tersebut

### 4. Set Keys di File .env

1. Buka file `.env` di root project Anda
2. Cari atau tambahkan konfigurasi Midtrans:

```env
# Midtrans Configuration (Sandbox Mode)
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

3. **PENTING**: 
   - Ganti `SB-Mid-server-xxxxxxxxxxxxx` dengan Server Key yang Anda copy
   - Ganti `SB-Mid-client-xxxxxxxxxxxxx` dengan Client Key yang Anda copy
   - Pastikan `MIDTRANS_IS_PRODUCTION=false` (untuk Sandbox)

### 5. Clear Config Cache

Setelah mengubah `.env`, jalankan command:

```bash
php artisan config:clear
```

Atau jika menggunakan Laragon, buka terminal dan ketik:
```bash
cd c:\laragon\www\jktsweetdessert
php artisan config:clear
```

### 6. Test Pembayaran

Sekarang Anda bisa test pembayaran:

1. Buat order baru dengan payment method **QRIS** atau **Virtual Account**
2. QRIS akan muncul dan bisa di-scan (tapi tidak akan benar-benar memotong saldo)
3. Virtual Account akan muncul nomor VA-nya (tapi transfer tidak akan benar-benar terjadi)

---

## Contoh Format Keys

### ✅ BENAR (Sandbox):
```
MIDTRANS_SERVER_KEY=SB-Mid-server-ABC123XYZ456
MIDTRANS_CLIENT_KEY=SB-Mid-client-DEF789UVW012
MIDTRANS_IS_PRODUCTION=false
```

### ❌ SALAH:
```
# Jangan gunakan Production key di Sandbox mode
MIDTRANS_SERVER_KEY=Mid-server-ABC123XYZ456  # ❌ Ini Production key
MIDTRANS_IS_PRODUCTION=true  # ❌ Harus false untuk Sandbox
```

---

## Keuntungan Sandbox

1. **Testing Gratis**
   - Test semua fitur payment tanpa biaya
   - Tidak ada risiko kehilangan uang

2. **Tidak Perlu Verifikasi**
   - Langsung bisa digunakan setelah daftar
   - Tidak perlu upload dokumen

3. **Simulasi Lengkap**
   - QRIS bisa di-scan (tapi tidak akan memotong saldo)
   - Virtual Account bisa di-transfer (tapi tidak akan benar-benar terjadi)
   - Semua status payment bisa di-test

4. **Development Friendly**
   - Bisa test error handling
   - Bisa test berbagai skenario
   - Bisa test webhook/callback

---

## Testing Payment di Sandbox

### Testing QRIS:
1. Buat order dengan payment QRIS
2. QR code akan muncul
3. Scan dengan aplikasi e-wallet (GoPay, OVO, dll)
4. Di Sandbox, pembayaran akan otomatis "berhasil" untuk testing

### Testing Virtual Account:
1. Buat order dengan payment Virtual Account
2. Nomor VA akan muncul
3. Transfer ke nomor VA tersebut
4. Di Sandbox, pembayaran akan otomatis terdeteksi untuk testing

---

## Kapan Pindah ke Production?

Pindah ke Production hanya jika:
- ✅ Semua testing sudah selesai
- ✅ Akun Midtrans sudah terverifikasi
- ✅ Siap untuk go live dengan uang sungguhan

**Untuk sekarang, gunakan Sandbox untuk development dan testing!**

---

## Troubleshooting

### Error "Unknown Merchant server_key/id"
- Pastikan menggunakan **Sandbox Server Key** (dimulai dengan `SB-Mid-server-`)
- Pastikan `MIDTRANS_IS_PRODUCTION=false`
- Clear config cache: `php artisan config:clear`

### Keys tidak muncul di dashboard
- Pastikan sudah switch ke Sandbox mode
- Refresh halaman dashboard
- Coba logout dan login lagi

### Payment tidak muncul
- Cek log file: `storage/logs/laravel.log`
- Pastikan keys sudah benar di `.env`
- Pastikan sudah clear config cache

---

## Link Penting

- **Dashboard Midtrans**: https://dashboard.midtrans.com
- **Dokumentasi Sandbox**: https://docs.midtrans.com/docs/core-api-overview
- **Sandbox Testing Guide**: https://docs.midtrans.com/docs/testing-payment-gateway

---

## Quick Start Checklist

- [ ] Daftar/Login ke dashboard.midtrans.com
- [ ] Switch ke Sandbox mode
- [ ] Ambil Server Key dan Client Key (Sandbox)
- [ ] Set keys di file `.env`
- [ ] Set `MIDTRANS_IS_PRODUCTION=false`
- [ ] Clear config: `php artisan config:clear`
- [ ] Test membuat order dengan QRIS/VA
- [ ] Cek apakah payment info muncul

**Selamat testing! 🎉**


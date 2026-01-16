# Cara Edit Harga Ongkir Manual

## 📍 Lokasi File Konfigurasi

File konfigurasi ongkir berada di:
```
app/Services/ShippingService.php
```

Buka file tersebut dan cari bagian `private $shippingZones = [` (sekitar baris 36).

---

## 🎯 Cara Edit Harga Ongkir

### 1. Edit Harga untuk Provinsi Tertentu

Cari nama provinsi yang ingin diubah, contoh:

```php
'DKI Jakarta' => [
    'base' => 13000,           // Harga dasar (minimum)
    'per_km_short' => 2815,   // Harga per km untuk 0-6 km
    'per_km_medium' => 2500,  // Harga per km untuk 6-15 km
    'per_km_long' => 1200,    // Harga per km untuk >15 km
    'flat_medium' => 18000,   // Harga flat untuk 6-15 km
    'min_cost' => 13000,      // Harga minimum
    'max_cost' => 100000,     // Harga maksimum
    'zone_type' => 'city'     // Tipe zona: 'city', 'nearby', 'intercity', 'interisland'
],
```

### 2. Edit Harga untuk Provinsi Lain (Sederhana)

Untuk provinsi yang tidak menggunakan tiered pricing (seperti Jawa Tengah, Jawa Timur, dll):

```php
'Jawa Tengah' => [
    'base' => 50000,      // Harga dasar
    'per_km' => 3000,    // Harga per km
    'min_cost' => 50000, // Harga minimum
    'max_cost' => 300000,// Harga maksimum
    'zone_type' => 'intercity'
],
```

---

## 📝 Contoh Edit Harga

### Contoh 1: Naikkan Harga DKI Jakarta

**Sebelum:**
```php
'DKI Jakarta' => [
    'base' => 13000,
    'min_cost' => 13000,
    'max_cost' => 100000,
],
```

**Sesudah (naikkan 20%):**
```php
'DKI Jakarta' => [
    'base' => 15000,      // Naik dari 13000 ke 15000
    'min_cost' => 15000,  // Naik dari 13000 ke 15000
    'max_cost' => 120000, // Naik dari 100000 ke 120000
],
```

### Contoh 2: Ubah Harga Jawa Barat

**Sebelum:**
```php
'Jawa Barat' => [
    'base' => 20000,
    'min_cost' => 20000,
],
```

**Sesudah (naikkan 25%):**
```php
'Jawa Barat' => [
    'base' => 25000,      // Naik dari 20000 ke 25000
    'min_cost' => 25000,  // Naik dari 20000 ke 25000
],
```

---

## 🔧 Tipe Zona (zone_type)

Ada 4 tipe zona yang menentukan cara perhitungan:

### 1. `'city'` - Dalam Kota
- Untuk: DKI Jakarta
- Menggunakan tiered pricing (0-6km, 6-15km, >15km)
- Harga lebih murah

### 2. `'nearby'` - Sekitar Jakarta
- Untuk: Jawa Barat, Banten
- Menggunakan tiered pricing
- Harga sedang

### 3. `'intercity'` - Antar Kota (Pulau Jawa)
- Untuk: Jawa Tengah, Jawa Timur, Yogyakarta
- Menggunakan per_km sederhana
- Harga lebih tinggi

### 4. `'interisland'` - Antar Pulau
- Untuk: Sumatera, Kalimantan, Sulawesi, dll
- Menggunakan per_km sederhana
- Harga paling tinggi

---

## 📊 Formula Perhitungan

### Untuk Zona `city` dan `nearby` (DKI Jakarta, Jawa Barat, Banten):

```
Jika jarak <= 6 km:
  Ongkir = base + (jarak × per_km_short)

Jika jarak 6-15 km:
  Ongkir = flat_medium

Jika jarak > 15 km:
  Ongkir = flat_medium + ((jarak - 15) × per_km_long)
```

### Untuk Zona Lain (intercity, interisland):

```
Ongkir = base + (jarak × per_km)
```

**Catatan:** Hasil akan dibulatkan ke ribuan terdekat dan dibatasi antara `min_cost` dan `max_cost`.

---

## 🎨 Tips Edit Harga

### 1. **Naikkan Harga Secara Proporsional**
Jika ingin naikkan semua harga 20%, kalikan semua nilai dengan 1.2:
```php
'base' => 13000 * 1.2,  // = 15600 (bulatkan jadi 16000)
'min_cost' => 13000 * 1.2,  // = 15600 (bulatkan jadi 16000)
```

### 2. **Buat Harga Flat (Tetap)**
Jika ingin harga tetap untuk provinsi tertentu:
```php
'Jawa Tengah' => [
    'base' => 50000,
    'per_km' => 0,        // Set 0 untuk harga flat
    'min_cost' => 50000,
    'max_cost' => 50000,  // Set sama dengan min_cost
],
```

### 3. **Sesuaikan dengan Jarak Real**
Jika tahu jarak real dari toko ke provinsi tertentu, sesuaikan `base` dan `per_km`:
```php
// Contoh: Jakarta ke Bandung (150 km)
'Jawa Barat' => [
    'base' => 20000,      // Base untuk jarak dekat
    'per_km' => 2000,     // Tambahan per km
    // Estimasi: 20000 + (150 × 2000) = 320000
],
```

---

## ✅ Setelah Edit

1. **Simpan file** `app/Services/ShippingService.php`
2. **Clear cache** (jika perlu):
   ```bash
   php artisan config:clear
   ```
3. **Test di halaman checkout** untuk memastikan harga sudah berubah

---

## 📋 Daftar Provinsi yang Tersedia

Sistem sudah support semua provinsi di Indonesia:
- ✅ DKI Jakarta
- ✅ Jawa Barat, Banten
- ✅ Jawa Tengah, Jawa Timur, Yogyakarta
- ✅ Sumatera (Aceh, Sumatera Utara, dll)
- ✅ Kalimantan (Kalimantan Barat, dll)
- ✅ Sulawesi (Sulawesi Utara, dll)
- ✅ Bali, Nusa Tenggara
- ✅ Maluku, Papua

**Jika provinsi tidak ada di list, tambahkan dengan format yang sama!**

---

## 🆘 Butuh Bantuan?

Jika bingung cara edit harga, ikuti langkah ini:
1. Buka file `app/Services/ShippingService.php`
2. Cari nama provinsi yang ingin diubah (Ctrl+F)
3. Ubah angka di `'base'`, `'min_cost'`, `'max_cost'`
4. Simpan file
5. Test di website

**Mudah kan?** 😊


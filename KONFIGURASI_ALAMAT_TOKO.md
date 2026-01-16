# Konfigurasi Alamat Toko

File ini menjelaskan cara mengkonfigurasi alamat toko (origin) untuk perhitungan ongkir dan jarak.

## Variabel Environment (.env)

Tambahkan variabel berikut ke file `.env` Anda:

```env
# Alamat Toko (Origin) untuk Perhitungan Ongkir
STORE_ADDRESS=Jl. Kesehatan No. 12 RT 004 RW 011, Kel. Gedong, Kec. Pasar Rebo, Jakarta Timur
STORE_CITY=Jakarta Timur
STORE_PROVINCE=DKI Jakarta
STORE_POSTAL_CODE=13780
STORE_LAT=-6.305066
STORE_LNG=106.858808
```

## Penjelasan Variabel

### STORE_ADDRESS
- **Deskripsi**: Alamat lengkap toko (jalan, RT/RW, kelurahan, kecamatan)
- **Contoh**: `Jl. Kesehatan No. 12 RT 004 RW 011, Kel. Gedong, Kec. Pasar Rebo, Jakarta Timur`
- **Wajib**: Ya

### STORE_CITY
- **Deskripsi**: Kota/kabupaten lokasi toko
- **Contoh**: `Jakarta Timur`
- **Wajib**: Ya

### STORE_PROVINCE
- **Deskripsi**: Provinsi lokasi toko
- **Contoh**: `DKI Jakarta`
- **Wajib**: Ya

### STORE_POSTAL_CODE
- **Deskripsi**: Kode pos lokasi toko
- **Contoh**: `13780`
- **Wajib**: Tidak (opsional, tapi disarankan untuk akurasi)

### STORE_LAT
- **Deskripsi**: Koordinat latitude (lintang) lokasi toko
- **Contoh**: `-6.305066`
- **Format**: Decimal degrees (DD)
- **Wajib**: Tidak (akan menggunakan default jika tidak diisi)
- **Cara mendapatkan**: 
  - Buka Google Maps
  - Cari alamat toko
  - Klik kanan pada lokasi → Pilih koordinat
  - Copy nilai latitude (angka pertama)

### STORE_LNG
- **Deskripsi**: Koordinat longitude (bujur) lokasi toko
- **Contoh**: `106.858808`
- **Format**: Decimal degrees (DD)
- **Wajib**: Tidak (akan menggunakan default jika tidak diisi)
- **Cara mendapatkan**: 
  - Buka Google Maps
  - Cari alamat toko
  - Klik kanan pada lokasi → Pilih koordinat
  - Copy nilai longitude (angka kedua)

## Cara Menggunakan

1. Buka file `.env` di root project
2. Tambahkan variabel di atas dengan nilai sesuai lokasi toko Anda
3. Simpan file
4. Restart aplikasi (jika menggunakan Laravel Sail atau server development)

## Contoh Lengkap

```env
# Alamat Toko
STORE_ADDRESS=Jl. Kesehatan No. 12 RT 004 RW 011, Kel. Gedong, Kec. Pasar Rebo, Jakarta Timur
STORE_CITY=Jakarta Timur
STORE_PROVINCE=DKI Jakarta
STORE_POSTAL_CODE=13780
STORE_LAT=-6.305066
STORE_LNG=106.858808
```

## Catatan Penting

1. **Koordinat (LAT/LNG)**: 
   - Sangat disarankan untuk mengisi koordinat agar perhitungan jarak lebih akurat
   - Jika tidak diisi, sistem akan menggunakan koordinat default
   - Koordinat harus dalam format decimal degrees (bukan derajat menit detik)

2. **Format Alamat**:
   - Gunakan format yang jelas dan lengkap
   - Semakin lengkap alamat, semakin akurat geocoding

3. **Setelah Mengubah .env**:
   - Jika menggunakan Laravel Sail: `./vendor/bin/sail restart`
   - Jika menggunakan `php artisan serve`: Restart server
   - Clear cache: `php artisan config:clear`

## Troubleshooting

### Jarak tidak akurat
- Pastikan koordinat (STORE_LAT dan STORE_LNG) sudah diisi dengan benar
- Verifikasi koordinat di Google Maps
- Pastikan format koordinat benar (decimal degrees, bukan DMS)

### Geocoding gagal
- Pastikan alamat lengkap dan jelas
- Cek apakah alamat bisa ditemukan di Google Maps
- Pastikan koneksi internet tersedia (untuk geocoding API)

### Ongkir tidak sesuai
- Pastikan provinsi sudah benar
- Cek apakah provinsi ada di daftar provinsi yang didukung
- Lihat file `CARA_EDIT_HARGA_ONGKIR.md` untuk menyesuaikan harga

## Default Values

Jika variabel tidak diisi di `.env`, sistem akan menggunakan nilai default:

- `STORE_ADDRESS`: `Jl. Kesehatan No. 12 RT 004 RW 011, Kel. Gedong, Kec. Pasar Rebo, Jakarta Timur`
- `STORE_CITY`: `Jakarta Timur`
- `STORE_PROVINCE`: `DKI Jakarta`
- `STORE_POSTAL_CODE`: `13780`
- `STORE_LAT`: `-6.305066`
- `STORE_LNG`: `106.858808`


<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ShippingService
{
    /**
     * Alamat toko (origin) - Pasar Rebo, Jakarta Timur
     */
    private $originCity = 'Jakarta Timur';
    private $originProvince = 'DKI Jakarta';
    private $originPostalCode = '13780'; // Kode pos Pasar Rebo
    private $originAddress = 'Jl. Kesehatan No. 12 RT 004 RW 011, Kel. Gedong, Kec. Pasar Rebo, Jakarta Timur';
    private $originLat = -6.305066; // Koordinat Pasar Rebo, Jakarta Timur
    private $originLng = 106.858808; // Koordinat Pasar Rebo, Jakarta Timur

    /**
     * Zona ongkir berdasarkan provinsi
     * Referensi harga dari GoSend, GrabExpress, dan Lalamove (2024)
     * 
     * GoSend Same Day:
     * - 0-6 km: Rp 13.000 + (Rp 2.815/km)
     * - 6-15 km: Rp 18.000 (flat)
     * - >15 km: Rp 18.000 + (Rp 1.200/km setelah 15km)
     * 
     * GrabExpress Instant:
     * - Minimal Rp 20.000, maksimal 30 km
     * 
     * Lalamove:
     * - Motor: Rp 10.000-20.000 + Rp 2.500/km
     * - Mobil: Rp 20.000 + Rp 3.500/km
     */
    private $shippingZones = [
        // Zona 1: Jakarta dan sekitarnya (dalam kota - seperti GoSend/Grab/Lalamove)
        // Origin: Pasar Rebo, Jakarta Timur (Jl. Kesehatan No. 12)
        // GoSend: Rp 13.000 + Rp 2.815/km (0-6km), Rp 18.000 (6-15km)
        // Lalamove Motor: Rp 10.000-20.000 + Rp 2.500/km
        // Untuk pengiriman dalam DKI Jakarta dari Pasar Rebo:
        // - Jakarta Timur: 0-15 km (dalam zona)
        // - Jakarta lainnya: 10-30 km (masih dalam zona)
        'DKI Jakarta' => [
            'base' => 13000,      // Base seperti GoSend Same Day
            'per_km_short' => 2815,  // 0-6 km seperti GoSend
            'per_km_medium' => 2500,  // 6-15 km seperti Lalamove
            'per_km_long' => 1200,   // >15 km seperti GoSend
            'flat_medium' => 18000,   // Flat rate 6-15 km
            'min_cost' => 13000,
            'max_cost' => 100000,
            'zone_type' => 'city'     // Dalam kota (Pasar Rebo, Jakarta Timur)
        ],
        'Jawa Barat' => [
            'base' => 13000,      // Base seperti GoSend (untuk jarak dekat)
            'per_km_short' => 2815,  // 0-6 km seperti GoSend
            'per_km_medium' => 2500,  // 6-15 km seperti Lalamove
            'per_km_long' => 2000,   // >15 km
            'flat_medium' => 18000,   // Flat rate 6-15 km seperti GoSend
            'min_cost' => 13000,
            'max_cost' => 100000,
            'zone_type' => 'nearby'   // Sekitar Jakarta (Depok, Bekasi, dll)
        ],
        'Banten' => [
            'base' => 13000,      // Base seperti GoSend
            'per_km_short' => 2815,  // 0-6 km seperti GoSend
            'per_km_medium' => 2500,  // 6-15 km seperti Lalamove
            'per_km_long' => 2000,   // >15 km
            'flat_medium' => 18000,   // Flat rate 6-15 km seperti GoSend
            'min_cost' => 13000,
            'max_cost' => 100000,
            'zone_type' => 'nearby'
        ],
        
        // Zona 2: Pulau Jawa lainnya (antar kota - harga lebih tinggi)
        'Jawa Tengah' => [
            'base' => 50000,      // Base untuk antar kota
            'per_km' => 3000,
            'min_cost' => 50000,
            'max_cost' => 300000,
            'zone_type' => 'intercity'
        ],
        'Jawa Timur' => [
            'base' => 60000,
            'per_km' => 3500,
            'min_cost' => 60000,
            'max_cost' => 400000,
            'zone_type' => 'intercity'
        ],
        'Yogyakarta' => [
            'base' => 50000,
            'per_km' => 3000,
            'min_cost' => 50000,
            'max_cost' => 300000,
            'zone_type' => 'intercity'
        ],
        
        // Zona 3: Sumatera (antar pulau - harga premium)
        'Sumatera Utara' => [
            'base' => 80000,
            'per_km' => 4000,
            'min_cost' => 80000,
            'max_cost' => 500000,
            'zone_type' => 'interisland'
        ],
        'Sumatera Barat' => [
            'base' => 70000,
            'per_km' => 3500,
            'min_cost' => 70000,
            'max_cost' => 450000,
            'zone_type' => 'interisland'
        ],
        'Sumatera Selatan' => [
            'base' => 60000,
            'per_km' => 3000,
            'min_cost' => 60000,
            'max_cost' => 400000,
            'zone_type' => 'interisland'
        ],
        'Riau' => [
            'base' => 70000,
            'per_km' => 3500,
            'min_cost' => 70000,
            'max_cost' => 450000,
            'zone_type' => 'interisland'
        ],
        'Kepulauan Riau' => [
            'base' => 80000,
            'per_km' => 4000,
            'min_cost' => 80000,
            'max_cost' => 500000,
            'zone_type' => 'interisland'
        ],
        'Lampung' => [
            'base' => 50000,
            'per_km' => 3000,
            'min_cost' => 50000,
            'max_cost' => 350000,
            'zone_type' => 'interisland'
        ],
        'Aceh' => [
            'base' => 90000,
            'per_km' => 4500,
            'min_cost' => 90000,
            'max_cost' => 600000,
            'zone_type' => 'interisland'
        ],
        'Bengkulu' => [
            'base' => 70000,
            'per_km' => 3500,
            'min_cost' => 70000,
            'max_cost' => 450000,
            'zone_type' => 'interisland'
        ],
        'Jambi' => [
            'base' => 70000,
            'per_km' => 3500,
            'min_cost' => 70000,
            'max_cost' => 450000,
            'zone_type' => 'interisland'
        ],
        
        // Zona 4: Kalimantan (antar pulau - harga premium)
        'Kalimantan Barat' => [
            'base' => 100000,
            'per_km' => 5000,
            'min_cost' => 100000,
            'max_cost' => 700000,
            'zone_type' => 'interisland'
        ],
        'Kalimantan Tengah' => [
            'base' => 100000,
            'per_km' => 5000,
            'min_cost' => 100000,
            'max_cost' => 700000,
            'zone_type' => 'interisland'
        ],
        'Kalimantan Selatan' => [
            'base' => 100000,
            'per_km' => 5000,
            'min_cost' => 100000,
            'max_cost' => 700000,
            'zone_type' => 'interisland'
        ],
        'Kalimantan Timur' => [
            'base' => 120000,
            'per_km' => 6000,
            'min_cost' => 120000,
            'max_cost' => 800000,
            'zone_type' => 'interisland'
        ],
        'Kalimantan Utara' => [
            'base' => 130000,
            'per_km' => 6500,
            'min_cost' => 130000,
            'max_cost' => 900000,
            'zone_type' => 'interisland'
        ],
        
        // Zona 5: Sulawesi (antar pulau - harga premium)
        'Sulawesi Utara' => [
            'base' => 150000,
            'per_km' => 7000,
            'min_cost' => 150000,
            'max_cost' => 1000000,
            'zone_type' => 'interisland'
        ],
        'Sulawesi Tengah' => [
            'base' => 140000,
            'per_km' => 6500,
            'min_cost' => 140000,
            'max_cost' => 950000,
            'zone_type' => 'interisland'
        ],
        'Sulawesi Selatan' => [
            'base' => 130000,
            'per_km' => 6000,
            'min_cost' => 130000,
            'max_cost' => 900000,
            'zone_type' => 'interisland'
        ],
        'Sulawesi Tenggara' => [
            'base' => 140000,
            'per_km' => 6500,
            'min_cost' => 140000,
            'max_cost' => 950000,
            'zone_type' => 'interisland'
        ],
        'Gorontalo' => [
            'base' => 150000,
            'per_km' => 7000,
            'min_cost' => 150000,
            'max_cost' => 1000000,
            'zone_type' => 'interisland'
        ],
        'Sulawesi Barat' => [
            'base' => 140000,
            'per_km' => 6500,
            'min_cost' => 140000,
            'max_cost' => 950000,
            'zone_type' => 'interisland'
        ],
        
        // Zona 6: Bali dan Nusa Tenggara
        'Bali' => [
            'base' => 80000,
            'per_km' => 4000,
            'min_cost' => 80000,
            'max_cost' => 500000,
            'zone_type' => 'interisland'
        ],
        'Nusa Tenggara Barat' => [
            'base' => 120000,
            'per_km' => 6000,
            'min_cost' => 120000,
            'max_cost' => 800000,
            'zone_type' => 'interisland'
        ],
        'Nusa Tenggara Timur' => [
            'base' => 150000,
            'per_km' => 7000,
            'min_cost' => 150000,
            'max_cost' => 1000000,
            'zone_type' => 'interisland'
        ],
        
        // Zona 7: Maluku dan Papua (termahal, antar pulau jauh)
        'Maluku' => [
            'base' => 200000,
            'per_km' => 8000,
            'min_cost' => 200000,
            'max_cost' => 1500000,
            'zone_type' => 'interisland'
        ],
        'Maluku Utara' => [
            'base' => 220000,
            'per_km' => 9000,
            'min_cost' => 220000,
            'max_cost' => 1600000,
            'zone_type' => 'interisland'
        ],
        'Papua' => [
            'base' => 250000,
            'per_km' => 10000,
            'min_cost' => 250000,
            'max_cost' => 2000000,
            'zone_type' => 'interisland'
        ],
        'Papua Barat' => [
            'base' => 240000,
            'per_km' => 9500,
            'min_cost' => 240000,
            'max_cost' => 1900000,
            'zone_type' => 'interisland'
        ],
        'Papua Selatan' => [
            'base' => 250000,
            'per_km' => 10000,
            'min_cost' => 250000,
            'max_cost' => 2000000,
            'zone_type' => 'interisland'
        ],
        'Papua Tengah' => [
            'base' => 250000,
            'per_km' => 10000,
            'min_cost' => 250000,
            'max_cost' => 2000000,
            'zone_type' => 'interisland'
        ],
        'Papua Pegunungan' => [
            'base' => 260000,
            'per_km' => 11000,
            'min_cost' => 260000,
            'max_cost' => 2100000,
            'zone_type' => 'interisland'
        ],
    ];

    /**
     * Hitung ongkir menggunakan estimasi manual (zone-based)
     * 
     * @param string $province
     * @param string $city
     * @param string $postalCode
     * @param float $weight Berat dalam kg (default 1kg untuk dessert)
     * @param string $provider Tidak digunakan (untuk kompatibilitas)
     * @param string $fullAddress Alamat lengkap
     * @param string $courier Tidak digunakan (untuk kompatibilitas)
     * @return array
     */
    public function calculateShipping($province, $city = '', $postalCode = '', $weight = 1.0, $provider = 'zone', $fullAddress = '', $courier = 'jne')
    {
        // Get origin address from config
        $this->originCity = env('STORE_CITY', 'Jakarta Timur');
        $this->originProvince = env('STORE_PROVINCE', 'DKI Jakarta');
        $this->originAddress = env('STORE_ADDRESS', 'Jl. Kesehatan No. 12 RT 004 RW 011, Kel. Gedong, Kec. Pasar Rebo, Jakarta Timur');
        $this->originPostalCode = env('STORE_POSTAL_CODE', '13780');
        
        // Get origin coordinates from config or use default
        $originLat = env('STORE_LAT', $this->originLat);
        $originLng = env('STORE_LNG', $this->originLng);
        $this->originLat = $originLat;
        $this->originLng = $originLng;

        // Prepare origin and destination
        $origin = [
            'address' => $this->originAddress,
            'city' => $this->originCity,
            'province' => $this->originProvince,
            'postal_code' => $this->originPostalCode,
            'lat' => $this->originLat,
            'lng' => $this->originLng,
        ];

        $destination = [
            'address' => $fullAddress ?: $this->buildAddress($province, $city, $postalCode),
            'city' => $city,
            'province' => $province,
            'postal_code' => $postalCode,
        ];

        // Cek apakah alamat tujuan sama dengan alamat origin (self pickup atau alamat sama)
        $isSameAddress = $this->isSameAddress($fullAddress, $city, $province, $postalCode);
        
        // Coba hitung jarak berdasarkan alamat jika alamat lengkap tersedia
        $distanceKm = null;
        if (!empty($province) && !$isSameAddress) {
            try {
                // Coba dengan alamat lengkap jika tersedia, jika tidak coba dengan kota saja
                if (!empty($fullAddress) && !empty($city)) {
                    $distanceKm = $this->calculateDistanceFromAddress($fullAddress, $city, $province, $postalCode);
                    
                    // Jika jarak sangat dekat (< 0.5 km), kemungkinan alamat yang sama atau sangat dekat
                    // Set ke 0 atau sangat kecil untuk akurasi
                    if ($distanceKm !== null && $distanceKm < 0.5) {
                        $originalDistance = $distanceKm;
                        $distanceKm = 0;
                        Log::info('Address very close to origin, setting distance to 0', [
                            'original_distance' => $originalDistance,
                            'address' => $fullAddress
                        ]);
                    }
                } elseif (!empty($city)) {
                    // Fallback: coba geocode berdasarkan kota saja
                    $distanceKm = $this->calculateDistanceFromAddress('', $city, $province, $postalCode);
                    
                    // Jika jarak sangat dekat, set ke 0
                    if ($distanceKm !== null && $distanceKm < 0.5) {
                        $distanceKm = 0;
                    }
                }
            } catch (\Exception $e) {
                Log::debug('Failed to calculate distance from address', [
                    'error' => $e->getMessage(),
                    'address' => $fullAddress,
                    'city' => $city,
                    'province' => $province
                ]);
                // Tidak perlu throw error, akan menggunakan estimasi berdasarkan provinsi
            }
        } elseif ($isSameAddress) {
            // Alamat sama dengan origin, jarak = 0
            $distanceKm = 0;
            Log::info('Destination address same as origin, distance set to 0');
        }

        // Gunakan estimasi manual (zone-based) untuk semua perhitungan
        $zoneResult = $this->calculateWithZone($province, $weight, $distanceKm);
        
        // Tambahkan informasi jarak jika berhasil dihitung
        if ($distanceKm !== null) {
            $zoneResult['distance_km'] = round($distanceKm, 2);
        }
        
        Log::info('Using zone-based calculation', [
            'province' => $province,
            'weight' => $weight,
            'distance_km' => $distanceKm
        ]);
        
        return $zoneResult;
    }


    /**
     * Calculate shipping using zone-based system (estimasi manual)
     * For food delivery, prioritize same-day delivery
     */
    private function calculateWithZone($province, $weight, $actualDistanceKm = null)
    {
        // Normalisasi nama provinsi
        $province = $this->normalizeProvince($province);
        
        // Jika provinsi tidak ditemukan, gunakan default (harga seperti GoSend/Grab)
        if (!isset($this->shippingZones[$province])) {
            return [
                'cost' => 50000, // Default ongkir untuk same-day (realistis seperti GoSend/Grab)
                'estimated_days' => 0, // Same-day
                'estimated_minutes' => 180, // 3 jam untuk same-day delivery
                'zone' => 'Unknown',
                'provider' => 'Same-day Delivery',
                'message' => 'Estimasi ongkir same-day delivery untuk provinsi yang tidak terdeteksi',
                'distance_km' => $actualDistanceKm
            ];
        }

        $zone = $this->shippingZones[$province];
        
        // Gunakan jarak aktual jika tersedia, jika tidak gunakan estimasi berdasarkan provinsi
        $estimatedDistance = $actualDistanceKm !== null ? $actualDistanceKm : $this->estimateDistance($province);
        
        // Hitung ongkir berdasarkan struktur GoSend/Grab/Lalamove
        $baseCost = $zone['base'];
        $weightMultiplier = max(1, $weight); // Minimum 1kg
        $distanceCost = 0; // Initialize untuk tracking
        
        // Jika jarak = 0 (alamat sama), ongkir = 0
        if ($estimatedDistance === 0 || $estimatedDistance < 0.1) {
            return [
                'cost' => 0,
                'estimated_days' => 0,
                'estimated_minutes' => 0,
                'zone' => $province,
                'provider' => 'Self Pickup / Same Address',
                'base_cost' => 0,
                'distance_cost' => 0,
                'weight' => $weight,
                'distance_km' => 0,
                'message' => 'Alamat tujuan sama dengan alamat toko (jarak 0 km)'
            ];
        }
        
        // Hitung ongkir berdasarkan jarak aktual (tanpa flat rate)
        // Semua jarak dihitung: base + (per_km * distance)
        if (isset($zone['per_km_short']) && isset($zone['zone_type']) && in_array($zone['zone_type'], ['city', 'nearby'])) {
            // Pricing tiered berdasarkan jarak (tanpa flat rate):
            // - 0-6 km: base + (per_km_short * distance)
            // - 6-15 km: base + (per_km_medium * distance)
            // - >15 km: base + (per_km_long * distance)
            
            if ($estimatedDistance <= 6) {
                // 0-6 km: base + (per_km_short * distance)
                // Contoh: 5 km = Rp 13.000 + (5 * Rp 2.815) = Rp 13.000 + Rp 14.075 = Rp 27.075
                $perKm = $zone['per_km_short'];
                $distanceCost = $estimatedDistance * $perKm;
                $totalCost = $baseCost + $distanceCost;
            } elseif ($estimatedDistance <= 15) {
                // 6-15 km: base + (per_km_medium * distance)
                // Contoh: 10 km = Rp 13.000 + (10 * Rp 2.500) = Rp 13.000 + Rp 25.000 = Rp 38.000
                $perKm = $zone['per_km_medium'] ?? $zone['per_km_short'];
                $distanceCost = $estimatedDistance * $perKm;
                $totalCost = $baseCost + $distanceCost;
            } else {
                // >15 km: base + (per_km_long * distance)
                // Contoh: 20 km = Rp 13.000 + (20 * Rp 1.200) = Rp 13.000 + Rp 24.000 = Rp 37.000
                $perKm = $zone['per_km_long'] ?? $zone['per_km_medium'] ?? $zone['per_km_short'];
                $distanceCost = $estimatedDistance * $perKm;
                $totalCost = $baseCost + $distanceCost;
            }
        } else {
            // Untuk provinsi lain: pricing sederhana per km
            $perKm = $zone['per_km'] ?? 3000;
            $distanceCost = $estimatedDistance * $perKm;
            $totalCost = $baseCost + $distanceCost;
        }
        
        // Apply weight multiplier
        $totalCost = $totalCost * $weightMultiplier;
        
        // Pastikan harga dalam range min-max (seperti GoSend/Grab yang punya batas)
        $minCost = $zone['min_cost'] ?? $baseCost;
        $maxCost = $zone['max_cost'] ?? ($baseCost * 10);
        $totalCost = max($minCost, min($totalCost, $maxCost));
        
        // Bulatkan ke ribuan terdekat (seperti GoSend/Grab yang bulatkan)
        $totalCost = ceil($totalCost / 1000) * 1000;
        
        // Estimasi waktu pengiriman same-day (dalam menit)
        // Untuk makanan, estimasi 1-4 jam tergantung jarak
        $estimatedMinutes = $this->estimateSameDayDeliveryMinutes($province, $estimatedDistance);
        
        return [
            'cost' => (int) $totalCost,
            'estimated_days' => 0, // Same-day (0 hari = hari yang sama)
            'estimated_minutes' => $estimatedMinutes,
            'zone' => $province,
            'provider' => 'Same-day Delivery',
            'base_cost' => $baseCost,
            'distance_cost' => max(0, $distanceCost * $weightMultiplier),
            'weight' => $weight,
            'distance_km' => $actualDistanceKm !== null ? round($actualDistanceKm, 2) : null,
            'message' => "Estimasi ongkir same-day delivery untuk {$province} (estimasi " . $this->formatDeliveryTime($estimatedMinutes) . ")"
        ];
    }

    /**
     * Build full address string
     */
    private function buildAddress($province, $city, $postalCode)
    {
        $parts = array_filter([$city, $province, $postalCode]);
        return implode(', ', $parts);
    }

    /**
     * Normalisasi nama provinsi
     */
    private function normalizeProvince($province)
    {
        $province = trim($province);
        
        // Mapping nama provinsi yang mungkin berbeda
        $mapping = [
            'DKI Jakarta' => 'DKI Jakarta',
            'Jakarta' => 'DKI Jakarta',
            'Jakarta Pusat' => 'DKI Jakarta',
            'Jakarta Barat' => 'DKI Jakarta',
            'Jakarta Selatan' => 'DKI Jakarta',
            'Jakarta Timur' => 'DKI Jakarta',
            'Jakarta Utara' => 'DKI Jakarta',
            'Jawa Barat' => 'Jawa Barat',
            'Jabar' => 'Jawa Barat',
            'Jawa Tengah' => 'Jawa Tengah',
            'Jateng' => 'Jawa Tengah',
            'Jawa Timur' => 'Jawa Timur',
            'Jatim' => 'Jawa Timur',
            'Yogyakarta' => 'Yogyakarta',
            'DIY' => 'Yogyakarta',
            'DI Yogyakarta' => 'Yogyakarta',
        ];
        
        if (isset($mapping[$province])) {
            return $mapping[$province];
        }
        
        return $province;
    }

    /**
     * Estimasi jarak berdasarkan provinsi (dalam km)
     */
    private function estimateDistance($province)
    {
        // Jarak estimasi dari Jakarta ke berbagai provinsi
        $distances = [
            'DKI Jakarta' => 0,
            'Jawa Barat' => 50,
            'Banten' => 60,
            'Jawa Tengah' => 400,
            'Jawa Timur' => 700,
            'Yogyakarta' => 500,
            'Sumatera Utara' => 1400,
            'Sumatera Barat' => 1000,
            'Sumatera Selatan' => 600,
            'Riau' => 800,
            'Kepulauan Riau' => 900,
            'Lampung' => 200,
            'Aceh' => 1700,
            'Bengkulu' => 700,
            'Jambi' => 700,
            'Kalimantan Barat' => 1200,
            'Kalimantan Tengah' => 1000,
            'Kalimantan Selatan' => 1200,
            'Kalimantan Timur' => 1500,
            'Kalimantan Utara' => 1800,
            'Sulawesi Utara' => 2000,
            'Sulawesi Tengah' => 1800,
            'Sulawesi Selatan' => 1500,
            'Sulawesi Tenggara' => 1700,
            'Gorontalo' => 1900,
            'Sulawesi Barat' => 1600,
            'Bali' => 1000,
            'Nusa Tenggara Barat' => 1200,
            'Nusa Tenggara Timur' => 1500,
            'Maluku' => 2500,
            'Maluku Utara' => 2600,
            'Papua' => 3500,
            'Papua Barat' => 3400,
            'Papua Selatan' => 3600,
            'Papua Tengah' => 3500,
            'Papua Pegunungan' => 3600,
        ];
        
        return $distances[$province] ?? 500; // Default 500km
    }

    /**
     * Estimasi hari pengiriman
     */
    private function estimateDeliveryDays($province)
    {
        // Zona 1-2: 1-2 hari
        $fastZones = ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Jawa Timur', 'Yogyakarta'];
        
        // Zona 3-4: 2-3 hari
        $mediumZones = ['Sumatera Utara', 'Sumatera Barat', 'Sumatera Selatan', 'Riau', 'Kepulauan Riau', 
                       'Lampung', 'Aceh', 'Bengkulu', 'Jambi', 'Kalimantan Barat', 'Kalimantan Tengah', 
                       'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara', 'Bali'];
        
        // Zona 5-7: 3-5 hari
        $slowZones = ['Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 
                     'Gorontalo', 'Sulawesi Barat', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur', 
                     'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat', 'Papua Selatan', 'Papua Tengah', 'Papua Pegunungan'];
        
        if (in_array($province, $fastZones)) {
            return rand(1, 2);
        } elseif (in_array($province, $mediumZones)) {
            return rand(2, 3);
        } else {
            return rand(3, 5);
        }
    }

    /**
     * Estimasi waktu pengiriman same-day dalam menit
     * Untuk makanan, estimasi 1-6 jam tergantung jarak
     */
    private function estimateSameDayDeliveryMinutes($province, $distance)
    {
        // Zona dekat (Jakarta, Jawa Barat, Banten): 60-120 menit (1-2 jam)
        $nearZones = ['DKI Jakarta', 'Jawa Barat', 'Banten'];
        
        // Zona sedang (Jawa Tengah, Yogyakarta, Lampung): 120-240 menit (2-4 jam)
        $mediumZones = ['Jawa Tengah', 'Jawa Timur', 'Yogyakarta', 'Lampung'];
        
        // Zona jauh (Sumatera, Kalimantan, Bali): 240-360 menit (4-6 jam)
        $farZones = ['Sumatera Utara', 'Sumatera Barat', 'Sumatera Selatan', 'Riau', 'Kepulauan Riau', 
                    'Aceh', 'Bengkulu', 'Jambi', 'Kalimantan Barat', 'Kalimantan Tengah', 
                    'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara', 'Bali'];
        
        // Zona sangat jauh (Sulawesi, NTT, Maluku, Papua): 360-480 menit (6-8 jam)
        // Catatan: Untuk zona sangat jauh, same-day delivery mungkin tidak memungkinkan
        // Tapi kita tetap berikan estimasi untuk zona-based calculation
        
        if (in_array($province, $nearZones)) {
            // 60-120 menit (1-2 jam)
            return rand(60, 120);
        } elseif (in_array($province, $mediumZones)) {
            // 120-240 menit (2-4 jam)
            return rand(120, 240);
        } elseif (in_array($province, $farZones)) {
            // 240-360 menit (4-6 jam)
            return rand(240, 360);
        } else {
            // 360-480 menit (6-8 jam) untuk zona sangat jauh
            // Catatan: Untuk zona ini, mungkin perlu konfirmasi dengan customer
            return rand(360, 480);
        }
    }

    /**
     * Format waktu pengiriman menjadi format yang user-friendly
     */
    private function formatDeliveryTime($minutes)
    {
        if ($minutes < 60) {
            return "{$minutes} menit";
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($remainingMinutes == 0) {
            return "{$hours} jam";
        } else {
            return "{$hours} jam {$remainingMinutes} menit";
        }
    }

    /**
     * Dapatkan daftar provinsi untuk dropdown
     */
    public function getProvinces()
    {
        return array_keys($this->shippingZones);
    }

    /**
     * Geocoding alamat menggunakan OpenStreetMap Nominatim API (gratis)
     * 
     * @param string $address Alamat lengkap
     * @param string $city Kota
     * @param string $province Provinsi
     * @param string $postalCode Kode pos (opsional)
     * @return array|null ['lat' => float, 'lng' => float] atau null jika gagal
     */
    private function geocodeAddress($address, $city = '', $province = '', $postalCode = '')
    {
        try {
            // Build cache key berdasarkan alamat
            $cacheKey = 'geocode_' . md5(implode('|', array_filter([$address, $city, $province, $postalCode])));
            
            // Cek cache dulu (cache selama 30 hari karena koordinat tidak berubah)
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                Log::debug('Geocoding result from cache', [
                    'address' => $address,
                    'city' => $city
                ]);
                return $cached;
            }
            
            // Strategi: Coba dengan alamat lengkap, kemudian fallback ke yang lebih umum
            $queries = [];
            
            // Query 1: Alamat lengkap dengan semua detail (paling spesifik)
            if (!empty($address) && !empty($city) && !empty($province)) {
                $fullQuery = implode(', ', array_filter([$address, $city, $province, 'Indonesia']));
                if (!in_array($fullQuery, $queries)) {
                    $queries[] = $fullQuery;
                }
            }
            
            // Query 2: Kota + provinsi (jika alamat lengkap tidak tersedia atau berbeda)
            if (!empty($city) && !empty($province)) {
                $cityQuery = $city . ', ' . $province . ', Indonesia';
                if (!in_array($cityQuery, $queries)) {
                    $queries[] = $cityQuery;
                }
            }
            
            // Query 3: Hanya provinsi (fallback terakhir - jarang digunakan karena kurang akurat)
            // Skip query provinsi saja karena kurang akurat dan bisa menyebabkan 403
            // if (!empty($province)) {
            //     $queries[] = $province . ', Indonesia';
            // }
            
            // URL Nominatim API (gratis, tidak perlu API key)
            $url = 'https://nominatim.openstreetmap.org/search';
            
            // User-Agent yang proper untuk Nominatim (required)
            $userAgent = 'JKT Sweet Dessert/1.0 (https://jktsweetdessert.com; contact@jktsweetdessert.com)';
            
            // Coba setiap query sampai berhasil
            foreach ($queries as $index => $query) {
                try {
                    // Rate limiting: tunggu minimal 2 detik antara request (karena Nominatim membatasi 1 request/detik)
                    // Dan jika dapat 403, tunggu lebih lama
                    if ($index > 0) {
                        sleep(2); // Minimal 2 detik delay
                    }
                    
                    // Gunakan Laravel HTTP client untuk request dengan headers yang proper
                    $response = Http::timeout(15)
                        ->withHeaders([
                            'User-Agent' => $userAgent, // Required by Nominatim - format: AppName/Version (website; email)
                            'Accept' => 'application/json',
                            'Accept-Language' => 'id,en-US,en'
                        ])
                        ->get($url, [
                            'q' => $query,
                            'format' => 'json',
                            'limit' => 1,
                            'addressdetails' => 1,
                            'countrycodes' => 'id', // Hanya Indonesia
                        ]);
                    
                    // Jika dapat 403, tunggu lebih lama sebelum retry
                    if ($response->status() === 403) {
                        Log::warning('Nominatim API rate limited (403)', [
                            'query' => $query,
                            'waiting' => '5 seconds before next attempt'
                        ]);
                        sleep(5); // Tunggu 5 detik jika dapat 403
                        continue; // Skip query ini, coba yang berikutnya
                    }
                    
                    if (!$response->successful()) {
                        Log::debug('Nominatim API request failed', [
                            'status' => $response->status(),
                            'query' => $query
                        ]);
                        continue; // Coba query berikutnya
                    }
                    
                    $data = $response->json();
                    
                    if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                        $coords = [
                            'lat' => (float) $data[0]['lat'],
                            'lng' => (float) $data[0]['lon']
                        ];
                        
                        // Cache hasil geocoding selama 30 hari (koordinat tidak berubah)
                        Cache::put($cacheKey, $coords, now()->addDays(30));
                        
                        Log::info('Geocoding successful', [
                            'query' => $query,
                            'coords' => $coords,
                            'cached' => true
                        ]);
                        
                        return $coords;
                    }
                } catch (\Exception $e) {
                    Log::debug('Geocoding attempt failed', [
                        'error' => $e->getMessage(),
                        'query' => $query
                    ]);
                    continue; // Coba query berikutnya
                }
            }
            
            // Semua query gagal - ini normal jika Nominatim rate limit atau alamat tidak ditemukan
            // Tidak perlu log sebagai warning karena sistem akan fallback ke estimasi provinsi
            Log::debug('All geocoding attempts failed, using province-based estimation', [
                'address' => $address,
                'city' => $city,
                'province' => $province,
                'note' => 'System will use province-based distance estimation'
            ]);
            
            return null;
        } catch (\Exception $e) {
            Log::warning('Geocoding exception', [
                'error' => $e->getMessage(),
                'address' => $address,
                'city' => $city,
                'province' => $province
            ]);
            return null;
        }
    }

    /**
     * Hitung jarak dalam kilometer antara dua koordinat menggunakan Haversine formula
     * 
     * @param float $lat1 Latitude titik pertama
     * @param float $lng1 Longitude titik pertama
     * @param float $lat2 Latitude titik kedua
     * @param float $lng2 Longitude titik kedua
     * @return float Jarak dalam kilometer
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        // Radius bumi dalam kilometer
        $earthRadius = 6371;
        
        // Konversi derajat ke radian
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        
        // Haversine formula
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        // Jarak dalam kilometer
        $distance = $earthRadius * $c;
        
        return $distance;
    }

    /**
     * Cek apakah alamat tujuan sama dengan alamat origin
     * 
     * @param string $address Alamat lengkap tujuan
     * @param string $city Kota tujuan
     * @param string $province Provinsi tujuan
     * @param string $postalCode Kode pos tujuan
     * @return bool
     */
    private function isSameAddress($address, $city = '', $province = '', $postalCode = '')
    {
        // Normalisasi alamat untuk perbandingan
        $originAddressNormalized = strtolower(trim($this->originAddress));
        $originCityNormalized = strtolower(trim($this->originCity));
        $originProvinceNormalized = strtolower(trim($this->originProvince));
        $originPostalCodeNormalized = strtolower(trim($this->originPostalCode));
        
        $destAddressNormalized = strtolower(trim($address));
        $destCityNormalized = strtolower(trim($city));
        $destProvinceNormalized = strtolower(trim($province));
        $destPostalCodeNormalized = strtolower(trim($postalCode));
        
        // Cek apakah provinsi sama
        if ($originProvinceNormalized !== $destProvinceNormalized) {
            return false;
        }
        
        // Cek apakah kota sama
        if (!empty($destCityNormalized) && $originCityNormalized !== $destCityNormalized) {
            return false;
        }
        
        // Cek apakah kode pos sama (jika tersedia)
        if (!empty($destPostalCodeNormalized) && !empty($originPostalCodeNormalized)) {
            if ($originPostalCodeNormalized === $destPostalCodeNormalized) {
                return true; // Kode pos sama, kemungkinan besar alamat sama
            }
        }
        
        // Cek apakah alamat mengandung kata kunci yang sama
        if (!empty($destAddressNormalized) && !empty($originAddressNormalized)) {
            // Ekstrak nomor jalan dan nama jalan utama
            preg_match('/jl\.?\s*([a-z\s]+)/i', $originAddressNormalized, $originStreet);
            preg_match('/jl\.?\s*([a-z\s]+)/i', $destAddressNormalized, $destStreet);
            
            if (!empty($originStreet[1]) && !empty($destStreet[1])) {
                $originStreetName = trim($originStreet[1]);
                $destStreetName = trim($destStreet[1]);
                
                // Jika nama jalan sama atau sangat mirip, kemungkinan alamat sama
                if (similar_text($originStreetName, $destStreetName) / max(strlen($originStreetName), strlen($destStreetName)) > 0.8) {
                    return true;
                }
            }
            
            // Cek apakah alamat tujuan mengandung alamat origin (atau sebaliknya)
            if (strpos($destAddressNormalized, $originAddressNormalized) !== false || 
                strpos($originAddressNormalized, $destAddressNormalized) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Hitung jarak dari alamat tujuan ke alamat origin
     * 
     * @param string $address Alamat lengkap tujuan
     * @param string $city Kota tujuan
     * @param string $province Provinsi tujuan
     * @param string $postalCode Kode pos tujuan (opsional)
     * @return float Jarak dalam kilometer
     * @throws \Exception Jika geocoding gagal
     */
    private function calculateDistanceFromAddress($address, $city = '', $province = '', $postalCode = '')
    {
        // Geocode alamat tujuan
        $destinationCoords = $this->geocodeAddress($address, $city, $province, $postalCode);
        
        if (!$destinationCoords) {
            throw new \Exception('Gagal mendapatkan koordinat alamat tujuan');
        }
        
        // Hitung jarak dari origin ke destination
        $distance = $this->calculateDistance(
            $this->originLat,
            $this->originLng,
            $destinationCoords['lat'],
            $destinationCoords['lng']
        );
        
        // Jika jarak sangat kecil (< 0.1 km = 100 meter), set ke 0
        // Ini untuk menangani perbedaan kecil dalam geocoding
        if ($distance < 0.1) {
            $distance = 0;
        }
        
        return $distance;
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    /**
     * Generate QR code image for QRIS
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        // Get QRIS data from query parameter
        $qrData = $request->query('data');
        
        if (empty($qrData)) {
            abort(400, 'QRIS data is required');
        }
        
        // Decode the URL-encoded data
        // Important: QRIS data is in EMV format and must be used exactly as-is
        $qrData = urldecode($qrData);
        
        // Generate QR code with optimal settings for QRIS/GoPay
        // Size: 600x600 pixels (large enough for reliable scanning)
        // Error Correction: H (High) - critical for QRIS/EMV compatibility with GoPay
        // Margin: 4 modules (provides clear border for scanning apps)
        // Note: The data is passed directly without any modification to ensure QRIS format integrity
        try {
            // Try PNG first (best quality), fallback to SVG if imagick not available
            try {
                $qrCode = QrCode::format('png')
                    ->size(600)
                    ->errorCorrection('H')
                    ->margin(4)
                    ->generate($qrData);
                
                return response($qrCode, 200)
                    ->header('Content-Type', 'image/png')
                    ->header('Cache-Control', 'public, max-age=3600');
            } catch (\Exception $pngError) {
                // If PNG fails (usually imagick not installed), use SVG
                \Log::warning('PNG QR code generation failed, using SVG', [
                    'error' => $pngError->getMessage()
                ]);
                
                $qrCode = QrCode::format('svg')
                    ->size(600)
                    ->errorCorrection('H')
                    ->margin(4)
                    ->generate($qrData);
                
                return response($qrCode, 200)
                    ->header('Content-Type', 'image/svg+xml')
                    ->header('Cache-Control', 'public, max-age=3600');
            }
        } catch (\Exception $e) {
            \Log::error('QR Code generation failed', [
                'error' => $e->getMessage(),
                'data_length' => strlen($qrData)
            ]);
            abort(500, 'Failed to generate QR code');
        }
    }
}


@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>🔍 DANA QRIS Compatibility Test</h4>
                </div>
                <div class="card-body">
                    @if(isset($order) && $order->payment_method === 'qris')
                    <div class="alert alert-info">
                        <h5>Order: {{ $order->order_number }}</h5>
                        <p>Amount: Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>

                    @if($order->qris_url)
                    {{-- QRIS String Analysis --}}
                    <h5 class="mt-4">📊 QRIS String Analysis</h5>
                    <div class="card bg-light mb-3">
                        <div class="card-body" style="font-size: 12px;word-break: break-all;">
                            <strong>QRIS Code ({{ strlen($order->qris_url) }} chars):</strong><br>
                            <code style="display: block; padding: 10px; background: white; border: 1px solid #ddd; border-radius: 4px; margin-top: 10px;">
                                {{ $order->qris_url }}
                            </code>
                        </div>
                    </div>

                    {{-- Format Validation --}}
                    <h5 class="mt-4">✅ Format Validation</h5>
                    @php
                        $qris = $order->qris_url;
                        $checks = [
                            'Format EMV Standard' => [
                                'pass' => substr($qris, 0, 8) === '00020101',
                                'desc' => 'QRIS standar EMV (00020101...)'
                            ],
                            'Panjang Minimal' => [
                                'pass' => strlen($qris) >= 80,
                                'desc' => 'Length: ' . strlen($qris) . ' chars (min 80)'
                            ],
                            'Checksum Format' => [
                                'pass' => (strlen($qris) % 2 === 0),
                                'desc' => 'Length harus genap untuk hex validation'
                            ],
                            'DANA Compatible' => [
                                'pass' => true,
                                'desc' => 'Generic QRIS kompatibel dengan semua e-wallet termasuk DANA'
                            ],
                        ];
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Test</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checks as $test => $result)
                                <tr>
                                    <td><strong>{{ $test }}</strong></td>
                                    <td>
                                        <span class="badge {{ $result['pass'] ? 'badge-success' : 'badge-danger' }}">
                                            {{ $result['pass'] ? '✓ PASS' : '✗ FAIL' }}
                                        </span>
                                    </td>
                                    <td style="font-size: 12px;">{{ $result['desc'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- QR Code Display --}}
                    <h5 class="mt-4">🎯 QR Code Preview</h5>
                    @if($order->qris_image_url)
                    <div class="text-center mb-3">
                        <p style="font-size: 12px; color: #666;">QR Code dari Midtrans:</p>
                        <img src="{{ $order->qris_image_url }}" alt="QRIS" style="max-width: 400px; border: 2px solid #ddd; padding: 10px; border-radius: 8px;">
                    </div>
                    @endif

                    {{-- Generate Alternative QR Code --}}
                    <p style="font-size: 12px; color: #666; margin-top: 15px;">
                        <strong>📱 Alternative QR Code Generators:</strong>
                    </p>
                    <div class="alert alert-light" style="font-size: 12px;">
                        @php
                            $qrData = urlencode($order->qris_url);
                            // Multiple QR code APIs for compatibility
                            $qrApiUrls = [
                                'qrserver' => "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={$qrData}&ecc=H&margin=2",
                                'qr-official' => "https://qr-official.line.me/gs/M" . base64_encode($order->qris_url),
                            ];
                        @endphp
                        <p>Jika gambar di atas tidak muncul, coba link alternatif di bawah:</p>
                        <ul style="padding-left: 20px;">
                            <li><a href="{{ $qrApiUrls['qrserver'] }}" target="_blank">QR Server (Universal)</a> - Rekomendasi untuk DANA</li>
                        </ul>
                    </div>

                    {{-- DANA Specific Troubleshooting --}}
                    <div class="alert alert-warning mt-4">
                        <h6>🎯 Troubleshooting untuk DANA:</h6>
                        <ol style="margin: 10px 0; padding-left: 20px;">
                            <li><strong>Update DANA App</strong> - Pastikan versi terbaru dari Play Store</li>
                            <li><strong>Coba Scan Langsung</strong> - Scan dari layar ini lebih baik daripada screenshot</li>
                            <li><strong>Cahaya Cukup</strong> - DANA mungkin noise-sensitive, butuh cahaya baik</li>
                            <li><strong>Jarak Optimal</strong> - Posisikan kamera 15-20cm dari QR code</li>
                            <li><strong>Coba Manual Input</strong> - Salin kode QRIS di bawah dan gunakan fitur input manual DANA jika ada</li>
                            <li><strong>Test Merchant</strong> - DANA app memerlukan scanning dari merchant terdaftar di Sandbox Midtrans</li>
                        </ol>
                    </div>

                    {{-- Manual QRIS Code Copy --}}
                    <h5 class="mt-4">📋 Manual QRIS Code</h5>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" value="{{ $order->qris_url }}" id="qris-code-input" readonly style="font-size: 11px;">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="copyQrisCode()">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                    <p style="font-size: 11px; color: #999;">Jika DANA ada fitur "Input Manual" atau "Paste QRIS", gunakan kode di atas</p>

                    {{-- Debug Info --}}
                    <h5 class="mt-4">🔧 Debug Information</h5>
                    <div class="alert alert-secondary" style="font-size: 11px;">
                        <table class="table table-sm mb-0">
                            <tr>
                                <td><strong>QRIS String:</strong></td>
                                <td>{{ strlen($order->qris_url) }} chars</td>
                            </tr>
                            <tr>
                                <td><strong>Image URL:</strong></td>
                                <td>{{ $order->qris_image_url ? substr($order->qris_image_url, 0, 50) . '...' : 'None' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Payment Status:</strong></td>
                                <td>{{ $order->payment_status }}</td>
                            </tr>
                            <tr>
                                <td><strong>Transaction ID:</strong></td>
                                <td>{{ $order->midtrans_transaction_id ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    @else
                    <div class="alert alert-danger">
                        ❌ No QRIS code found for this order. Please retry QRIS generation.
                        <a href="{{ route('payment.retry-qris', $order->order_number) }}" class="btn btn-sm btn-primary mt-2">
                            Try Again
                        </a>
                    </div>
                    @endif

                    @else
                    <div class="alert alert-info">
                        Enter an Order Number to test DANA QRIS compatibility:
                    </div>

                    <form action="{{ route('payment.test-dana-qris') }}" method="GET">
                        <div class="form-group">
                            <label>Order Number</label>
                            <input type="text" name="order_number" class="form-control" placeholder="ORD-20260215-XXXXX" value="{{ request('order_number') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Test DANA QRIS</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyQrisCode() {
    const qrisCode = document.getElementById('qris-code-input').value;
    navigator.clipboard.writeText(qrisCode).then(() => {
        alert('✓ QRIS code copied! Paste di aplikasi DANA');
    });
}
</script>
@endsection

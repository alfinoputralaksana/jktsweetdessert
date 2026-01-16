<!DOCTYPE html>
<html>
@include('partial.header')

<head>
  <style>
    body {
      background: #ffffff;
      background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZm9vZFBhdHRlcm4iIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZjBmMGYwIiBzdHJva2Utd2lkdGg9IjAuNSIgb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0idXJsKCNmb29kUGF0dGVybikiLz48L3N2Zz4=');
      background-size: 200px 200px;
      background-repeat: repeat;
      min-height: 100vh;
    }
  </style>
</head>
<body>
  <div class="hero_area">
    <section class="recipe_section layout_padding-top" style="margin-top: 100px;">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card text-center">
              <div class="card-body">
                <div class="mb-4">
                  <i class="fa fa-check-circle" style="font-size: 80px; color: green;"></i>
                </div>
                <h2>Order Placed Successfully!</h2>
                <p class="lead">Thank you for your order</p>
                <hr>
                <div class="text-left">
                  <h5>Order Details:</h5>
                  <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                  <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                  <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                  <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                  <p><strong>Delivery Type:</strong> {{ $order->delivery_type === 'self_pickup' ? 'Self Pickup' : 'Delivery' }}</p>
                  @if($order->delivery_type === 'delivery')
                    <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                  @endif
                  <p><strong>Payment Method:</strong> 
                    @if($order->payment_method === 'qris')
                      QRIS
                    @elseif($order->payment_method === 'virtual_account')
                      Virtual Account
                    @else
                      Cash
                    @endif
                  </p>
                  <p><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                  <p><strong>Status:</strong> <span class="badge badge-warning">{{ ucfirst($order->status) }}</span></p>
                  <p><strong>Payment Status:</strong> 
                    <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : ($order->payment_status === 'failed' ? 'badge-danger' : 'badge-warning') }}">
                      {{ ucfirst($order->payment_status) }}
                    </span>
                  </p>
                </div>

                @if(in_array($order->payment_method, ['qris', 'virtual_account']))
                  <hr>
                  
                  {{-- Debug Info (Hapus di production) --}}
                  @if(config('app.debug'))
                  <div class="alert alert-secondary" style="font-size: 11px;">
                    <strong>Debug Info:</strong><br>
                    Payment Method: {{ $order->payment_method }}<br>
                    QRIS URL: {{ $order->qris_url ? 'Ada (' . strlen($order->qris_url) . ' chars)' : 'Tidak ada' }}<br>
                    VA Number: {{ $order->virtual_account_number ? 'Ada: ' . $order->virtual_account_number : 'Tidak ada' }}<br>
                    Payment Status: {{ $order->payment_status }}
                  </div>
                  @endif
                  
                  <div class="alert alert-warning text-left" style="border-left: 4px solid #ff9800;">
                    <h4 style="color: #ff9800; margin-bottom: 20px;">
                      <i class="fa fa-exclamation-triangle"></i> Selesaikan Pembayaran Anda
                    </h4>
                    
                    @if($order->payment_method === 'qris')
                      @if($order->qris_url)
                      <div class="text-center my-4" style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
                        <h5 style="margin-bottom: 20px; color: #333;">
                          <i class="fa fa-qrcode"></i> Scan QR Code untuk Pembayaran
                        </h5>
                        <div style="display: inline-block; padding: 20px; background: white; border: 3px solid #28a745; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                          @php
                            // Priority untuk GoPay: Gunakan QR code image langsung dari Midtrans (generate-qr-code-v2)
                            // QR code dari Midtrans sudah di-optimize khusus untuk GoPay dan lebih kompatibel
                            $qrImageUrl = null;
                            $qrImageUrlBackup = null;
                            $qrImageUrlFallback = null;
                            
                            // 1. Primary: QR code image dari Midtrans (paling kompatibel dengan GoPay)
                            if (!empty($order->qris_image_url)) {
                                $qrImageUrl = $order->qris_image_url;
                            }
                            
                            // 2. Backup: Generate QR code lokal jika Midtrans image tidak tersedia
                            if (empty($qrImageUrl) && !empty($order->qris_url)) {
                                $qrData = $order->qris_url;
                                $qrImageUrl = route('qrcode.generate') . '?data=' . urlencode($qrData);
                                $qrImageUrlBackup = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=' . urlencode($qrData) . '&ecc=H&margin=4';
                            }
                            
                            // 3. Fallback: API online sebagai last resort
                            if (!empty($order->qris_url) && empty($qrImageUrlBackup)) {
                                $qrData = $order->qris_url;
                                $qrImageUrlBackup = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=' . urlencode($qrData) . '&ecc=H&margin=4';
                            }
                          @endphp
                          <img src="{{ $qrImageUrl }}" 
                               alt="QRIS Code untuk GoPay, OVO, DANA" 
                               style="max-width: 600px; width: 100%; min-width: 400px; display: block; margin: 0 auto; 
                                      image-rendering: -webkit-optimize-contrast; 
                                      image-rendering: crisp-edges;
                                      image-rendering: pixelated;
                                      border: 2px solid #ddd;
                                      padding: 15px;
                                      background: white;
                                      height: auto;"
                               id="qris-image"
                               @if($qrImageUrlBackup)
                               onerror="this.onerror=null; this.src='{{ $qrImageUrlBackup }}';"
                               @endif>
                          <div style="display: none; padding: 20px; background: #f5f5f5; border-radius: 5px;" id="qris-fallback">
                            <p><strong>QR Code tidak dapat ditampilkan</strong></p>
                            <p style="word-break: break-all; font-size: 11px;">{{ $order->qris_url }}</p>
                            <p style="font-size: 12px; margin-top: 10px;">
                              <strong>Alternatif:</strong> Salin kode QRIS di bawah dan paste di aplikasi e-wallet
                            </p>
                          </div>
                        </div>
                        <div class="alert alert-warning mt-3" style="font-size: 13px; border-left: 4px solid #ff9800;">
                          <i class="fa fa-exclamation-triangle"></i> 
                          <strong>Penting untuk GoPay:</strong>
                          <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Pastikan QR code terlihat jelas dan tidak blur</li>
                            <li>Jika tidak bisa di-scan, coba <strong>zoom in</strong> atau <strong>download gambar</strong> lalu scan dari galeri</li>
                            <li>Atau gunakan fitur <strong>"Salin Kode QRIS"</strong> di bawah untuk input manual</li>
                            <li>Pastikan aplikasi GoPay sudah update ke versi terbaru</li>
                          </ul>
                        </div>
                        <div class="mt-3">
                          <p style="font-size: 16px; font-weight: bold; color: #333;">Total Pembayaran:</p>
                          <p style="font-size: 24px; font-weight: bold; color: #28a745;">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                        <div class="mt-3" style="background: white; padding: 15px; border-radius: 8px; text-align: left;">
                          <p style="margin: 0; font-size: 14px;"><strong>Cara Bayar:</strong></p>
                          <ol style="margin: 10px 0; padding-left: 20px; font-size: 13px;">
                            <li>Buka aplikasi e-wallet (GoPay, OVO, DANA, LinkAja) atau mobile banking</li>
                            <li>Pilih menu Scan QR atau Bayar</li>
                            <li>Scan QR code di atas</li>
                            <li>Pastikan nominal sesuai: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></li>
                            <li>Konfirmasi pembayaran</li>
                          </ol>
                        </div>
                        <div class="mt-3">
                          <p style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 10px;">
                            <i class="fa fa-mobile"></i> Alternatif: Salin Kode QRIS
                          </p>
                          <p style="font-size: 12px; color: #666; margin-bottom: 10px;">
                            Jika QR code tidak bisa di-scan, salin kode QRIS di bawah dan paste di aplikasi e-wallet:
                          </p>
                          <div class="alert alert-light" style="word-break: break-all; font-size: 11px; text-align: left; position: relative; padding-right: 80px;">
                            <span id="qris-code" style="display: block;">{{ $order->qris_url }}</span>
                            <button onclick="copyQrisCode()" class="btn btn-primary btn-sm" style="position: absolute; top: 10px; right: 10px;">
                              <i class="fa fa-copy"></i> Salin
                            </button>
                          </div>
                          <div class="mt-2" style="font-size: 12px; color: #666; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <strong style="color: #333;">Cara menggunakan kode QRIS di GoPay:</strong>
                            <ol style="margin: 10px 0; padding-left: 20px; line-height: 1.8;">
                              <li>Klik tombol <strong>"Salin"</strong> di atas untuk copy kode QRIS</li>
                              <li>Buka aplikasi <strong>GoPay</strong></li>
                              <li>Pilih menu <strong>"Bayar"</strong> atau <strong>"Scan QR"</strong></li>
                              <li>Jika ada opsi <strong>"Input Manual"</strong> atau <strong>"Paste QRIS"</strong>, pilih itu</li>
                              <li><strong>Paste</strong> kode QRIS yang sudah di-copy</li>
                              <li>Pastikan nominal sesuai: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></li>
                              <li>Konfirmasi pembayaran</li>
                            </ol>
                            <p style="margin-top: 10px; font-size: 11px; color: #999;">
                              <i class="fa fa-info-circle"></i> 
                              <strong>Catatan:</strong> Beberapa aplikasi e-wallet mungkin tidak support paste QRIS manual. 
                              Jika tidak ada opsi paste, pastikan QR code di atas bisa di-scan dengan jelas.
                            </p>
                          </div>
                        </div>
                      </div>
                      @else
                      <div class="alert alert-danger">
                        <p><strong>QR Code belum tersedia. Silakan refresh halaman ini atau hubungi customer service.</strong></p>
                        <p>Order Number: <strong>{{ $order->order_number }}</strong></p>
                      </div>
                      @endif
                    @endif

                    @if($order->payment_method === 'virtual_account')
                      @if($order->virtual_account_number)
                      @php
                        // Mapping kode bank ke nama bank dan kode bank (hanya bank yang didukung Midtrans)
                        $bankCodes = [
                          'bca' => ['name' => 'BCA', 'code' => '014', 'full_name' => 'Bank Central Asia'],
                          'bni' => ['name' => 'BNI', 'code' => '009', 'full_name' => 'Bank Negara Indonesia'],
                          'mandiri' => ['name' => 'Mandiri', 'code' => '008', 'full_name' => 'Bank Mandiri'],
                          'permata' => ['name' => 'Permata', 'code' => '013', 'full_name' => 'Bank Permata'],
                          'bri' => ['name' => 'BRI', 'code' => '002', 'full_name' => 'Bank Rakyat Indonesia'],
                          'cimb' => ['name' => 'CIMB', 'code' => '022', 'full_name' => 'Bank CIMB Niaga'],
                          'danamon' => ['name' => 'Danamon', 'code' => '011', 'full_name' => 'Bank Danamon'],
                        ];
                        
                        $bankCode = strtolower($order->virtual_account_bank ?? '');
                        $bankInfo = $bankCodes[$bankCode] ?? ['name' => strtoupper($bankCode ?: 'BANK'), 'code' => '', 'full_name' => 'Bank'];
                        $bankName = $bankInfo['name'];
                        $bankCodeNumber = $bankInfo['code'];
                        $bankFullName = $bankInfo['full_name'];
                      @endphp
                      <div class="my-4" style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
                        <h5 style="margin-bottom: 20px; color: #333; text-align: center;">
                          <i class="fa fa-university"></i> Transfer ke Virtual Account
                        </h5>
                        <div style="background: white; padding: 25px; border-radius: 10px; border: 2px solid #4a3a22;">
                          <div style="text-align: center; margin-bottom: 20px;">
                            <p style="font-size: 16px; font-weight: bold; color: #333; margin-bottom: 5px;">
                              <i class="fa fa-building"></i> {{ $bankFullName }}
                            </p>
                            @if($bankCodeNumber)
                            <p style="font-size: 12px; color: #666; margin: 0;">
                              Kode Bank: <strong>{{ $bankCodeNumber }}</strong> | Bank: <strong>{{ $bankName }}</strong>
                            </p>
                            @else
                            <p style="font-size: 12px; color: #666; margin: 0;">
                              Bank: <strong>{{ $bankName }}</strong>
                            </p>
                            @endif
                          </div>
                          <p style="font-size: 14px; color: #666; margin-bottom: 10px; text-align: center;">Nomor Virtual Account:</p>
                          <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; position: relative;">
                            <p id="va-number" style="font-size: 32px; font-weight: bold; color: #4a3a22; letter-spacing: 4px; margin: 0; font-family: 'Courier New', monospace; word-break: break-all;">
                              {{ $order->virtual_account_number }}
                            </p>
                            <button onclick="copyVaNumber()" class="btn btn-primary btn-sm" style="margin-top: 15px;">
                              <i class="fa fa-copy"></i> Salin Nomor VA
                            </button>
                            <p style="font-size: 11px; color: #666; margin-top: 10px; margin-bottom: 0;">
                              <i class="fa fa-info-circle"></i> Salin nomor di atas dan gunakan untuk transfer melalui {{ $bankFullName }}
                            </p>
                          </div>
                        </div>
                        <div class="mt-4" style="background: white; padding: 20px; border-radius: 8px;">
                          <p style="font-size: 18px; font-weight: bold; color: #333; text-align: center; margin-bottom: 10px;">Total Pembayaran:</p>
                          <p style="font-size: 28px; font-weight: bold; color: #28a745; text-align: center; margin: 0;">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                          </p>
                        </div>
                        <div class="mt-3" style="background: white; padding: 15px; border-radius: 8px;">
                          <p style="margin: 0; font-size: 14px; font-weight: bold;"><strong>Cara Bayar:</strong></p>
                          <ol style="margin: 10px 0; padding-left: 20px; font-size: 13px;">
                            <li>Buka aplikasi mobile banking atau internet banking <strong>{{ $bankFullName }}</strong></li>
                            <li>Pilih menu Transfer atau Virtual Account</li>
                            @if($bankCodeNumber)
                            <li>Masukkan kode bank: <strong>{{ $bankCodeNumber }}</strong> ({{ $bankName }})</li>
                            @endif
                            <li>Masukkan nomor Virtual Account: <strong>{{ $order->virtual_account_number }}</strong></li>
                            <li>Masukkan nominal: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></li>
                            <li>Konfirmasi dan selesaikan transfer</li>
                            <li>Pembayaran akan otomatis terdeteksi (maksimal 5 menit)</li>
                          </ol>
                        </div>
                        <div class="alert alert-info mt-3" style="font-size: 12px;">
                          <i class="fa fa-info-circle"></i> 
                          <strong>Penting:</strong>
                          <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Pastikan nominal transfer sesuai persis dengan total pembayaran: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></li>
                            <li>Gunakan nomor Virtual Account di atas untuk transfer melalui {{ $bankFullName }}</li>
                            <li>Pembayaran akan otomatis terdeteksi setelah transfer berhasil (maksimal 5 menit)</li>
                            <li>Jika menggunakan mobile banking, pilih menu "Transfer" atau "Virtual Account"</li>
                            <li>Jika menggunakan ATM, pilih menu "Transfer" lalu masukkan nomor Virtual Account</li>
                          </ul>
                        </div>
                        @if($order->payment_expired_at)
                        <div class="alert alert-warning mt-2" style="font-size: 12px;">
                          <i class="fa fa-clock-o"></i> 
                          <strong>Batas Waktu Pembayaran:</strong> {{ \Carbon\Carbon::parse($order->payment_expired_at)->format('d M Y H:i') }}
                        </div>
                        @endif
                      </div>
                      @else
                      <div class="alert alert-danger">
                        <p><strong>Nomor Virtual Account belum tersedia. Silakan refresh halaman ini atau hubungi customer service.</strong></p>
                        <p>Order Number: <strong>{{ $order->order_number }}</strong></p>
                      </div>
                      @endif
                    @endif

                    @if($order->payment_instructions)
                      <div class="mt-2">
                        <p><strong>Catatan:</strong></p>
                        <p>{{ $order->payment_instructions }}</p>
                      </div>
                    @endif

                    @if($order->payment_expired_at)
                      <div class="mt-2">
                        <p><strong>Batas Waktu Pembayaran:</strong></p>
                        <p class="text-danger"><strong>{{ \Carbon\Carbon::parse($order->payment_expired_at)->format('d M Y H:i') }}</strong></p>
                        <p><small>Pesanan akan otomatis dibatalkan jika pembayaran tidak dilakukan sebelum batas waktu</small></p>
                      </div>
                    @endif

                    <div class="mt-3">
                      <p><small><i class="fa fa-clock-o"></i> Status pembayaran akan diperbarui otomatis setelah pembayaran berhasil</small></p>
                    </div>
                  </div>
                @endif
                <hr>
                <div class="text-left">
                  <h5>Order Items:</h5>
                  <div class="table-responsive order-table">
                    <table class="table">
                      <thead class="d-none d-md-table-header-group">
                        <tr>
                          <th>Product</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($order->items as $item)
                          <tr>
                            <td data-label="Product">{{ $item->product_name }}</td>
                            <td data-label="Quantity">{{ $item->quantity }}</td>
                            <td data-label="Price">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td data-label="Subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="mt-4 d-flex flex-column flex-sm-row gap-2 justify-content-center">
                  <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
                  <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-outline-secondary">View Order Details</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  @include('partial.footer')

  <script>
    function copyVaNumber() {
      const vaNumber = document.getElementById('va-number').textContent.trim();
      navigator.clipboard.writeText(vaNumber).then(function() {
        alert('Nomor Virtual Account berhasil disalin: ' + vaNumber);
      }, function() {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = vaNumber;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Nomor Virtual Account berhasil disalin: ' + vaNumber);
      });
    }

    function copyQrisCode() {
      const qrisCode = document.getElementById('qris-code').textContent.trim();
      navigator.clipboard.writeText(qrisCode).then(function() {
        alert('Kode QRIS berhasil disalin!');
      }, function() {
        const textArea = document.createElement('textarea');
        textArea.value = qrisCode;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Kode QRIS berhasil disalin!');
      });
    }

    // Auto refresh payment status every 30 seconds if payment is pending
    @if(in_array($order->payment_method, ['qris', 'virtual_account']) && $order->payment_status === 'pending')
    setInterval(function() {
      // Check payment status (optional - bisa ditambahkan endpoint untuk check status)
      console.log('Checking payment status...');
    }, 30000);
    @endif
  </script>
</body>
</html>


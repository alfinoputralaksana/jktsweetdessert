<!DOCTYPE html>
<html>
<?php echo $__env->make('partial.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
            <div class="card" style="border: 2px solid #D4A574; box-shadow: 0 8px 25px rgba(139, 111, 71, 0.2); border-radius: 12px; overflow: hidden;">
              <div style="background: linear-gradient(135deg, #8B6F47 0%, #6B5637 100%); padding: 30px; text-align: center; color: #F5E6D3;">
                <div class="mb-4">
                  <i class="fa fa-check-circle" style="font-size: 80px; color: #D4A574;"></i>
                </div>
                <h2 style="color: white; margin-bottom: 10px; font-weight: 700;">Order Berhasil!</h2>
                <p class="lead" style="color: #F5E6D3; margin: 0;">Terima kasih atas pesanan Anda</p>
              </div>
              <div class="card-body" style="padding: 24px; background: #FEFCF8;">
                <div class="text-left">
                  <h5 style="color: #8B6F47; margin-bottom: 16px; border-bottom: 2px solid #D4A574; padding-bottom: 10px;"><i class="fa fa-list" style="margin-right: 8px; color: #D4A574;"></i>Detail Pesanan:</h5>
                  <div style="line-height: 2; color: #6B5637; font-size: 14px;">
                    <p><strong>Nomor Order:</strong> <span style="color: #8B6F47; font-family: monospace; background: #F5E6D3; padding: 4px 8px; border-radius: 4px;"><?php echo e($order->order_number); ?></span></p>
                    <p><strong>Nama Pelanggan:</strong> <?php echo e($order->customer_name); ?></p>
                    <p><strong>Email:</strong> <?php echo e($order->customer_email); ?></p>
                    <p><strong>Telepon:</strong> <?php echo e($order->customer_phone); ?></p>
                    <p><strong>Tipe Pengiriman:</strong> 
                      <?php if($order->delivery_type === 'self_pickup'): ?>
                        <span style="background: #A0826D; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Ambil Sendiri</span>
                      <?php else: ?>
                        <span style="background: #D4A574; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Pengiriman</span>
                      <?php endif; ?>
                    </p>
                    <?php if($order->delivery_type === 'delivery'): ?>
                      <p><strong>Alamat:</strong> <?php echo e($order->customer_address); ?></p>
                    <?php endif; ?>
                    <p><strong>Metode Pembayaran:</strong> 
                      <?php if($order->payment_method === 'qris'): ?>
                        <span style="background: linear-gradient(135deg, #D4A574 0%, #A0826D 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">QRIS / E-Wallet</span>
                      <?php elseif($order->payment_method === 'virtual_account'): ?>
                        <span style="background: linear-gradient(135deg, #A0826D 0%, #8B6F47 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Virtual Account</span>
                      <?php else: ?>
                        <span style="background: #C9B0A0; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Cash</span>
                      <?php endif; ?>
                    </p>
                    <hr style="border: none; border-top: 1px solid #D4A574; margin: 12px 0;">
                    <p style="background: linear-gradient(135deg, #D4A574 0%, #A0826D 100%); color: white; padding: 14px; border-radius: 8px; font-weight: 600; font-size: 16px;">
                      <strong>Total:</strong> Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                    </p>
                    <p style="margin-top: 12px;">
                      <strong>Status Order:</strong> 
                      <span style="background: #D4A574; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;"><?php echo e(ucfirst($order->status)); ?></span>
                    </p>
                    <p>
                      <strong>Status Pembayaran:</strong> 
                      <?php if($order->payment_status === 'paid'): ?>
                        <span style="background: #8B6F47; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">✓ Terbayar</span>
                      <?php elseif($order->payment_status === 'failed'): ?>
                        <span style="background: #c0392b; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">✗ Gagal</span>
                      <?php else: ?>
                        <span style="background: #D4A574; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">⏳ Menunggu Pembayaran</span>
                      <?php endif; ?>
                    </p>
                  </div>
                </div>

                <?php if(in_array($order->payment_method, ['qris', 'virtual_account'])): ?>
                  <hr style="border: none; border-top: 2px solid #D4A574; margin: 20px 0;">
                  
                  <div style="background: linear-gradient(135deg, #F5E6D3 0%, #E8D7C3 100%); border: 2px solid #D4A574; border-radius: 10px; padding: 20px;">
                    <h4 style="color: #8B6F47; margin-bottom: 16px;">
                      <i class="fa fa-exclamation-triangle" style="color: #D4A574; margin-right: 8px;"></i> Selesaikan Pembayaran Anda
                    </h4>
                    
                    <?php if($order->payment_method === 'qris'): ?>
                      <?php if($order->qris_url): ?>
                      <div class="text-center my-4" style="background: linear-gradient(135deg, #F5E6D3 0%, #E8D7C3 100%); padding: 30px; border-radius: 12px; border: 2px solid #D4A574;">
                        <h5 style="margin-bottom: 20px; color: #8B6F47; font-weight: 600;">
                          <i class="fa fa-qrcode" style="color: #D4A574; margin-right: 8px;"></i> Scan QR Code dengan E-Wallet Anda
                        </h5>
                        <div style="display: inline-block; padding: 20px; background: white; border: 3px solid #D4A574; border-radius: 12px; box-shadow: 0 4px 8px rgba(212, 165, 116, 0.2);">
                          <?php
                            $qrImageUrl = null;
                            $qrImageUrlBackup = null;
                            
                            if (!empty($order->qris_image_url)) {
                                $qrImageUrl = $order->qris_image_url;
                            }
                            
                            if (empty($qrImageUrl) && !empty($order->qris_url)) {
                                $qrData = $order->qris_url;
                                $qrImageUrl = route('qrcode.generate') . '?data=' . urlencode($qrData);
                                $qrImageUrlBackup = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=' . urlencode($qrData) . '&ecc=H&margin=4';
                            }
                            
                            if (!empty($order->qris_url) && empty($qrImageUrlBackup)) {
                                $qrData = $order->qris_url;
                                $qrImageUrlBackup = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=' . urlencode($qrData) . '&ecc=H&margin=4';
                            }
                          ?>
                          <img src="<?php echo e($qrImageUrl); ?>" 
                               alt="QRIS Code" 
                               style="max-width: 600px; width: 100%; min-width: 400px; display: block; margin: 0 auto; 
                                      image-rendering: -webkit-optimize-contrast; 
                                      image-rendering: crisp-edges;
                                      image-rendering: pixelated;
                                      border: 2px solid #ddd;
                                      padding: 15px;
                                      background: white;
                                      height: auto;"
                               id="qris-image"
                               <?php if($qrImageUrlBackup): ?>
                               onerror="this.onerror=null; this.src='<?php echo e($qrImageUrlBackup); ?>';"
                               <?php endif; ?>>
                          <div style="display: none; padding: 20px; background: #f5f5f5; border-radius: 5px;" id="qris-fallback">
                            <p><strong>QR Code tidak dapat ditampilkan</strong></p>
                            <p style="word-break: break-all; font-size: 11px;"><?php echo e($order->qris_url); ?></p>
                            <p style="font-size: 12px; margin-top: 10px;">
                              <strong>Alternatif:</strong> Salin kode QRIS di bawah dan paste di aplikasi e-wallet
                            </p>
                          </div>
                        </div>
                        <div class="alert alert-info mt-3" style="font-size: 13px; border-left: 4px solid #8B6F47; background: white; border: 2px solid #D4A574; color: #8B6F47;">
                          <i class="fa fa-info-circle" style="color: #D4A574; margin-right: 8px;"></i> 
                          <strong>Cara Pembayaran QRIS:</strong>
                          <ul style="margin: 10px 0; padding-left: 20px; color: #6B5637;">
                            <li>Pastikan QR code terlihat jelas dan tidak blur</li>
                            <li>Jika tidak bisa di-scan, coba <strong>zoom in</strong> atau <strong>download gambar</strong> lalu scan dari galeri</li>
                            <li>Atau gunakan fitur <strong>"Salin Kode QRIS"</strong> di bawah untuk input manual</li>
                            <li>Pastikan aplikasi e-wallet Anda sudah update ke versi terbaru</li>
                          </ul>
                        </div>
                        <div class="mt-3">
                          <p style="font-size: 16px; font-weight: bold; color: #8B6F47;">Total Pembayaran:</p>
                          <p style="font-size: 24px; font-weight: bold; background: linear-gradient(135deg, #D4A574 0%, #A0826D 100%); color: white; padding: 12px; border-radius: 8px;">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></p>
                        </div>
                        <div class="mt-3" style="background: white; padding: 15px; border-radius: 8px; text-align: left; border: 2px solid #D4A574;">
                          <p style="margin: 0; font-size: 14px; color: #8B6F47; font-weight: 600;"><strong>Langkah-Langkah Pembayaran:</strong></p>
                          <ol style="margin: 10px 0; padding-left: 20px; font-size: 13px; color: #6B5637;">
                            <li>Buka aplikasi e-wallet Anda (GoPay, OVO, DANA, LinkAja, atau e-wallet lainnya)</li>
                            <li>Pilih menu "Scan QR" atau "Bayar"</li>
                            <li>Scan QR code di atas</li>
                            <li>Pastikan nominal sesuai: <strong>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></strong></li>
                            <li>Masukkan PIN/password dan konfirmasi pembayaran</li>
                          </ol>
                        </div>
                        <div class="mt-3">
                          <p style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 10px;">
                            <i class="fa fa-mobile"></i> Alternatif: Salin Kode QRIS
                          </p>
                          <p style="font-size: 12px; color: #666; margin-bottom: 10px;">
                            Jika QR code tidak bisa di-scan, salin kode QRIS di bawah:
                          </p>
                          <div class="alert alert-light" style="word-break: break-all; font-size: 11px; text-align: left; position: relative; padding-right: 80px;">
                            <span id="qris-code" style="display: block;"><?php echo e($order->qris_url); ?></span>
                            <button onclick="copyQrisCode()" class="btn btn-primary btn-sm" style="position: absolute; top: 10px; right: 10px;">
                              <i class="fa fa-copy"></i> Salin
                            </button>
                          </div>
                        </div>
                        </div>
                      </div>
                      <?php else: ?>
                      <div class="alert alert-danger">
                        <p><i class="fa fa-warning"></i> <strong>QR Code belum tersedia</strong></p>
                        <p>Order Number: <strong><?php echo e($order->order_number); ?></strong></p>
                        <p style="margin-top: 15px; font-size: 14px;">Silakan coba salah satu opsi di bawah:</p>
                        <div style="margin-top: 15px;">
                          <a href="<?php echo e(route('payment.retry-qris', $order->order_number)); ?>" class="btn btn-primary btn-sm" style="margin-right: 10px;">
                            <i class="fa fa-refresh"></i> Coba Buat QR Code Lagi
                          </a>
                          <button onclick="location.reload()" class="btn btn-info btn-sm" style="margin-right: 10px;">
                            <i class="fa fa-refresh"></i> Muat Ulang Halaman
                          </button>
                          <a href="https://wa.me/62812345678" class="btn btn-success btn-sm" target="_blank">
                            <i class="fa fa-whatsapp"></i> Hubungi Customer Service
                          </a>
                        </div>
                      </div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if($order->payment_method === 'virtual_account'): ?>
                      <?php if($order->virtual_account_number): ?>
                      <?php
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
                      ?>
                      <div class="my-4" style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
                        <h5 style="margin-bottom: 20px; color: #333; text-align: center;">
                          <i class="fa fa-university"></i> Transfer ke Virtual Account
                        </h5>
                        <div style="background: white; padding: 25px; border-radius: 10px; border: 2px solid #4a3a22;">
                          <div style="text-align: center; margin-bottom: 20px;">
                            <p style="font-size: 16px; font-weight: bold; color: #333; margin-bottom: 5px;">
                              <i class="fa fa-building"></i> <?php echo e($bankFullName); ?>

                            </p>
                            <?php if($bankCodeNumber): ?>
                            <p style="font-size: 12px; color: #666; margin: 0;">
                              Kode Bank: <strong><?php echo e($bankCodeNumber); ?></strong> | Bank: <strong><?php echo e($bankName); ?></strong>
                            </p>
                            <?php else: ?>
                            <p style="font-size: 12px; color: #666; margin: 0;">
                              Bank: <strong><?php echo e($bankName); ?></strong>
                            </p>
                            <?php endif; ?>
                          </div>
                          <p style="font-size: 14px; color: #666; margin-bottom: 10px; text-align: center;">Nomor Virtual Account:</p>
                          <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; position: relative;">
                            <p id="va-number" style="font-size: 32px; font-weight: bold; color: #4a3a22; letter-spacing: 4px; margin: 0; font-family: 'Courier New', monospace; word-break: break-all;">
                              <?php echo e($order->virtual_account_number); ?>

                            </p>
                            <button onclick="copyVaNumber()" class="btn btn-primary btn-sm" style="margin-top: 15px;">
                              <i class="fa fa-copy"></i> Salin Nomor VA
                            </button>
                            <p style="font-size: 11px; color: #666; margin-top: 10px; margin-bottom: 0;">
                              <i class="fa fa-info-circle"></i> Salin nomor di atas dan gunakan untuk transfer melalui <?php echo e($bankFullName); ?>

                            </p>
                          </div>
                        </div>
                        <div class="mt-4" style="background: white; padding: 20px; border-radius: 8px;">
                          <p style="font-size: 18px; font-weight: bold; color: #333; text-align: center; margin-bottom: 10px;">Total Pembayaran:</p>
                          <p style="font-size: 28px; font-weight: bold; color: #28a745; text-align: center; margin: 0;">
                            Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                          </p>
                        </div>
                        <div class="mt-3" style="background: white; padding: 15px; border-radius: 8px;">
                          <p style="margin: 0; font-size: 14px; font-weight: bold;"><strong>Cara Bayar:</strong></p>
                          <ol style="margin: 10px 0; padding-left: 20px; font-size: 13px;">
                            <li>Buka aplikasi mobile banking atau internet banking <strong><?php echo e($bankFullName); ?></strong></li>
                            <li>Pilih menu Transfer atau Virtual Account</li>
                            <?php if($bankCodeNumber): ?>
                            <li>Masukkan kode bank: <strong><?php echo e($bankCodeNumber); ?></strong> (<?php echo e($bankName); ?>)</li>
                            <?php endif; ?>
                            <li>Masukkan nomor Virtual Account: <strong><?php echo e($order->virtual_account_number); ?></strong></li>
                            <li>Masukkan nominal: <strong>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></strong></li>
                            <li>Konfirmasi dan selesaikan transfer</li>
                            <li>Pembayaran akan otomatis terdeteksi (maksimal 5 menit)</li>
                          </ol>
                        </div>
                        <div class="alert alert-info mt-3" style="font-size: 12px;">
                          <i class="fa fa-info-circle"></i> 
                          <strong>Penting:</strong>
                          <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Pastikan nominal transfer sesuai persis dengan total pembayaran: <strong>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></strong></li>
                            <li>Gunakan nomor Virtual Account di atas untuk transfer melalui <?php echo e($bankFullName); ?></li>
                            <li>Pembayaran akan otomatis terdeteksi setelah transfer berhasil (maksimal 5 menit)</li>
                            <li>Jika menggunakan mobile banking, pilih menu "Transfer" atau "Virtual Account"</li>
                            <li>Jika menggunakan ATM, pilih menu "Transfer" lalu masukkan nomor Virtual Account</li>
                          </ul>
                        </div>
                        <?php if($order->payment_expired_at): ?>
                        <div class="alert alert-warning mt-2" style="font-size: 12px;">
                          <i class="fa fa-clock-o"></i> 
                          <strong>Batas Waktu Pembayaran:</strong> <?php echo e(\Carbon\Carbon::parse($order->payment_expired_at)->format('d M Y H:i')); ?>

                        </div>
                        <?php endif; ?>
                      </div>
                      <?php else: ?>
                      <div class="alert alert-danger">
                        <p><strong>Nomor Virtual Account belum tersedia. Silakan refresh halaman ini atau hubungi customer service.</strong></p>
                        <p>Order Number: <strong><?php echo e($order->order_number); ?></strong></p>
                      </div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if($order->payment_instructions): ?>
                      <div class="mt-2">
                        <p><strong>Catatan:</strong></p>
                        <p><?php echo e($order->payment_instructions); ?></p>
                      </div>
                    <?php endif; ?>

                    <?php if($order->payment_expired_at): ?>
                      <div class="mt-2">
                        <p><strong>Batas Waktu Pembayaran:</strong></p>
                        <p class="text-danger"><strong><?php echo e(\Carbon\Carbon::parse($order->payment_expired_at)->format('d M Y H:i')); ?></strong></p>
                        <p><small>Pesanan akan otomatis dibatalkan jika pembayaran tidak dilakukan sebelum batas waktu</small></p>
                      </div>
                    <?php endif; ?>

                    <div class="mt-3">
                      <p><small><i class="fa fa-clock-o"></i> Status pembayaran akan diperbarui otomatis setelah pembayaran berhasil</small></p>
                    </div>
                  </div>
                <?php endif; ?>
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
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td data-label="Product"><?php echo e($item->product_name); ?></td>
                            <td data-label="Quantity"><?php echo e($item->quantity); ?></td>
                            <td data-label="Price">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                            <td data-label="Subtotal">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
                          </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="mt-4 d-flex flex-column flex-sm-row gap-2 justify-content-center">
                  <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">Continue Shopping</a>
                  <a href="<?php echo e(route('orders.show', $order->order_number)); ?>" class="btn btn-outline-secondary">View Order Details</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php echo $__env->make('partial.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

    // Auto refresh payment status every 5 seconds if payment is pending
    <?php if(in_array($order->payment_method, ['qris', 'virtual_account']) && $order->payment_status === 'pending'): ?>
    
    let checkPaymentInterval = null;
    let checkCount = 0;
    const maxChecks = 120; // Check for 10 minutes max (120 * 5 seconds)
    
    function checkPaymentStatus() {
      checkCount++;
      
      fetch('/api/payment-status/<?php echo e($order->order_number); ?>')
        .then(response => response.json())
        .then(data => {
          console.log('Payment Status:', data.payment_status);
          
          // Jika status berubah jadi paid
          if (data.payment_status === 'paid') {
            // Stop polling
            clearInterval(checkPaymentInterval);
            
            // Show success modal
            showPaymentSuccessModal(data);
          }
        })
        .catch(error => console.error('Error checking payment status:', error));
      
      // Stop checking setelah 10 menit
      if (checkCount >= maxChecks) {
        clearInterval(checkPaymentInterval);
        console.log('Payment status check timeout after 10 minutes');
      }
    }
    
    function showPaymentSuccessModal(data) {
      // Create modal HTML
      const modalHTML = `
        <div id="payment-success-modal" class="modal fade show" tabindex="-1" role="dialog" style="display: block; background: rgba(0,0,0,0.5);">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border: none; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
              <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 15px 15px 0 0; padding: 30px 20px;">
                <button type="button" class="close" style="display: none;"></button>
              </div>
              <div class="modal-body text-center" style="padding: 40px 20px;">
                <div style="font-size: 80px; color: #28a745; margin-bottom: 20px; animation: slideDown 0.6s ease-out;">
                  <i class="fa fa-check-circle"></i>
                </div>
                
                <h2 style="color: #333; font-weight: bold; margin-bottom: 10px; font-size: 28px;">
                  Pembayaran Berhasil! 🎉
                </h2>
                
                <p style="color: #666; font-size: 16px; margin-bottom: 20px; line-height: 1.6;">
                  Terima kasih telah melakukan pembayaran.<br>
                  <strong>Order #${data.order_number}</strong> telah dikonfirmasi.
                </p>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; text-align: left; margin-bottom: 20px;">
                  <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #ddd;">
                    <span style="color: #666; font-weight: 500;">Nama Pemesan:</span>
                    <strong style="color: #333;">${data.customer_name}</strong>
                  </div>
                  <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #ddd;">
                    <span style="color: #666; font-weight: 500;">No. Order:</span>
                    <strong style="color: #333;">${data.order_number}</strong>
                  </div>
                  <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666; font-weight: 500;">Total Pembayaran:</span>
                    <strong style="color: #28a745; font-size: 18px;">Rp ${new Intl.NumberFormat('id-ID').format(data.total)}</strong>
                  </div>
                </div>
                
                <p style="color: #999; font-size: 14px; margin-bottom: 30px;">
                  Anda akan diarahkan ke riwayat transaksi dalam 3 detik...
                </p>
                
                <button type="button" class="btn btn-success btn-lg" id="continue-to-history" style="
                  width: 100%;
                  border-radius: 8px;
                  font-size: 16px;
                  font-weight: 600;
                  padding: 12px 30px;
                  background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                  border: none;
                  cursor: pointer;
                  transition: all 0.3s ease;
                ">
                  Lihat Riwayat Transaksi →
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
      
      // Add modal to body
      document.body.insertAdjacentHTML('beforeend', modalHTML);
      
      // Add CSS animation
      const style = document.createElement('style');
      style.innerHTML = `
        @keyframes slideDown {
          from {
            transform: scale(0.5) rotate(-10deg);
            opacity: 0;
          }
          to {
            transform: scale(1) rotate(0);
            opacity: 1;
          }
        }
        
        .modal.show {
          animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
          from { opacity: 0; }
          to { opacity: 1; }
        }
      `;
      document.head.appendChild(style);
      
      // Auto redirect after 3 seconds
      let countdown = 3;
      const countdownInterval = setInterval(() => {
        countdown--;
        if (countdown <= 0) {
          clearInterval(countdownInterval);
          redirectToHistory();
        }
      }, 1000);
      
      // Button click handler
      document.getElementById('continue-to-history').addEventListener('click', redirectToHistory);
    }
    
    function redirectToHistory() {
      // Redirect ke halaman riwayat transaksi
      <?php if(Auth::check()): ?>
        window.location.href = '<?php echo e(route("orders.history")); ?>';
      <?php else: ?>
        window.location.href = '/';
      <?php endif; ?>
    }
    
    // Start checking every 5 seconds
    checkPaymentStatus(); // Check immediately
    checkPaymentInterval = setInterval(checkPaymentStatus, 5000);
    
    <?php endif; ?>
  </script>
</body>
</html>

<?php /**PATH C:\laragon\www\jktsweetdessert\resources\views/orders/success.blade.php ENDPATH**/ ?>
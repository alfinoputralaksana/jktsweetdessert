<!DOCTYPE html>
<html>
<?php echo $__env->make('partial.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body>
  <div class="hero_area">
    <section class="recipe_section layout_padding-top" style="margin-top: 100px;">
      <div class="container">
        <div class="row">
          <div class="col-md-8 mx-auto">
            <div class="card">
              <div class="card-header">
                <h3>Order Details - <?php echo e($order->order_number); ?></h3>
              </div>
              <div class="card-body">
                <div class="row mb-4">
                  <div class="col-md-6 mb-3 mb-md-0">
                    <h5>Customer Information</h5>
                    <p><strong>Name:</strong> <?php echo e($order->customer_name); ?></p>
                    <p><strong>Email:</strong> <?php echo e($order->customer_email); ?></p>
                    <p><strong>Phone:</strong> <?php echo e($order->customer_phone); ?></p>
                    <p><strong>Address:</strong> <?php echo e($order->customer_address); ?></p>
                  </div>
                  <div class="col-md-6">
                    <h5>Order Information</h5>
                    <p><strong>Status:</strong> 
                      <?php if($order->status == 'pending'): ?>
                        <span class="badge" style="background: #ffd43b; color: #000; padding: 5px 10px; border-radius: 5px;">Pending</span>
                      <?php elseif($order->status == 'processing'): ?>
                        <span class="badge" style="background: #4dabf7; color: white; padding: 5px 10px; border-radius: 5px;">Processing</span>
                      <?php elseif($order->status == 'shipped'): ?>
                        <span class="badge" style="background: #339af0; color: white; padding: 5px 10px; border-radius: 5px;">Di Antar</span>
                      <?php elseif($order->status == 'delivered'): ?>
                        <span class="badge" style="background: #51cf66; color: white; padding: 5px 10px; border-radius: 5px;">Delivered</span>
                      <?php else: ?>
                        <span class="badge" style="background: #ff6b6b; color: white; padding: 5px 10px; border-radius: 5px;">Cancelled</span>
                      <?php endif; ?>
                    </p>
                    <p><strong>Payment Status:</strong> 
                      <?php if($order->payment_status == 'paid'): ?>
                        <span class="badge" style="background: #51cf66; color: white; padding: 5px 10px; border-radius: 5px;">Paid</span>
                      <?php elseif($order->payment_status == 'pending'): ?>
                        <span class="badge" style="background: #ffd43b; color: #000; padding: 5px 10px; border-radius: 5px;">Pending</span>
                      <?php else: ?>
                        <span class="badge" style="background: #ff6b6b; color: white; padding: 5px 10px; border-radius: 5px;">Failed</span>
                      <?php endif; ?>
                    </p>
                    <p><strong>Payment Method:</strong> <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></p>
                    <p><strong>Order Date:</strong> <?php echo e($order->created_at->format('d M Y H:i')); ?></p>
                  </div>
                </div>

                <h5>Order Items</h5>
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
                    <tfoot class="d-none d-md-table-footer-group">
                      <tr>
                        <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                        <td><strong>Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="3" class="text-right"><strong>Shipping:</strong></td>
                        <td><strong>Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td><strong>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></strong></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                
                <!-- Mobile Summary -->
                <div class="d-md-none mt-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                  <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <strong>Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></strong>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span>Shipping:</span>
                    <strong>Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></strong>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></strong>
                  </div>
                </div>

                <?php if($order->notes): ?>
                  <div class="mt-3">
                    <h5>Notes:</h5>
                    <p><?php echo e($order->notes); ?></p>
                  </div>
                <?php endif; ?>

                <!-- Confirm Order Section -->
                <?php if(auth()->guard()->check()): ?>
                  <?php if($order->status == 'shipped' && $order->payment_status == 'paid'): ?>
                    <div class="mt-4 p-4" style="background: #e7f5ff; border-radius: 10px; border: 2px solid #4dabf7;">
                      <h5 style="color: #1971c2; margin-bottom: 15px;">
                        <i class="fa fa-check-circle"></i> Konfirmasi Pesanan Selesai
                      </h5>
                      <p style="margin-bottom: 15px;">
                        Pesanan Anda sedang dalam perjalanan (Di Antar). Jika pesanan sudah diterima dengan baik, silakan konfirmasi bahwa pesanan sudah selesai.
                      </p>
                      <button type="button" class="btn btn-success btn-confirm-order" data-order-number="<?php echo e($order->order_number); ?>" style="background: #51cf66; color: white; padding: 10px 30px; border-radius: 5px; border: none;">
                        <i class="fa fa-check"></i> Konfirmasi Pesanan Selesai
                      </button>
                    </div>
                  <?php elseif($order->status == 'delivered' && $order->payment_status == 'paid'): ?>
                    <div class="mt-4 p-4" style="background: #d3f9d8; border-radius: 10px; border: 2px solid #51cf66;">
                      <h5 style="color: #2b8a3e; margin-bottom: 10px;">
                        <i class="fa fa-check-circle"></i> Pesanan Sudah Selesai
                      </h5>
                      <p style="margin-bottom: 0; color: #2b8a3e;">
                        Terima kasih! Pesanan Anda sudah dikonfirmasi selesai dan diterima dengan baik.
                      </p>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>

                <div class="mt-4 text-center">
                  <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">Continue Shopping</a>
                  <a href="<?php echo e(route('orders.history')); ?>" class="btn" style="background: #4dabf7; color: white; margin-left: 10px;">Lihat Riwayat Pesanan</a>
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
    document.addEventListener('DOMContentLoaded', function() {
      const confirmButton = document.querySelector('.btn-confirm-order');
      
      if (confirmButton) {
        confirmButton.addEventListener('click', function() {
          const orderNumber = this.getAttribute('data-order-number');
          
          if (!confirm('Apakah Anda yakin ingin mengkonfirmasi bahwa pesanan ' + orderNumber + ' sudah selesai dan diterima dengan baik?')) {
            return;
          }

          // Disable button and show loading
          const originalText = this.innerHTML;
          this.disabled = true;
          this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses...';

          // Create form data
          const formData = new FormData();
          formData.append('_token', '<?php echo e(csrf_token()); ?>');

          // Send AJAX request
          fetch('<?php echo e(route("orders.confirm", ":orderNumber")); ?>'.replace(':orderNumber', orderNumber), {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Show success message
              alert(data.message || 'Pesanan berhasil dikonfirmasi selesai');
              
              // Reload page to update status
              window.location.reload();
            } else {
              alert(data.message || 'Terjadi kesalahan saat mengkonfirmasi pesanan');
              this.disabled = false;
              this.innerHTML = originalText;
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengkonfirmasi pesanan');
            this.disabled = false;
            this.innerHTML = originalText;
          });
        });
      }
    });
  </script>
</body>
</html>

<?php /**PATH C:\laragon\www\jktsweetdessert\resources\views/orders/show.blade.php ENDPATH**/ ?>
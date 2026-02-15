

<?php $__env->startSection('page_title', 'Detail Penjualan'); ?>
<?php $__env->startSection('breadcrumb', 'Detail Penjualan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Detail Pesanan - <?php echo e($order->order_number); ?></h3>
        <div class="card-tools">
          <a href="<?php echo e(auth()->user()->role == 'karyawan' ? route('karyawan.orders.index') : route('admin.orders.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <h5><i class="fas fa-user"></i> Informasi Customer</h5>
            <table class="table table-borderless">
              <tr>
                <td width="40%"><strong>Nama:</strong></td>
                <td><?php echo e($order->customer_name); ?></td>
              </tr>
              <tr>
                <td><strong>Email:</strong></td>
                <td><?php echo e($order->customer_email); ?></td>
              </tr>
              <tr>
                <td><strong>Telepon:</strong></td>
                <td><?php echo e($order->customer_phone); ?></td>
              </tr>
              <tr>
                <td><strong>Alamat:</strong></td>
                <td><?php echo e($order->customer_address); ?></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h5><i class="fas fa-info-circle"></i> Informasi Pesanan</h5>
            <table class="table table-borderless">
              <tr>
                <td width="40%"><strong>Tanggal:</strong></td>
                <td><?php echo e($order->created_at->format('d M Y H:i')); ?></td>
              </tr>
              <tr>
                <td><strong>Status:</strong></td>
                <td>
                  <?php if($order->status == 'pending'): ?>
                    <span class="badge badge-warning">Pending</span>
                  <?php elseif($order->status == 'processing'): ?>
                    <span class="badge badge-info">Proses</span>
                  <?php elseif($order->status == 'shipped'): ?>
                    <span class="badge badge-primary">Di Antar</span>
                  <?php elseif($order->status == 'delivered'): ?>
                    <span class="badge badge-success">Delivered</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Cancelled</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <td><strong>Status Pembayaran:</strong></td>
                <td>
                  <?php if($order->payment_status == 'paid'): ?>
                    <span class="badge badge-success">Paid</span>
                  <?php elseif($order->payment_status == 'pending'): ?>
                    <span class="badge badge-warning">Pending</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Failed</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <td><strong>Metode Pembayaran:</strong></td>
                <td>
                  <?php if($order->payment_method): ?>
                    <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?>

                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Update Status Form -->
        <div class="card card-primary collapsed-card mb-4">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-cog"></i> Proses Pesanan - Update Status</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form action="<?php echo e(auth()->user()->role == 'karyawan' ? route('karyawan.orders.updateStatus', $order->order_number) : route('admin.orders.updateStatus', $order->order_number)); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PUT'); ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Status Pesanan</label>
                    <select name="status" class="form-control" required>
                      <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                      <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Proses</option>
                      <option value="shipped" <?php echo e($order->status == 'shipped' ? 'selected' : ''); ?>>Di Antar</option>
                      <option value="delivered" <?php echo e($order->status == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                      <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Status Pembayaran</label>
                    <select name="payment_status" class="form-control" required>
                      <option value="pending" <?php echo e($order->payment_status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                      <option value="paid" <?php echo e($order->payment_status == 'paid' ? 'selected' : ''); ?>>Paid</option>
                      <option value="failed" <?php echo e($order->payment_status == 'failed' ? 'selected' : ''); ?>>Failed</option>
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan & Proses Pesanan
              </button>
            </form>
          </div>
        </div>

        <!-- Order Items -->
        <h5><i class="fas fa-shopping-bag"></i> Item Pesanan</h5>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Quantity</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($item->product_name); ?></td>
                <td>Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                <td><?php echo e($item->quantity); ?></td>
                <td>Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                <td><strong>Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></strong></td>
              </tr>
              <tr>
                <td colspan="3" class="text-right"><strong>Ongkir:</strong></td>
                <td><strong>Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></strong></td>
              </tr>
              <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td><strong>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></strong></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <?php if($order->notes): ?>
        <div class="mt-3">
          <h5><i class="fas fa-sticky-note"></i> Catatan</h5>
          <p class="text-muted"><?php echo e($order->notes); ?></p>
        </div>
        <?php endif; ?>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jktsweetdessert\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>
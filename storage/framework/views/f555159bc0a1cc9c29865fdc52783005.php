<?php $__env->startSection('page_title', 'Penjualan'); ?>
<?php $__env->startSection('breadcrumb', 'Penjualan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <!-- Statistics Cards -->
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo e($totalOrders); ?></h3>
        <p>Total Pesanan</p>
      </div>
      <div class="icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h3>
        <p>Total Pendapatan</p>
      </div>
      <div class="icon">
        <i class="fas fa-money-bill-wave"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?php echo e($pendingOrders); ?></h3>
        <p>Pesanan Pending</p>
      </div>
      <div class="icon">
        <i class="fas fa-clock"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3><?php echo e($paidOrders); ?></h3>
        <p>Pesanan Terbayar</p>
      </div>
      <div class="icon">
        <i class="fas fa-check-circle"></i>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Penjualan - Proses Pesanan</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="mb-3">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Pencarian</label>
                <input type="text" name="search" class="form-control" placeholder="No. Pesanan, Nama, Email..." value="<?php echo e(request('search')); ?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status Pesanan</label>
                <select name="status" class="form-control">
                  <option value="">Semua</option>
                  <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                  <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>Proses</option>
                  <option value="shipped" <?php echo e(request('status') == 'shipped' ? 'selected' : ''); ?>>Di Antar</option>
                  <option value="delivered" <?php echo e(request('status') == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                  <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status Pembayaran</label>
                <select name="payment_status" class="form-control">
                  <option value="">Semua</option>
                  <option value="pending" <?php echo e(request('payment_status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                  <option value="paid" <?php echo e(request('payment_status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                  <option value="failed" <?php echo e(request('payment_status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Dari Tanggal</label>
                <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Sampai Tanggal</label>
                <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-search"></i> Filter
                </button>
              </div>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table id="ordersTable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No. Pesanan</th>
              <th>Tanggal</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Status</th>
              <th>Pembayaran</th>
              <th>Metode</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><strong><?php echo e($order->order_number); ?></strong></td>
              <td><?php echo e($order->created_at->format('d M Y H:i')); ?></td>
              <td>
                <strong><?php echo e($order->customer_name); ?></strong><br>
                <small class="text-muted"><?php echo e($order->customer_email); ?></small>
              </td>
              <td>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></td>
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
              <td>
                <?php if($order->payment_status == 'paid'): ?>
                  <span class="badge badge-success">Paid</span>
                <?php elseif($order->payment_status == 'pending'): ?>
                  <span class="badge badge-warning">Pending</span>
                <?php else: ?>
                  <span class="badge badge-danger">Failed</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if($order->payment_method): ?>
                  <span class="badge badge-secondary"><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></span>
                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="btn-group">
                  <a href="<?php echo e(auth()->user()->role == 'karyawan' ? route('karyawan.orders.show', $order->order_number) : route('admin.orders.show', $order->order_number)); ?>" class="btn btn-info btn-sm" title="Detail">
                    <i class="fas fa-eye"></i>
                  </a>
                  <?php if($order->status == 'pending' && $order->payment_status == 'pending'): ?>
                  <button type="button" class="btn btn-success btn-sm btn-process" data-order-number="<?php echo e($order->order_number); ?>" title="Proses Pesanan">
                    <i class="fas fa-check"></i> Proses
                  </button>
                  <?php endif; ?>
                  <?php if($order->status == 'processing' && $order->payment_status == 'paid'): ?>
                  <button type="button" class="btn btn-primary btn-sm btn-ship" data-order-number="<?php echo e($order->order_number); ?>" title="Ubah Status ke Di Antar">
                    <i class="fas fa-truck"></i> Di Antar
                  </button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination: Prev/Next -->
        <div class="pagination-container mt-4" style="display: flex; justify-content: center; align-items: center; gap: 15px;">
          <?php if($orders->onFirstPage()): ?>
            <button class="btn btn-outline-secondary" disabled style="opacity: 0.5;">
              <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>
          <?php else: ?>
            <a href="<?php echo e($orders->previousPageUrl()); ?>" class="btn btn-outline-primary" style="text-decoration: none;">
              <i class="fas fa-chevron-left"></i> Sebelumnya
            </a>
          <?php endif; ?>

          <span class="pagination-info" style="font-size: 14px; color: #666;">
            Halaman <?php echo e($orders->currentPage()); ?> dari <?php echo e($orders->lastPage()); ?>

          </span>

          <?php if($orders->hasMorePages()): ?>
            <a href="<?php echo e($orders->nextPageUrl()); ?>" class="btn btn-outline-primary" style="text-decoration: none;">
              Berikutnya <i class="fas fa-chevron-right"></i>
            </a>
          <?php else: ?>
            <button class="btn btn-outline-secondary" disabled style="opacity: 0.5;">
              Berikutnya <i class="fas fa-chevron-right"></i>
            </button>
          <?php endif; ?>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  $(function () {
    $("#ordersTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "order": [[1, "desc"]],
      "pageLength": 25,
      "paging": false,
      "info": false
    });

    // Function to show alert
    function showAlert(message, type) {
      const alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
        message +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        '</div>';
      $('body').append(alertHtml);
      setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
          $(this).remove();
        });
      }, 3000);
    }

    // Handle process order button
    $('.btn-process').on('click', function() {
      const orderNumber = $(this).data('order-number');
      const button = $(this);
      const row = button.closest('tr');
      
      if (!confirm('Apakah Anda yakin ingin memproses pesanan ' + orderNumber + '?\nPembayaran akan diubah menjadi "Paid" dan status menjadi "Processing".')) {
        return;
      }

      // Disable button and show loading
      button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

      const route = "<?php echo e(auth()->user()->role == 'karyawan' ? route('karyawan.orders.process', ':orderNumber') : route('admin.orders.process', ':orderNumber')); ?>".replace(':orderNumber', orderNumber);

      $.ajax({
        url: route,
        method: 'POST',
        data: {
          _token: '<?php echo e(csrf_token()); ?>'
        },
        success: function(response) {
          if (response.success) {
            // Show success message
            showAlert(response.message || 'Pesanan berhasil diproses', 'success');

            // Update status badges
            row.find('td:eq(4)').html('<span class="badge badge-info">Proses</span>');
            row.find('td:eq(5)').html('<span class="badge badge-success">Paid</span>');

            // Remove process button and add ship button
            button.remove();
            const shipButton = '<button type="button" class="btn btn-primary btn-sm btn-ship" data-order-number="' + orderNumber + '" title="Ubah Status ke Di Antar"><i class="fas fa-truck"></i> Di Antar</button>';
            row.find('td:eq(7) .btn-group').append(shipButton);

            // Reload page after 1.5 seconds to update statistics
            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        },
        error: function(xhr) {
          button.prop('disabled', false).html('<i class="fas fa-check"></i> Proses');
          const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses pesanan';
          showAlert(message, 'danger');
        }
      });
    });

    // Handle ship order button (Di Antar)
    $(document).on('click', '.btn-ship', function() {
      const orderNumber = $(this).data('order-number');
      const button = $(this);
      const row = button.closest('tr');
      
      if (!confirm('Apakah Anda yakin ingin mengubah status pesanan ' + orderNumber + ' menjadi "Di Antar"?')) {
        return;
      }

      // Disable button and show loading
      button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

      const route = "<?php echo e(auth()->user()->role == 'karyawan' ? route('karyawan.orders.ship', ':orderNumber') : route('admin.orders.ship', ':orderNumber')); ?>".replace(':orderNumber', orderNumber);

      $.ajax({
        url: route,
        method: 'POST',
        data: {
          _token: '<?php echo e(csrf_token()); ?>'
        },
        success: function(response) {
          if (response.success) {
            // Show success message
            showAlert(response.message || 'Status pesanan berhasil diubah menjadi Di Antar', 'success');

            // Update status badge
            row.find('td:eq(4)').html('<span class="badge badge-primary">Di Antar</span>');

            // Remove ship button
            button.remove();

            // Reload page after 1.5 seconds to update statistics
            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        },
        error: function(xhr) {
          button.prop('disabled', false).html('<i class="fas fa-truck"></i> Di Antar');
          const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat mengubah status pesanan';
          showAlert(message, 'danger');
        }
      });
    });
  });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/jktsweetdessert/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>
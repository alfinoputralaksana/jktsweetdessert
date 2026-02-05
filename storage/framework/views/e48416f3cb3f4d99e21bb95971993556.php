

<?php $__env->startSection('page_title', 'Employee Dashboard'); ?>
<?php $__env->startSection('breadcrumb', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo e($totalOrders); ?></h3>
        <p>Total Orders</p>
      </div>
      <div class="icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?php echo e($pendingOrders); ?></h3>
        <p>Pending Orders</p>
      </div>
      <div class="icon">
        <i class="fas fa-clock"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3><?php echo e($processingOrders); ?></h3>
        <p>Processing Orders</p>
      </div>
      <div class="icon">
        <i class="fas fa-cog"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?php echo e($lowStockProducts); ?></h3>
        <p>Low Stock Products</p>
      </div>
      <div class="icon">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->

<div class="row">
  <div class="col-md-8">
    <!-- Recent Orders -->
    <div class="card">
      <div class="card-header border-transparent">
        <h3 class="card-title">Recent Orders</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
            <tr>
              <th>Order Number</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><a href="#"><?php echo e($order->order_number); ?></a></td>
              <td><?php echo e($order->customer_name); ?></td>
              <td>Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></td>
              <td>
                <?php if($order->status == 'pending'): ?>
                  <span class="badge badge-warning">Pending</span>
                <?php elseif($order->status == 'processing'): ?>
                  <span class="badge badge-info">Processing</span>
                <?php elseif($order->status == 'shipped'): ?>
                  <span class="badge badge-primary">Di Antar</span>
                <?php elseif($order->status == 'delivered'): ?>
                  <span class="badge badge-success">Delivered</span>
                <?php else: ?>
                  <span class="badge badge-danger">Cancelled</span>
                <?php endif; ?>
              </td>
              <td><?php echo e($order->created_at->format('d M Y')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>

  <div class="col-md-4">
    <!-- Low Stock Alert -->
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Low Stock Products</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">
          <?php $__empty_1 = true; $__currentLoopData = $lowStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <li class="item">
            <div class="product-img">
              <img src="<?php echo e(asset($product->image ?: 'assets/images/r1.jpg')); ?>" alt="Product Image" class="img-size-50">
            </div>
            <div class="product-info">
              <a href="#" class="product-title"><?php echo e($product->name); ?>

                <span class="badge badge-warning float-right"><?php echo e($product->stock); ?> left</span>
              </a>
              <span class="product-description">
                <?php echo e($product->category->name); ?>

              </span>
            </div>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <li class="item">
            <div class="product-info">
              <span class="product-title">No low stock items</span>
            </div>
          </li>
          <?php endif; ?>
        </ul>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jktsweetdessert\resources\views/karyawan/dashboard.blade.php ENDPATH**/ ?>
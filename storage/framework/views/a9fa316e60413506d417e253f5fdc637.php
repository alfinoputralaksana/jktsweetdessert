<?php $__env->startSection('page_title', 'Dashboard'); ?>
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
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?php echo e($totalProducts); ?></h3>
        <p>Total Products</p>
      </div>
      <div class="icon">
        <i class="fas fa-box"></i>
      </div>
      <a href="<?php echo e(route('admin.products.index')); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?php echo e($totalCategories); ?></h3>
        <p>Categories</p>
      </div>
      <div class="icon">
        <i class="fas fa-tags"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h3>
        <p>Total Revenue</p>
      </div>
      <div class="icon">
        <i class="fas fa-dollar-sign"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
    <!-- Top Products -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Top Products</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">
          <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="item">
            <div class="product-img">
              <img src="<?php echo e(asset($product->image ?: 'assets/images/r1.jpg')); ?>" alt="Product Image" class="img-size-50">
            </div>
            <div class="product-info">
              <a href="<?php echo e(route('admin.products.show', $product->id)); ?>" class="product-title"><?php echo e($product->name); ?>

                <span class="badge badge-warning float-right"><?php echo e($product->sold_count); ?> sold</span>
              </a>
              <span class="product-description">
                <?php echo e($product->category->name); ?> - Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

              </span>
            </div>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- Quick Actions -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Quick Actions</h3>
      </div>
      <div class="card-body">
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary btn-block mb-2">
          <i class="fas fa-plus"></i> Add New Product
        </a>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-info btn-block mb-2">
          <i class="fas fa-box"></i> Manage Products
        </a>
        <a href="<?php echo e(route('forecasting.index')); ?>" class="btn btn-success btn-block">
          <i class="fas fa-chart-line"></i> View Forecasting
        </a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/jktsweetdessert/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>
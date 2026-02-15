

<?php $__env->startSection('page_title', 'Product Details'); ?>
<?php $__env->startSection('breadcrumb', 'Products / View'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><?php echo e($product->name); ?></h3>
        <div class="card-tools">
          <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
          </a>
          <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-5">
            <img src="<?php echo e(asset($product->image ?: 'assets/images/r1.jpg')); ?>" alt="<?php echo e($product->name); ?>" class="img-fluid img-thumbnail">
          </div>
          <div class="col-md-7">
            <table class="table table-bordered">
              <tr>
                <th width="40%">Product Name</th>
                <td><?php echo e($product->name); ?></td>
              </tr>
              <tr>
                <th>Category</th>
                <td><span class="badge badge-info"><?php echo e($product->category->name); ?></span></td>
              </tr>
              <tr>
                <th>Price</th>
                <td><strong>Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></strong></td>
              </tr>
              <tr>
                <th>Stock</th>
                <td>
                  <?php if($product->stock > 10): ?>
                    <span class="badge badge-success"><?php echo e($product->stock); ?> units</span>
                  <?php elseif($product->stock > 0): ?>
                    <span class="badge badge-warning"><?php echo e($product->stock); ?> units</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Out of Stock</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Total Sold</th>
                <td><span class="badge badge-primary"><?php echo e($product->sold_count); ?> units</span></td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <?php if($product->is_active): ?>
                    <span class="badge badge-success">Active</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Inactive</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Created</th>
                <td><?php echo e($product->created_at->format('d M Y H:i')); ?></td>
              </tr>
              <tr>
                <th>Last Updated</th>
                <td><?php echo e($product->updated_at->format('d M Y H:i')); ?></td>
              </tr>
            </table>
          </div>
        </div>

        <?php if($product->description): ?>
        <div class="mt-3">
          <h5>Description</h5>
          <p><?php echo e($product->description); ?></p>
        </div>
        <?php endif; ?>
      </div>
      <div class="card-footer">
        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-warning">
          <i class="fas fa-edit"></i> Edit Product
        </a>
        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
          <?php echo csrf_field(); ?>
          <?php echo method_field('DELETE'); ?>
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> Delete Product
          </button>
        </form>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary float-right">
          <i class="fas fa-arrow-left"></i> Back to List
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">Quick Actions</h3>
      </div>
      <div class="card-body">
        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-warning btn-block mb-2">
          <i class="fas fa-edit"></i> Edit Product
        </a>
        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="btn btn-info btn-block mb-2" target="_blank">
          <i class="fas fa-eye"></i> View on Website
        </a>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary btn-block">
          <i class="fas fa-list"></i> All Products
        </a>
      </div>
    </div>

    <div class="card card-secondary">
      <div class="card-header">
        <h3 class="card-title">Product Statistics</h3>
      </div>
      <div class="card-body">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success"><i class="fas fa-box"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Stock Available</span>
            <span class="info-box-number"><?php echo e($product->stock); ?></span>
          </div>
        </div>
        <div class="info-box mb-3">
          <span class="info-box-icon bg-primary"><i class="fas fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Sold</span>
            <span class="info-box-number"><?php echo e($product->sold_count); ?></span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-dollar-sign"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Revenue</span>
            <span class="info-box-number">Rp <?php echo e(number_format($product->price * $product->sold_count, 0, ',', '.')); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jktsweetdessert\resources\views/admin/products/show.blade.php ENDPATH**/ ?>
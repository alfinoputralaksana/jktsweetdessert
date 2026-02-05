

<?php $__env->startSection('page_title', 'Product Management'); ?>
<?php $__env->startSection('breadcrumb', 'Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Products List</h3>
        <div class="card-tools">
          <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New Product
          </a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="productsTable" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Sold</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td>
              <img src="<?php echo e(asset($product->image ?: 'assets/images/r1.jpg')); ?>" alt="<?php echo e($product->name); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
            </td>
            <td><?php echo e($product->name); ?></td>
            <td><span class="badge badge-info"><?php echo e($product->category->name); ?></span></td>
            <td>Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></td>
            <td>
              <?php if($product->stock > 10): ?>
                <span class="badge badge-success"><?php echo e($product->stock); ?></span>
              <?php elseif($product->stock > 0): ?>
                <span class="badge badge-warning"><?php echo e($product->stock); ?></span>
              <?php else: ?>
                <span class="badge badge-danger">Out of Stock</span>
              <?php endif; ?>
            </td>
            <td><?php echo e($product->sold_count); ?></td>
            <td>
              <?php if($product->is_active): ?>
                <span class="badge badge-success">Active</span>
              <?php else: ?>
                <span class="badge badge-danger">Inactive</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="btn-group">
                <a href="<?php echo e(route('admin.products.show', $product->id)); ?>" class="btn btn-info btn-sm" title="View">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-warning btn-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
          <tfoot>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Sold</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
          </tfoot>
        </table>
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
    $("#productsTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "order": [[1, "asc"]],
      "pageLength": 25
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jktsweetdessert\resources\views/admin/products/index.blade.php ENDPATH**/ ?>
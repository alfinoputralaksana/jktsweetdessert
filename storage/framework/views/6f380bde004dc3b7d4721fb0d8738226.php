

<?php $__env->startSection('page_title', 'Karyawan Management'); ?>
<?php $__env->startSection('breadcrumb', 'Karyawan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Karyawan</h3>
        <div class="card-tools">
          <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Karyawan Baru
          </a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="usersTable" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Tanggal Dibuat</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($users->firstItem() + $index); ?></td>
            <td><?php echo e($user->name); ?></td>
            <td><?php echo e($user->email); ?></td>
            <td>
              <span class="badge badge-info"><?php echo e(ucfirst($user->role)); ?></span>
            </td>
            <td><?php echo e($user->created_at->format('d M Y')); ?></td>
            <td>
              <div class="btn-group">
                <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" class="btn btn-info btn-sm" title="View">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-warning btn-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun karyawan ini?')">
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
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Tanggal Dibuat</th>
            <th>Actions</th>
          </tr>
          </tfoot>
        </table>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
          <?php echo e($users->links()); ?>

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
    $("#usersTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "order": [[1, "asc"]],
      "pageLength": 25,
      "paging": false,
      "info": false
    });
  });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jktsweetdessert\resources\views/admin/users/index.blade.php ENDPATH**/ ?>
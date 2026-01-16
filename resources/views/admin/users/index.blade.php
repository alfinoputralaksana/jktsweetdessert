@extends('layouts.admin')

@section('page_title', 'Karyawan Management')
@section('breadcrumb', 'Karyawan')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Karyawan</h3>
        <div class="card-tools">
          <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
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
          @foreach($users as $index => $user)
          <tr>
            <td>{{ $users->firstItem() + $index }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              <span class="badge badge-info">{{ ucfirst($user->role) }}</span>
            </td>
            <td>{{ $user->created_at->format('d M Y') }}</td>
            <td>
              <div class="btn-group">
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm" title="View">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun karyawan ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
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
          {{ $users->links() }}
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('scripts')
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
@endsection


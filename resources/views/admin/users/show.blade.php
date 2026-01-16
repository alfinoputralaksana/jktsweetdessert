@extends('layouts.admin')

@section('page_title', 'Detail Karyawan')
@section('breadcrumb', 'Karyawan / Detail')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Detail Karyawan</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tr>
            <th width="30%">Nama</th>
            <td>{{ $user->name }}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
          </tr>
          <tr>
            <th>Role</th>
            <td><span class="badge badge-info">{{ ucfirst($user->role) }}</span></td>
          </tr>
          <tr>
            <th>Tanggal Dibuat</th>
            <td>{{ $user->created_at->format('d M Y H:i:s') }}</td>
          </tr>
          <tr>
            <th>Terakhir Diupdate</th>
            <td>{{ $user->updated_at->format('d M Y H:i:s') }}</td>
          </tr>
        </table>
      </div>
      <div class="card-footer">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
          <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>
    </div>
  </div>
</div>
@endsection


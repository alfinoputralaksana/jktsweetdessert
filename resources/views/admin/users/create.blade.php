@extends('layouts.admin')

@section('page_title', 'Tambah Karyawan Baru')
@section('breadcrumb', 'Karyawan / Create')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Informasi Karyawan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">Nama Lengkap *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required>
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group">
            <label for="password">Password *</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" required>
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
            <small class="form-text text-muted">Minimal 8 karakter</small>
          </div>

          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password *</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Karyawan
          </button>
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">Informasi</h3>
      </div>
      <div class="card-body">
        <p><strong>Role:</strong> Karyawan</p>
        <p class="text-muted">Akun yang dibuat akan memiliki akses sebagai karyawan dan dapat mengakses dashboard karyawan.</p>
      </div>
    </div>
  </div>
</div>
@endsection


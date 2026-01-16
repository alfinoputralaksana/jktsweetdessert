@extends('layouts.admin')

@section('page_title', 'Detail Peramalan')
@section('breadcrumb', 'Peramalan / Detail')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ $product->name }} - Detail Peramalan</h3>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-box"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Nama Produk</span>
                <span class="info-box-number">{{ $product->name }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-tags"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Kategori</span>
                <span class="info-box-number">{{ $product->category->name }}</span>
              </div>
            </div>
          </div>
        </div>

        @if(isset($isAccurate) && !$isAccurate)
          <div class="alert alert-warning">
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan Data Terbatas</h5>
            <p class="mb-0">Peramalan ini didasarkan pada data penjualan kurang dari 3 bulan ({{ $salesData->count() }} {{ $salesData->count() == 1 ? 'bulan' : 'bulan' }}). Prediksi mungkin kurang akurat. Data penjualan yang lebih banyak akan meningkatkan akurasi peramalan.</p>
          </div>
        @endif
        
        <div class="alert {{ isset($isAccurate) && !$isAccurate ? 'alert-warning' : 'alert-info' }}">
          <h4><i class="icon fas fa-info"></i> Prediksi Peramalan</h4>
          <p class="mb-0">
            <strong>Prediksi Penjualan Bulan Depan: <span style="font-size: 1.5em;">{{ $forecast }}</span> unit</strong>
          </p>
          <small>Berdasarkan metode Simple Moving Average (SMA) dengan periode {{ min($salesData->count(), 3) }}</small>
        </div>

        <h5>Riwayat Penjualan (12 Bulan Terakhir)</h5>
        @if($salesData->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Bulan</th>
                  <th>Tahun</th>
                  <th>Total Terjual (unit)</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $months = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                  ];
                @endphp
                @foreach($salesData as $data)
                  <tr>
                    <td>{{ $months[$data->month] ?? date('F', mktime(0, 0, 0, $data->month, 1)) }}</td>
                    <td>{{ $data->year }}</td>
                    <td><strong>{{ $data->total_sold }}</strong></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="alert alert-warning">
            <p class="mb-0">Tidak ada data penjualan tersedia untuk produk ini.</p>
          </div>
        @endif
      </div>
      <div class="card-footer">
        <a href="{{ route('forecasting.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Kembali ke Peramalan
        </a>
        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-info" target="_blank">
          <i class="fas fa-eye"></i> Lihat Produk
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">Informasi Produk</h3>
      </div>
      <div class="card-body">
        <dl>
          <dt>Nama Produk</dt>
          <dd>{{ $product->name }}</dd>
          <dt>Kategori</dt>
          <dd><span class="badge badge-info">{{ $product->category->name }}</span></dd>
          <dt>Harga</dt>
          <dd>Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
          <dt>Stok</dt>
          <dd>
            @if($product->stock > 10)
              <span class="badge badge-success">{{ $product->stock }}</span>
            @elseif($product->stock > 0)
              <span class="badge badge-warning">{{ $product->stock }}</span>
            @else
              <span class="badge badge-danger">Stok Habis</span>
            @endif
          </dd>
          <dt>Total Terjual</dt>
          <dd><span class="badge badge-primary">{{ $product->sold_count }}</span></dd>
        </dl>
      </div>
    </div>

    <div class="card card-secondary">
      <div class="card-header">
        <h3 class="card-title">Tentang Metode SMA</h3>
      </div>
      <div class="card-body">
        <p><strong>Simple Moving Average (SMA)</strong> adalah metode peramalan yang menghitung rata-rata dari N periode terakhir untuk memprediksi nilai di masa depan.</p>
        <p>Dalam sistem ini, kami menggunakan periode 3 bulan untuk meramalkan penjualan bulan berikutnya.</p>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.admin')

@section('page_title', 'Sales Forecasting')
@section('breadcrumb', 'Forecasting')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Peramalan Penjualan - Metode Simple Moving Average (SMA)</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @if(count($forecasts) > 0)
          @if(collect($forecasts)->where('is_accurate', false)->count() > 0)
            <div class="alert alert-warning">
              <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan Data Terbatas</h5>
              Beberapa produk memiliki data penjualan kurang dari 3 bulan. Peramalan untuk produk-produk ini mungkin kurang akurat. Data yang lebih banyak akan meningkatkan akurasi peramalan.
            </div>
          @endif
          <div class="table-responsive">
            <table id="forecastingTable" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>Nama Produk</th>
                  <th>Kategori</th>
                  <th>Penjualan Saat Ini (Bulan Lalu)</th>
                  <th>Peramalan (Bulan Depan)</th>
                  <th>Periode Data</th>
                  <th>Tren</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($forecasts as $forecast)
                  <tr>
                    <td><strong>{{ $forecast['product']->name }}</strong></td>
                    <td><span class="badge badge-info">{{ $forecast['product']->category->name }}</span></td>
                    <td><span class="badge badge-secondary">{{ $forecast['current_sales'] }} unit</span></td>
                    <td>
                      <span class="badge badge-primary" style="font-size: 1.1em;">{{ $forecast['forecast'] }} unit</span>
                      @if(!$forecast['is_accurate'])
                        <br><small class="text-warning"><i class="fas fa-exclamation-triangle"></i> Data terbatas</small>
                      @endif
                    </td>
                    <td>
                      <span class="badge {{ $forecast['is_accurate'] ? 'badge-success' : 'badge-warning' }}">
                        {{ $forecast['data_months'] }} {{ $forecast['data_months'] == 1 ? 'bulan' : 'bulan' }}
                      </span>
                    </td>
                    <td>
                      @if($forecast['trend'] == 'up')
                        <span class="badge badge-success">
                          <i class="fas fa-arrow-up"></i> Meningkat
                        </span>
                      @else
                        <span class="badge badge-warning">
                          <i class="fas fa-arrow-down"></i> Menurun
                        </span>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('forecasting.show', $forecast['product']->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-chart-line"></i> Lihat Detail
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="alert alert-info">
            <h5><i class="icon fas fa-info"></i> Data Peramalan Tidak Tersedia</h5>
            Tidak ada data penjualan ditemukan untuk produk aktif. Mulai menjual produk untuk melihat prediksi peramalan.
          </div>
        @endif
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
    $("#forecastingTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "order": [[3, "desc"]],
      "pageLength": 25
    });
  });
</script>
@endsection

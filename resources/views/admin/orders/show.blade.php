@extends('layouts.admin')

@section('page_title', 'Detail Penjualan')
@section('breadcrumb', 'Detail Penjualan')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Detail Pesanan - {{ $order->order_number }}</h3>
        <div class="card-tools">
          <a href="{{ auth()->user()->role == 'karyawan' ? route('karyawan.orders.index') : route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <h5><i class="fas fa-user"></i> Informasi Customer</h5>
            <table class="table table-borderless">
              <tr>
                <td width="40%"><strong>Nama:</strong></td>
                <td>{{ $order->customer_name }}</td>
              </tr>
              <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $order->customer_email }}</td>
              </tr>
              <tr>
                <td><strong>Telepon:</strong></td>
                <td>{{ $order->customer_phone }}</td>
              </tr>
              <tr>
                <td><strong>Alamat:</strong></td>
                <td>{{ $order->customer_address }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h5><i class="fas fa-info-circle"></i> Informasi Pesanan</h5>
            <table class="table table-borderless">
              <tr>
                <td width="40%"><strong>Tanggal:</strong></td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
              </tr>
              <tr>
                <td><strong>Status:</strong></td>
                <td>
                  @if($order->status == 'pending')
                    <span class="badge badge-warning">Pending</span>
                  @elseif($order->status == 'processing')
                    <span class="badge badge-info">Proses</span>
                  @elseif($order->status == 'shipped')
                    <span class="badge badge-primary">Di Antar</span>
                  @elseif($order->status == 'delivered')
                    <span class="badge badge-success">Delivered</span>
                  @else
                    <span class="badge badge-danger">Cancelled</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td><strong>Status Pembayaran:</strong></td>
                <td>
                  @if($order->payment_status == 'paid')
                    <span class="badge badge-success">Paid</span>
                  @elseif($order->payment_status == 'pending')
                    <span class="badge badge-warning">Pending</span>
                  @else
                    <span class="badge badge-danger">Failed</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td><strong>Metode Pembayaran:</strong></td>
                <td>
                  @if($order->payment_method)
                    {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Update Status Form -->
        <div class="card card-primary collapsed-card mb-4">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-cog"></i> Proses Pesanan - Update Status</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ auth()->user()->role == 'karyawan' ? route('karyawan.orders.updateStatus', $order->order_number) : route('admin.orders.updateStatus', $order->order_number) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Status Pesanan</label>
                    <select name="status" class="form-control" required>
                      <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                      <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Proses</option>
                      <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Di Antar</option>
                      <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                      <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Status Pembayaran</label>
                    <select name="payment_status" class="form-control" required>
                      <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                      <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                      <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan & Proses Pesanan
              </button>
            </form>
          </div>
        </div>

        <!-- Order Items -->
        <h5><i class="fas fa-shopping-bag"></i> Item Pesanan</h5>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Quantity</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
              <tr>
                <td>{{ $item->product_name }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                <td><strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></td>
              </tr>
              <tr>
                <td colspan="3" class="text-right"><strong>Ongkir:</strong></td>
                <td><strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong></td>
              </tr>
              <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>

        @if($order->notes)
        <div class="mt-3">
          <h5><i class="fas fa-sticky-note"></i> Catatan</h5>
          <p class="text-muted">{{ $order->notes }}</p>
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


@extends('layouts.admin')

@section('page_title', 'Employee Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $totalOrders }}</h3>
        <p>Total Orders</p>
      </div>
      <div class="icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $pendingOrders }}</h3>
        <p>Pending Orders</p>
      </div>
      <div class="icon">
        <i class="fas fa-clock"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ $processingOrders }}</h3>
        <p>Processing Orders</p>
      </div>
      <div class="icon">
        <i class="fas fa-cog"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ $lowStockProducts }}</h3>
        <p>Low Stock Products</p>
      </div>
      <div class="icon">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
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
            @foreach($recentOrders as $order)
            <tr>
              <td><a href="#">{{ $order->order_number }}</a></td>
              <td>{{ $order->customer_name }}</td>
              <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
              <td>
                @if($order->status == 'pending')
                  <span class="badge badge-warning">Pending</span>
                @elseif($order->status == 'processing')
                  <span class="badge badge-info">Processing</span>
                @elseif($order->status == 'shipped')
                  <span class="badge badge-primary">Di Antar</span>
                @elseif($order->status == 'delivered')
                  <span class="badge badge-success">Delivered</span>
                @else
                  <span class="badge badge-danger">Cancelled</span>
                @endif
              </td>
              <td>{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
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
    <!-- Low Stock Alert -->
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Low Stock Products</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">
          @forelse($lowStockItems as $product)
          <li class="item">
            <div class="product-img">
              <img src="{{ asset($product->image ?: 'assets/images/r1.jpg') }}" alt="Product Image" class="img-size-50">
            </div>
            <div class="product-info">
              <a href="#" class="product-title">{{ $product->name }}
                <span class="badge badge-warning float-right">{{ $product->stock }} left</span>
              </a>
              <span class="product-description">
                {{ $product->category->name }}
              </span>
            </div>
          </li>
          @empty
          <li class="item">
            <div class="product-info">
              <span class="product-title">No low stock items</span>
            </div>
          </li>
          @endforelse
        </ul>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection


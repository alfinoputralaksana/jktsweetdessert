@extends('layouts.admin')

@section('page_title', 'Product Details')
@section('breadcrumb', 'Products / View')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">{{ $product->name }}</h3>
        <div class="card-tools">
          <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
          </a>
          <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-5">
            <img src="{{ asset($product->image ?: 'assets/images/r1.jpg') }}" alt="{{ $product->name }}" class="img-fluid img-thumbnail">
          </div>
          <div class="col-md-7">
            <table class="table table-bordered">
              <tr>
                <th width="40%">Product Name</th>
                <td>{{ $product->name }}</td>
              </tr>
              <tr>
                <th>Category</th>
                <td><span class="badge badge-info">{{ $product->category->name }}</span></td>
              </tr>
              <tr>
                <th>Price</th>
                <td><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></td>
              </tr>
              <tr>
                <th>Stock</th>
                <td>
                  @if($product->stock > 10)
                    <span class="badge badge-success">{{ $product->stock }} units</span>
                  @elseif($product->stock > 0)
                    <span class="badge badge-warning">{{ $product->stock }} units</span>
                  @else
                    <span class="badge badge-danger">Out of Stock</span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Total Sold</th>
                <td><span class="badge badge-primary">{{ $product->sold_count }} units</span></td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  @if($product->is_active)
                    <span class="badge badge-success">Active</span>
                  @else
                    <span class="badge badge-danger">Inactive</span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Created</th>
                <td>{{ $product->created_at->format('d M Y H:i') }}</td>
              </tr>
              <tr>
                <th>Last Updated</th>
                <td>{{ $product->updated_at->format('d M Y H:i') }}</td>
              </tr>
            </table>
          </div>
        </div>

        @if($product->description)
        <div class="mt-3">
          <h5>Description</h5>
          <p>{{ $product->description }}</p>
        </div>
        @endif
      </div>
      <div class="card-footer">
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
          <i class="fas fa-edit"></i> Edit Product
        </a>
        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> Delete Product
          </button>
        </form>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary float-right">
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
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-block mb-2">
          <i class="fas fa-edit"></i> Edit Product
        </a>
        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-info btn-block mb-2" target="_blank">
          <i class="fas fa-eye"></i> View on Website
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-block">
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
            <span class="info-box-number">{{ $product->stock }}</span>
          </div>
        </div>
        <div class="info-box mb-3">
          <span class="info-box-icon bg-primary"><i class="fas fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Sold</span>
            <span class="info-box-number">{{ $product->sold_count }}</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-dollar-sign"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Revenue</span>
            <span class="info-box-number">Rp {{ number_format($product->price * $product->sold_count, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

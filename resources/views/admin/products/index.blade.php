@extends('layouts.admin')

@section('page_title', 'Product Management')
@section('breadcrumb', 'Products')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Products List</h3>
        <div class="card-tools">
          <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
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
          @foreach($products as $product)
          <tr>
            <td>
              <img src="{{ asset($product->image ?: 'assets/images/r1.jpg') }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
            </td>
            <td>{{ $product->name }}</td>
            <td><span class="badge badge-info">{{ $product->category->name }}</span></td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>
              @if($product->stock > 10)
                <span class="badge badge-success">{{ $product->stock }}</span>
              @elseif($product->stock > 0)
                <span class="badge badge-warning">{{ $product->stock }}</span>
              @else
                <span class="badge badge-danger">Out of Stock</span>
              @endif
            </td>
            <td>{{ $product->sold_count }}</td>
            <td>
              @if($product->is_active)
                <span class="badge badge-success">Active</span>
              @else
                <span class="badge badge-danger">Inactive</span>
              @endif
            </td>
            <td>
              <div class="btn-group">
                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm" title="View">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
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
@endsection

@section('scripts')
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
@endsection

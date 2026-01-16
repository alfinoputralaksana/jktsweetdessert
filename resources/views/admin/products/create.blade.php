@extends('layouts.admin')

@section('page_title', 'Add New Product')
@section('breadcrumb', 'Products / Create')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Product Information</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="name">Product Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter product name" value="{{ old('name') }}" required>
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="category_id">Category *</label>
                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter product description">{{ old('description') }}</textarea>
                @error('description')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="price">Price *</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                      </div>
                      <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" step="0.01" placeholder="0.00" value="{{ old('price') }}" required>
                      @error('price')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" placeholder="0" value="{{ old('stock', 0) }}" required>
                    @error('stock')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="image">Product Image</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    <label class="custom-file-label" for="image">Choose file</label>
                  </div>
                </div>
                <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                @error('image')
                  <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="col-md-4">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Settings</h3>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                    <small class="form-text text-muted">Only active products will be visible to customers</small>
                  </div>
                </div>
              </div>

              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Preview</h3>
                </div>
                <div class="card-body">
                  <div id="imagePreview" style="display: none;">
                    <img id="previewImg" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                  </div>
                  <p class="text-muted text-center" id="noPreview">No image selected</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Create Product
          </button>
          <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    // File input label
    $('.custom-file-input').on('change', function() {
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').html(fileName);
    });

    // Image preview
    $('#image').on('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          $('#previewImg').attr('src', e.target.result);
          $('#imagePreview').show();
          $('#noPreview').hide();
        };
        reader.readAsDataURL(file);
      } else {
        $('#imagePreview').hide();
        $('#noPreview').show();
      }
    });
  });
</script>
@endsection

<!DOCTYPE html>
<html>
@include('partial.header')

<head>
  <style>
    .product-detail-page {
      background: #ffffff;
      background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZm9vZFBhdHRlcm4iIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZjBmMGYwIiBzdHJva2Utd2lkdGg9IjAuNSIgb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0idXJsKCNmb29kUGF0dGVybikiLz48L3N2Zz4=');
      background-size: 200px 200px;
      background-repeat: repeat;
      min-height: 100vh;
    }

    .hero_area {
      background: transparent !important;
      padding-top: 120px;
      padding-bottom: 60px;
    }

    .product-detail {
      background: #ffffff;
      border-radius: 24px;
      padding: 50px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12),
                  0 8px 25px rgba(0, 0, 0, 0.08);
      margin-bottom: 60px;
      animation: fadeInUp 0.8s ease;
      border: 1px solid rgba(255, 255, 255, 0.8);
    }

    .product-detail .img-box {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .product-detail .img-box img {
      width: 100%;
      height: auto;
      object-fit: cover;
      transition: transform 0.6s ease;
    }

    .product-detail .img-box:hover img {
      transform: scale(1.05);
    }

    .product-detail .detail-box h2 {
      font-size: 2.8rem;
      font-weight: 800;
      color: #4a3a22;
      margin-bottom: 12px;
      line-height: 1.2;
    }

    .product-detail .detail-box .text-muted {
      display: inline-block;
      padding: 6px 14px;
      background: #f1f5f9;
      color: #64748b;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 18px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
    }

    .product-detail .detail-box .price {
      font-size: 2.5rem;
      font-weight: 800;
      color: #4a3a22;
      margin: 18px 0;
      display: block;
    }

    .product-detail .detail-box .stock {
      font-size: 16px;
      color: #475569;
      margin-bottom: 20px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .product-detail .detail-box .stock::before {
      content: '📦';
      font-size: 20px;
    }

    .product-detail .detail-box p {
      font-size: 15px;
      line-height: 1.7;
      color: #64748b;
      margin-bottom: 28px;
    }

    .product-detail .form-group label {
      font-weight: 700;
      color: #1a202c;
      margin-bottom: 10px;
      font-size: 16px;
    }

    .product-detail .form-control {
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      padding: 10px 16px;
      font-size: 15px;
      transition: all 0.3s ease;
      background: #ffffff;
      max-width: 150px;
    }

    .product-detail .form-control:focus {
      border-color: #4a3a22;
      box-shadow: 0 0 0 3px rgba(74, 58, 34, 0.1);
      outline: none;
    }

    .product-detail .btn {
      border-radius: 12px;
      padding: 14px 28px;
      font-weight: 700;
      font-size: 15px;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border: 2px solid transparent;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .product-detail .btn-primary {
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      border-color: transparent;
      color: #ffffff;
      box-shadow: 0 4px 15px rgba(74, 58, 34, 0.35);
    }

    .product-detail .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(74, 58, 34, 0.45);
    }

    .product-detail .btn-outline-secondary {
      border: 1px solid #cbd5e1;
      color: #475569;
      background: #ffffff;
    }

    .product-detail .btn-outline-secondary:hover {
      background: #f8fafc;
      border-color: #94a3b8;
      transform: translateY(-2px);
      color: #334155;
    }

    .product-detail .alert-danger {
      background: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
      color: #ffffff;
      border: none;
      border-radius: 12px;
      padding: 20px;
      font-weight: 600;
      box-shadow: 0 4px 20px rgba(252, 129, 129, 0.3);
    }

    .related-products {
      margin-top: 60px;
      animation: fadeIn 0.8s ease 0.4s both;
    }

    .related-products h3 {
      font-size: 2rem;
      font-weight: 800;
      color: #4a3a22;
      margin-bottom: 30px;
      text-align: center;
    }

    .related-products .box {
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      transition: all 0.4s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      border: 1px solid #e2e8f0;
    }

    .related-products .box:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 40px rgba(74, 58, 34, 0.2);
    }

    .related-products .img-box {
      aspect-ratio: 1 / 1;
      overflow: hidden;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .related-products .img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.6s ease;
    }

    .related-products .box:hover .img-box img {
      transform: scale(1.1);
    }

    .related-products .detail-box {
      padding: 16px;
      text-align: center;
    }

    .related-products .detail-box h5 {
      font-size: 16px;
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 8px;
    }

    .related-products .detail-box .price {
      display: none;
    }

    .related-products .detail-box .btn {
      display: none;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @media (max-width: 768px) {
      .product-detail {
        padding: 25px;
      }

      .product-detail .detail-box h2 {
        font-size: 2rem;
      }

      .product-detail .detail-box .price {
        font-size: 2.2rem;
      }

      .product-detail .d-flex {
        flex-direction: column;
      }

      .product-detail .btn {
        width: 100%;
        margin-bottom: 10px;
      }
    }
  </style>
</head>

<body class="product-detail-page">
  <div class="hero_area">
    <section class="recipe_section layout_padding-top" style="margin-top: 0;">
      <div class="container">
        <div class="row product-detail">
          <div class="col-md-6 mb-4 mb-md-0">
            <div class="img-box">
              <img src="{{ asset($product->image ?: 'assets/images/r1.jpg') }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-box">
              <h2>{{ $product->name }}</h2>
              <p class="text-muted">{{ $product->category->name }}</p>
              <h3 class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
              <p class="stock">Stock: {{ $product->stock }}</p>
              <p>{{ $product->description }}</p>
              
              @if($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                  @csrf
                  <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 100%; max-width: 200px;">
                  </div>
                  <div class="d-flex flex-column flex-sm-row gap-3" style="margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-shopping-cart"></i> ADD TO CART
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                      <i class="fa fa-arrow-left"></i> ← BACK TO PRODUCTS
                    </a>
                  </div>
                </form>
              @else
                <div class="alert alert-danger">
                  <strong>Out of Stock</strong>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-3">
                  <i class="fa fa-arrow-left"></i> Back to Products
                </a>
              @endif
            </div>
          </div>
        </div>

        @if($relatedProducts->count() > 0)
          <div class="row mt-5 related-products">
            <div class="col-12">
              <h3>Related Products</h3>
            </div>
            @foreach($relatedProducts as $related)
              <div class="col-sm-6 col-md-3 mb-4">
                <div class="box">
                  <div class="img-box">
                    <a href="{{ route('products.show', $related->slug) }}">
                      <img src="{{ asset($related->image ?: 'assets/images/r1.jpg') }}" class="box-img" alt="{{ $related->name }}">
                    </a>
                  </div>
                  <div class="detail-box">
                    <h5>{{ $related->name }}</h5>
                    <p class="price">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                    <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-outline-primary">
                      View Details
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </section>
  </div>

  @include('partial.footer')
</body>
</html>

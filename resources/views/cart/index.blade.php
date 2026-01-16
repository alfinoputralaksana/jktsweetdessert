<!DOCTYPE html>
<html>
@include('partial.header')

<head>
  <style>
    .cart-page {
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

    .cart-page-header {
      text-align: center;
      margin-bottom: 50px;
      animation: fadeInDown 0.8s ease;
    }

    .cart-page-header h2 {
      font-size: 3.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 15px;
      letter-spacing: -1px;
    }

    .cart-page-header h2::before {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      border-radius: 2px;
    }

    .cart-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
      animation: fadeInUp 0.8s ease;
    }

    .cart-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .cart-table thead {
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      border-radius: 12px 12px 0 0;
    }

    .cart-table thead th {
      padding: 20px;
      color: #ffffff;
      font-weight: 700;
      font-size: 16px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      text-align: left;
      border: none;
    }

    .cart-table thead th:first-child {
      border-radius: 12px 0 0 0;
    }

    .cart-table thead th:last-child {
      border-radius: 0 12px 0 0;
    }

    .cart-table tbody tr {
      background: #ffffff;
      border-bottom: 2px solid #f7fafc;
      transition: all 0.3s ease;
    }

    .cart-table tbody tr:hover {
      background: #f7fafc;
      transform: translateX(5px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .cart-table tbody td {
      padding: 25px 20px;
      vertical-align: middle;
      font-size: 16px;
      color: #1a202c;
    }

    .cart-table .product-info {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .cart-table .product-image {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 16px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }

    .cart-table tbody tr:hover .product-image {
      transform: scale(1.05);
    }

    .cart-table .product-name {
      font-size: 20px;
      font-weight: 700;
      color: #1a202c;
      margin-bottom: 5px;
    }

    .cart-table .product-price {
      font-size: 18px;
      font-weight: 600;
      color: #4a3a22;
    }

    .cart-table .quantity-input {
      width: 100px;
      height: 50px;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 0 15px;
      font-size: 18px;
      font-weight: 600;
      text-align: center;
      transition: all 0.3s ease;
    }

    .cart-table .quantity-input:focus {
      border-color: #4a3a22;
      box-shadow: 0 0 0 4px rgba(74, 58, 34, 0.15);
      outline: none;
    }

    .cart-table .subtotal {
      font-size: 20px;
      font-weight: 700;
      color: #1a202c;
    }

    .cart-table .btn-remove {
      padding: 12px 24px;
      background: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
      border: none;
      border-radius: 12px;
      color: #ffffff;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(252, 129, 129, 0.3);
    }

    .cart-table .btn-remove:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(252, 129, 129, 0.4);
    }

    .cart-actions {
      margin-top: 30px;
      padding-top: 30px;
      border-top: 2px solid #f7fafc;
    }

    .btn-clear {
      padding: 14px 32px;
      background: transparent;
      border: 2px solid #fc8181;
      border-radius: 12px;
      color: #fc8181;
      font-weight: 700;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .btn-clear:hover {
      background: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(252, 129, 129, 0.3);
    }

    .cart-summary {
      position: sticky;
      top: 120px;
    }

    .cart-summary .card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.3);
      overflow: hidden;
    }

    .cart-summary .card-header {
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      padding: 25px 30px;
      border: none;
    }

    .cart-summary .card-header h5 {
      color: #ffffff;
      font-size: 24px;
      font-weight: 800;
      margin: 0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .cart-summary .card-body {
      padding: 30px;
    }

    .cart-summary .summary-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 0;
      font-size: 18px;
      color: #4a5568;
      border-bottom: 1px solid #e2e8f0;
    }

    .cart-summary .summary-item:last-of-type {
      border-bottom: none;
    }

    .cart-summary .summary-item span:first-child {
      font-weight: 600;
      color: #1a202c;
    }

    .cart-summary .summary-item span:last-child {
      font-weight: 700;
      color: #4a3a22;
      font-size: 20px;
    }

    .cart-summary .summary-total {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 25px 0;
      margin-top: 15px;
      border-top: 3px solid #e2e8f0;
    }

    .cart-summary .summary-total strong {
      font-size: 24px;
      font-weight: 800;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .cart-summary .btn {
      width: 100%;
      padding: 16px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 16px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      border: 2px solid transparent;
      margin-top: 15px;
    }

    .cart-summary .btn-primary {
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      color: #ffffff;
      box-shadow: 0 4px 20px rgba(74, 58, 34, 0.4);
    }

    .cart-summary .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 30px rgba(74, 58, 34, 0.5);
    }

    .cart-summary .btn-outline-secondary {
      border-color: #cbd5e0;
      color: #4a5568;
      background: transparent;
    }

    .cart-summary .btn-outline-secondary:hover {
      background: #f7fafc;
      border-color: #a0aec0;
      transform: translateY(-2px);
    }

    .alert {
      border-radius: 16px;
      padding: 20px 25px;
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 30px;
      animation: fadeInDown 0.5s ease;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
      border: 2px solid #c3e6cb;
    }

    .alert-danger {
      background: #f8d7da;
      color: #721c24;
      border: 2px solid #f5c6cb;
    }

    .alert-info {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 2px solid #e2e8f0;
      border-radius: 20px;
      padding: 60px 40px;
      text-align: center;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .alert-info h4 {
      font-size: 28px;
      font-weight: 800;
      color: #1a202c;
      margin-bottom: 15px;
    }

    .alert-info p {
      font-size: 18px;
      color: #718096;
      margin-bottom: 25px;
    }

    .alert-info .btn {
      padding: 16px 40px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 16px;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      border: none;
      color: #ffffff;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 20px rgba(74, 58, 34, 0.4);
      transition: all 0.3s ease;
    }

    .alert-info .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 30px rgba(74, 58, 34, 0.5);
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
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

    @media (max-width: 991px) {
      .cart-summary {
        position: relative;
        top: 0;
        margin-top: 30px;
      }
    }

    @media (max-width: 768px) {
      .cart-page-header h2 {
        font-size: 2.5rem;
      }

      .cart-container {
        padding: 25px;
      }

      .cart-table thead {
        display: none;
      }

      .cart-table tbody tr {
        display: block;
        margin-bottom: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
      }

      .cart-table tbody td {
        display: block;
        padding: 15px 0;
        text-align: left;
        border: none;
      }

      .cart-table tbody td:before {
        content: attr(data-label) ": ";
        font-weight: 700;
        color: #4a3a22;
        display: inline-block;
        width: 120px;
      }

      .cart-table .product-info {
        flex-direction: column;
        align-items: flex-start;
      }

      .cart-table .product-image {
        width: 100%;
        height: 200px;
        margin-bottom: 15px;
      }

      .cart-table .quantity-input {
        width: 100%;
      }
    }
  </style>
</head>

<body class="cart-page">
  <div class="hero_area">
    <section class="recipe_section layout_padding-top" style="margin-top: 0;">
      <div class="container">
        <div class="heading_container heading_center cart-page-header">
          <h2>Shopping Cart</h2>
        </div>

        @if(session('success'))
          <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
          </div>
        @endif

        @if(count($products) > 0)
          <div class="row">
            <div class="col-lg-8">
              <div class="cart-container">
                <div class="table-responsive">
                  <table class="cart-table">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($products as $item)
                        <tr>
                          <td data-label="Product">
                            <div class="product-info">
                              <img src="{{ asset($item['image'] ?: 'assets/images/r1.jpg') }}" alt="{{ $item['name'] }}" class="product-image">
                              <div>
                                <div class="product-name">{{ $item['name'] }}</div>
                                <div class="product-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                              </div>
                            </div>
                          </td>
                          <td data-label="Price">
                            <div class="product-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                          </td>
                          <td data-label="Quantity">
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-inline">
                              @csrf
                              @method('PUT')
                              <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input" onchange="this.form.submit()">
                            </form>
                          </td>
                          <td data-label="Subtotal">
                            <div class="subtotal">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                          </td>
                          <td data-label="Action">
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn-remove">
                                <i class="fa fa-trash"></i> Remove
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                <div class="cart-actions">
                  <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn-clear">
                      <i class="fa fa-trash-alt"></i> Clear Cart
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="cart-summary">
                <div class="card">
                  <div class="card-header">
                    <h5>Order Summary</h5>
                  </div>
                  <div class="card-body">
                    <div class="summary-item">
                      <span>Subtotal</span>
                      <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                      <span>Shipping</span>
                      <span>Rp 10.000</span>
                    </div>
                    <div class="summary-total">
                      <strong>Total</strong>
                      <strong>Rp {{ number_format($total + 10000, 0, ',', '.') }}</strong>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-primary">
                      <i class="fa fa-credit-card"></i> Proceed to Checkout
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                      <i class="fa fa-arrow-left"></i> Continue Shopping
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="alert alert-info text-center">
            <h4>Your cart is empty</h4>
            <p>Start shopping to add items to your cart.</p>
            <a href="{{ route('products.index') }}" class="btn">Browse Products</a>
          </div>
        @endif
      </div>
    </section>
  </div>

  @include('partial.footer')
</body>
</html>

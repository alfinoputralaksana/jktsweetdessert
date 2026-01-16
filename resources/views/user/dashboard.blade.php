<!DOCTYPE html>
<html>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Jkt.SweetDessert - Dashboard</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

  <!-- font awesome style -->
  <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- slidck slider -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css.map" integrity="undefined" crossorigin="anonymous" />

  <!-- Custom styles for this template -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
  <!-- custom responsive style -->
  <link href="{{ asset('assets/css/custom-responsive.css') }}" rel="stylesheet" />
  <!-- modern navbar style -->
  <link href="{{ asset('assets/css/modern-navbar.css') }}" rel="stylesheet" />

  <!-- User Dropdown Script - Simple and working -->
  <script>
    (function() {
      'use strict';
      
      var dropdownInitialized = false;
      
      function initUserDropdown() {
        if (dropdownInitialized) return true;
        
        var dropdown = document.querySelector('.user-dropdown');
        var toggle = document.getElementById('userDropdown');
        
        if (!dropdown || !toggle) {
          return false;
        }
        
        dropdownInitialized = true;
        
        // Click handler untuk toggle button
        toggle.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          e.stopImmediatePropagation();
          
          var isActive = dropdown.classList.contains('active');
          
          if (isActive) {
            dropdown.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
          } else {
            dropdown.classList.add('active');
            toggle.setAttribute('aria-expanded', 'true');
          }
          
          return false;
        });
        
        // Close dropdown saat klik di luar
        document.addEventListener('click', function(e) {
          if (!dropdown || !toggle) return;
          
          // Jangan tutup jika klik pada toggle atau di dalam dropdown
          if (dropdown.contains(e.target)) {
            return;
          }
          
          // Tutup jika dropdown aktif
          if (dropdown.classList.contains('active')) {
            dropdown.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
          }
        });
        
        return true;
      }
      
      // Multiple initialization attempts
      function tryInit() {
        if (!initUserDropdown()) {
          setTimeout(tryInit, 100);
        }
      }
      
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', tryInit);
      } else {
        tryInit();
      }
      
      // Backup dengan window load
      window.addEventListener('load', function() {
        setTimeout(tryInit, 50);
      });
    })();
  </script>

  <style>
    body {
      background: #f8f9fa;
      min-height: 100vh;
    }

    /* Override hero_area background for dashboard */
    .hero_area {
      background-image: none !important;
      background: #f8f9fa;
      min-height: 100vh;
    }

    .dashboard-container {
      padding: 40px 0;
      background: transparent;
    }

    .dashboard-header {
      text-align: center;
      margin-bottom: 50px;
      animation: fadeInDown 0.6s ease;
      padding: 20px 0;
    }

    .dashboard-header h2 {
      font-size: 2.5rem;
      font-weight: 800;
      color: #4a3a22;
      margin-bottom: 15px;
      letter-spacing: -0.5px;
    }

    .dashboard-header .welcome-text {
      font-size: 1.1rem;
      color: #64748b;
      font-weight: 400;
      margin: 0;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-bottom: 50px;
    }

    .stat-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 35px 30px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08),
                  0 1px 3px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(74, 58, 34, 0.1);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      animation: fadeInUp 0.6s ease;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #4a3a22 0%, #8e6f41 100%);
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
      transform: scaleX(1);
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(74, 58, 34, 0.15),
                  0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .stat-card:nth-child(1) {
      animation-delay: 0.1s;
    }

    .stat-card:nth-child(2) {
      animation-delay: 0.2s;
    }

    .stat-card:nth-child(3) {
      animation-delay: 0.3s;
    }

    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      margin-bottom: 20px;
      position: relative;
    }

    .stat-card:nth-child(1) .stat-icon {
      background: linear-gradient(135deg, rgba(255, 107, 107, 0.15) 0%, rgba(255, 107, 107, 0.05) 100%);
      color: #ff6b6b;
    }

    .stat-card:nth-child(2) .stat-icon {
      background: linear-gradient(135deg, rgba(81, 207, 102, 0.15) 0%, rgba(81, 207, 102, 0.05) 100%);
      color: #51cf66;
    }

    .stat-card:nth-child(3) .stat-icon {
      background: linear-gradient(135deg, rgba(74, 58, 34, 0.15) 0%, rgba(74, 58, 34, 0.05) 100%);
      color: #4a3a22;
    }

    .stat-value {
      font-size: 2.2rem;
      font-weight: 800;
      color: #1a202c;
      margin-bottom: 8px;
      line-height: 1.2;
      word-break: break-word;
    }

    .stat-label {
      font-size: 1rem;
      font-weight: 600;
      color: #4a3a22;
      margin-bottom: 5px;
    }

    .stat-description {
      font-size: 0.875rem;
      color: #64748b;
      margin: 0;
    }

    .orders-section {
      background: #ffffff;
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08),
                  0 1px 3px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(74, 58, 34, 0.1);
      animation: fadeInUp 0.8s ease 0.4s both;
      margin-top: 30px;
    }

    .orders-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      flex-wrap: wrap;
      gap: 15px;
    }

    .orders-header h3 {
      font-size: 1.75rem;
      font-weight: 700;
      color: #4a3a22;
      margin: 0;
    }

    .orders-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .orders-table thead {
      background: linear-gradient(135deg, #4a3a22 0%, #634e2e 100%);
      border-radius: 12px 12px 0 0;
    }

    .orders-table thead th {
      padding: 18px 20px;
      color: #ffffff;
      font-weight: 600;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      text-align: left;
      border: none;
    }

    .orders-table thead th:first-child {
      border-radius: 12px 0 0 0;
    }

    .orders-table thead th:last-child {
      border-radius: 0 12px 0 0;
    }

    .orders-table tbody tr {
      background: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      transition: all 0.2s ease;
    }

    .orders-table tbody tr:hover {
      background: #f8f9fa;
      transform: translateX(3px);
      box-shadow: 0 2px 8px rgba(74, 58, 34, 0.08);
    }

    .orders-table tbody tr:last-child {
      border-bottom: none;
    }

    .orders-table tbody td {
      padding: 20px;
      color: #1a202c;
      font-size: 15px;
      vertical-align: middle;
    }

    .orders-table tbody td strong {
      color: #4a3a22;
      font-weight: 600;
    }

    .badge {
      display: inline-block;
      padding: 6px 14px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    .badge-pending {
      background: linear-gradient(135deg, #ffd43b 0%, #ffc107 100%);
      color: #000;
    }

    .badge-processing {
      background: linear-gradient(135deg, #4dabf7 0%, #339af0 100%);
      color: #ffffff;
    }

    .badge-shipped {
      background: linear-gradient(135deg, #339af0 0%, #228be6 100%);
      color: #ffffff;
    }

    .badge-delivered {
      background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
      color: #ffffff;
    }

    .badge-cancelled {
      background: linear-gradient(135deg, #ff6b6b 0%, #fa5252 100%);
      color: #ffffff;
    }

    .badge-paid {
      background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
      color: #ffffff;
    }

    .badge-failed {
      background: linear-gradient(135deg, #ff6b6b 0%, #fa5252 100%);
      color: #ffffff;
    }

    .btn-view {
      background: linear-gradient(135deg, #4a3a22 0%, #634e2e 100%);
      color: #ffffff;
      padding: 10px 20px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: none;
      cursor: pointer;
    }

    .btn-view:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(74, 58, 34, 0.3);
      color: #ffffff;
      text-decoration: none;
    }

    .empty-state {
      text-align: center;
      padding: 60px 30px;
    }

    .empty-state-icon {
      font-size: 64px;
      color: #cbd5e0;
      margin-bottom: 20px;
    }

    .empty-state h4 {
      font-size: 1.5rem;
      font-weight: 700;
      color: #1a202c;
      margin-bottom: 12px;
    }

    .empty-state p {
      font-size: 1rem;
      color: #64748b;
      margin-bottom: 30px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      color: #ffffff;
      padding: 14px 32px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(74, 58, 34, 0.2);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(74, 58, 34, 0.3);
      color: #ffffff;
      text-decoration: none;
    }

    .btn-secondary {
      background: linear-gradient(135deg, #8e6f41 0%, #967645 100%);
      color: #ffffff;
      padding: 14px 32px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(142, 111, 65, 0.2);
    }

    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(142, 111, 65, 0.3);
      color: #ffffff;
      text-decoration: none;
    }

    .action-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
      margin-top: 40px;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Table responsive wrapper */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border-radius: 12px;
    }

    .table-responsive table {
      min-width: 800px;
    }

    @media (max-width: 768px) {
      .dashboard-header h2 {
        font-size: 2rem;
      }

      .dashboard-header .welcome-text {
        font-size: 1rem;
      }

      .stats-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }

      .stat-card {
        padding: 25px 20px;
      }

      .stat-value {
        font-size: 1.8rem;
      }

      .orders-section {
        padding: 25px 20px;
        border-radius: 16px;
      }

      .orders-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .orders-header h3 {
        font-size: 1.5rem;
      }

      .table-responsive {
        margin: 0 -20px;
        padding: 0 20px;
      }

      .table-responsive table {
        min-width: 600px;
      }

      .orders-table {
        font-size: 14px;
      }

      .orders-table thead {
        display: none;
      }

      .orders-table tbody tr {
        display: block;
        margin-bottom: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 15px;
        background: #ffffff;
      }

      .orders-table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
      }

      .orders-table tbody td:last-child {
        border-bottom: none;
      }

      .orders-table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #4a3a22;
        margin-right: 10px;
      }

      .action-buttons {
        flex-direction: column;
      }

      .action-buttons a {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="{{ route('home') }}">
          <span>
            Jkt.SweetDessert
          </span>
        </a>
        <div class="" id="">
          <div class="User_option">
            <a href="{{ route('products.index') }}">
              <i class="fa fa-th" aria-hidden="true"></i>
              <span>Products</span>
            </a>
            @auth
              <div class="user-dropdown">
                <button class="user-dropdown-toggle" type="button" id="userDropdown" aria-expanded="false" style="pointer-events: auto !important; cursor: pointer !important;">
                  <i class="fa fa-user-circle" aria-hidden="true"></i>
                  <span>{{ auth()->user()->name }}</span>
                  <i class="fa fa-chevron-down" aria-hidden="true"></i>
                </button>
                <div class="user-dropdown-menu" id="userDropdownMenu">
                  <a href="@if(auth()->user()->role == 'super_admin'){{ route('admin.dashboard') }}@elseif(auth()->user()->role == 'karyawan'){{ route('karyawan.dashboard') }}@else{{ route('user.dashboard') }}@endif" class="dropdown-item">
                    <i class="fa fa-dashboard" aria-hidden="true"></i>
                    <span>Dashboard</span>
                  </a>
                  <a href="{{ route('user.profile') }}" class="dropdown-item">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <span>Settings</span>
                  </a>
                  <a href="{{ route('cart.index') }}" class="dropdown-item" style="position: relative;">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <span>Cart</span>
                    @php
                      $cartCount = count(session('cart', []));
                    @endphp
                    @if($cartCount > 0)
                      <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                  </a>
                  @if(auth()->user()->role == 'user')
                    <a href="{{ route('orders.history') }}" class="dropdown-item">
                      <i class="fa fa-history" aria-hidden="true"></i>
                      <span>Riwayat</span>
                    </a>
                  @endif
                  <div class="dropdown-divider"></div>
                  <form action="{{ route('logout') }}" method="POST" class="dropdown-item-form">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn">
                      <i class="fa fa-sign-out" aria-hidden="true"></i>
                      <span>Logout</span>
                    </button>
                  </form>
                </div>
              </div>
            @else
              <a href="{{ route('login') }}">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Login</span>
              </a>
            @endauth
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="hero_area">
    <section class="recipe_section layout_padding-top dashboard-container" style="margin-top: 120px; padding-top: 40px;">
      <div class="container">
        <div class="dashboard-header">
          <h2>My Dashboard</h2>
          <p class="welcome-text">Welcome back, <strong>{{ $user->name }}</strong>! 👋</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            </div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <div class="stat-label">Total Orders</div>
            <p class="stat-description">Your order history</p>
          </div>

          <div class="stat-card">
            <div class="stat-icon">
              <i class="fa fa-money" aria-hidden="true"></i>
            </div>
            <div class="stat-value">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
            <div class="stat-label">Total Spent</div>
            <p class="stat-description">Your total spending</p>
          </div>

          <div class="stat-card">
            <div class="stat-icon">
              <i class="fa fa-user-circle" aria-hidden="true"></i>
            </div>
            <div class="stat-value">{{ $user->name }}</div>
            <div class="stat-label">Welcome Back!</div>
            <p class="stat-description">Continue shopping</p>
          </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="orders-section">
          <div class="orders-header">
            <h3>Recent Orders</h3>
            <a href="{{ route('orders.history') }}" class="btn-secondary">
              <i class="fa fa-history" aria-hidden="true"></i>
              View All History
            </a>
          </div>

          @if($orders->count() > 0)
            <div class="table-responsive">
              <table class="orders-table">
                <thead>
                  <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($orders as $order)
                    <tr>
                      <td data-label="Order Number"><strong>{{ $order->order_number }}</strong></td>
                      <td data-label="Date">{{ $order->created_at->format('d M Y H:i') }}</td>
                      <td data-label="Total">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                      <td data-label="Status">
                        @if($order->status == 'pending')
                          <span class="badge badge-pending">Pending</span>
                        @elseif($order->status == 'processing')
                          <span class="badge badge-processing">Processing</span>
                        @elseif($order->status == 'shipped')
                          <span class="badge badge-shipped">Shipped</span>
                        @elseif($order->status == 'delivered')
                          <span class="badge badge-delivered">Delivered</span>
                        @else
                          <span class="badge badge-cancelled">Cancelled</span>
                        @endif
                      </td>
                      <td data-label="Payment">
                        @if($order->payment_status == 'paid')
                          <span class="badge badge-paid">Paid</span>
                        @elseif($order->payment_status == 'pending')
                          <span class="badge badge-pending">Pending</span>
                        @else
                          <span class="badge badge-failed">Failed</span>
                        @endif
                      </td>
                      <td data-label="Actions">
                        <a href="{{ route('orders.show', $order->order_number) }}" class="btn-view">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                          View
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="empty-state">
              <div class="empty-state-icon">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              </div>
              <h4>No Orders Yet</h4>
              <p>You haven't placed any orders yet. Start shopping now!</p>
              <a href="{{ route('products.index') }}" class="btn-primary">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                Browse Products
              </a>
            </div>
          @endif

          <div class="action-buttons">
            <a href="{{ route('orders.history') }}" class="btn-secondary">
              <i class="fa fa-history" aria-hidden="true"></i>
              View All Transactions
            </a>
            <a href="{{ route('products.index') }}" class="btn-primary">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
              Continue Shopping
            </a>
          </div>
        </div>
      </div>
    </section>
  </div>

  @include('partial.footer')

  <!-- Ensure dropdown works on dashboard page -->
  <script>
    (function() {
      'use strict';
      
      var dropdownInitialized = false;
      
      function initDropdown() {
        if (dropdownInitialized) return true;
        
        var dropdown = document.querySelector('.user-dropdown');
        var toggle = document.getElementById('userDropdown');
        
        if (!dropdown || !toggle) {
          return false;
        }
        
        dropdownInitialized = true;
        
        // Add click handler
        toggle.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          e.stopImmediatePropagation();
          
          var isActive = dropdown.classList.contains('active');
          
          if (isActive) {
            dropdown.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
          } else {
            dropdown.classList.add('active');
            toggle.setAttribute('aria-expanded', 'true');
          }
          
          return false;
        });
        
        // Close on outside click
        document.addEventListener('click', function(e) {
          if (!dropdown || !toggle) return;
          
          if (dropdown.contains(e.target)) {
            return;
          }
          
          if (dropdown.classList.contains('active')) {
            dropdown.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
          }
        });
        
        return true;
      }
      
      // Try multiple times to ensure it works
      function tryInit() {
        if (!initDropdown()) {
          setTimeout(tryInit, 100);
        }
      }
      
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
          tryInit();
          setTimeout(tryInit, 200);
          setTimeout(tryInit, 500);
        });
      } else {
        tryInit();
        setTimeout(tryInit, 200);
        setTimeout(tryInit, 500);
      }
      
      window.addEventListener('load', function() {
        setTimeout(tryInit, 100);
      });
    })();
  </script>

</body>
</html>

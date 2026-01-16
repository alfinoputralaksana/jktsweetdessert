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

  <title>Jkt.SweetDessert - Riwayat Transaksi</title>

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

  <!-- User Dropdown Script -->
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

    .hero_area {
      background-image: none !important;
      background: #f8f9fa;
      min-height: 100vh;
    }

    .history-container {
      padding: 40px 0;
      margin-top: 120px;
    }

    .page-header {
      text-align: center;
      margin-bottom: 50px;
      padding: 30px 0;
    }

    .page-header h2 {
      font-size: 2.5rem;
      font-weight: 800;
      color: #4a3a22;
      margin-bottom: 10px;
      letter-spacing: -0.5px;
    }

    .page-header p {
      font-size: 1.1rem;
      color: #64748b;
      margin: 0;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-bottom: 40px;
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

    .stat-card:nth-child(1) .stat-icon {
      background: linear-gradient(135deg, rgba(255, 107, 107, 0.15) 0%, rgba(255, 107, 107, 0.05) 100%);
      color: #ff6b6b;
    }

    .stat-card:nth-child(2) .stat-icon {
      background: linear-gradient(135deg, rgba(81, 207, 102, 0.15) 0%, rgba(81, 207, 102, 0.05) 100%);
      color: #51cf66;
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

    .stat-value {
      font-size: 2.2rem;
      font-weight: 800;
      color: #1a202c;
      margin-bottom: 8px;
      line-height: 1.2;
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

    .filter-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08),
                  0 1px 3px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(74, 58, 34, 0.1);
      margin-bottom: 30px;
    }

    .filter-card h4 {
      font-size: 1.25rem;
      font-weight: 700;
      color: #4a3a22;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .filter-card h4 i {
      color: #4a3a22;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: 600;
      color: #4a3a22;
      margin-bottom: 8px;
      display: block;
      font-size: 14px;
    }

    .form-control {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
      background: #ffffff;
    }

    .form-control:focus {
      outline: none;
      border-color: #4a3a22;
      box-shadow: 0 0 0 3px rgba(74, 58, 34, 0.1);
    }

    .btn-filter {
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      color: #ffffff;
      padding: 12px 24px;
      border-radius: 10px;
      border: none;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 15px rgba(74, 58, 34, 0.2);
      width: 100%;
      justify-content: center;
    }

    .btn-filter:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(74, 58, 34, 0.3);
    }

    .orders-section {
      background: #ffffff;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08),
                  0 1px 3px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(74, 58, 34, 0.1);
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
      background: #ffffff;
      border-radius: 20px;
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
      background: #ffffff;
      color: #4a3a22;
      padding: 14px 32px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      border: 1.5px solid #4a3a22;
      cursor: pointer;
    }

    .btn-secondary:hover {
      background: #f8f9fa;
      color: #4a3a22;
    }

    .action-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
      margin-top: 40px;
    }

    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border-radius: 12px;
    }

    .table-responsive table {
      min-width: 800px;
    }

    /* Pagination Styling */
    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      margin: 40px 0;
      padding: 0;
      list-style: none;
      flex-wrap: wrap;
    }

    .pagination .page-item {
      margin: 0;
    }

    .pagination .page-link {
      border-radius: 10px;
      padding: 10px 16px;
      border: 1.5px solid #e2e8f0;
      color: #4a5568;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.3s ease;
      background: #ffffff;
      min-width: 42px;
      text-align: center;
      text-decoration: none;
      display: block;
      line-height: 1.5;
    }

    /* Fix icon size in pagination */
    .pagination .page-link i,
    .pagination .page-link .fa,
    .pagination .page-link [class*="fa-"] {
      font-size: 12px !important;
      width: auto !important;
      height: auto !important;
      max-width: 12px !important;
      max-height: 12px !important;
      line-height: 1 !important;
      display: inline-block !important;
    }

    .pagination .page-link span {
      font-size: 14px;
    }

    .pagination .page-link:hover {
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      border-color: transparent;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(74, 58, 34, 0.3);
    }

    .pagination .page-item.active .page-link {
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      border-color: transparent;
      color: #ffffff;
      box-shadow: 0 4px 15px rgba(74, 58, 34, 0.4);
    }

    .pagination .page-item.disabled .page-link {
      color: #cbd5e0;
      background: #f7fafc;
      border-color: #e2e8f0;
      cursor: not-allowed;
      pointer-events: none;
    }

    .pagination .page-item.disabled .page-link:hover {
      transform: none;
      box-shadow: none;
    }

    /* Hide any unwanted elements */
    .pagination .page-link:empty,
    .pagination .page-item:has(.page-link:empty:not(.disabled)) {
      display: none;
    }

    /* Pagination info text */
    .pagination-info {
      text-align: center;
      color: #64748b;
      font-size: 14px;
      margin: 20px 0;
    }

    .pagination-wrapper {
      margin: 40px 0;
      padding: 20px 0;
    }

    /* Hide unwanted pagination elements */
    .pagination .page-link:not([href]):not([tabindex]) {
      display: none;
    }

    /* Fix for Laravel pagination */
    .pagination li {
      list-style: none;
    }

    /* Remove any large icons or unwanted elements */
    .pagination .fa,
    .pagination i[class*="chevron"] {
      font-size: 14px !important;
    }

    /* Ensure no large elements appear */
    .pagination-wrapper * {
      max-width: 100%;
    }

    /* Clean up any stray elements */
    .orders-section > *:not(.table-responsive):not(.pagination-wrapper):not(.empty-state):not(.action-buttons) {
      margin-bottom: 20px;
    }

    /* Hide any large unwanted icons or elements */
    .pagination-wrapper i[class*="chevron-left"],
    .pagination-wrapper i[class*="chevron-right"],
    .pagination-wrapper .fa-chevron-left,
    .pagination-wrapper .fa-chevron-right {
      font-size: 14px !important;
      width: auto !important;
      height: auto !important;
    }

    /* Ensure pagination doesn't have huge elements */
    .pagination * {
      max-height: 40px !important;
      font-size: 14px !important;
    }

    .pagination .page-link {
      max-height: 40px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
    }

    /* Remove any background images or large decorative elements */
    .pagination-wrapper::before,
    .pagination-wrapper::after {
      display: none !important;
    }

    /* Fix spacing */
    .orders-section {
      position: relative;
    }

    .orders-section .table-responsive {
      margin-bottom: 30px;
    }

    /* Remove any large decorative elements */
    body > *:not(header):not(.hero_area):not(script) {
      max-width: 100%;
      overflow-x: hidden;
    }

    /* Ensure no large icons appear */
    .fa-chevron-left,
    .fa-chevron-right,
    i.fa-chevron-left,
    i.fa-chevron-right,
    .pagination .fa-chevron-left,
    .pagination .fa-chevron-right,
    .pagination i.fa-chevron-left,
    .pagination i.fa-chevron-right {
      font-size: 12px !important;
      width: auto !important;
      height: auto !important;
      max-width: 12px !important;
      max-height: 12px !important;
      line-height: 1 !important;
    }

    /* Clean pagination completely */
    .pagination-wrapper ul {
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .pagination-wrapper ul li {
      display: inline-block;
      margin: 0 4px;
    }

    @media (max-width: 768px) {
      .history-container {
        margin-top: 100px;
        padding: 20px 0;
      }

      .page-header h2 {
        font-size: 2rem;
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

      .filter-card {
        padding: 20px;
        border-radius: 16px;
      }

      .orders-section {
        padding: 25px 20px;
        border-radius: 16px;
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
                  @if(auth()->user()->role == 'user')
                    <a href="{{ route('user.profile') }}" class="dropdown-item">
                      <i class="fa fa-cog" aria-hidden="true"></i>
                      <span>Settings</span>
                    </a>
                  @endif
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
    <section class="recipe_section layout_padding-top history-container">
      <div class="container">
        <div class="page-header">
          <h2>Riwayat Transaksi</h2>
          <p>Semua pesanan Anda</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            </div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <div class="stat-label">Total Pesanan</div>
            <p class="stat-description">Semua pesanan Anda</p>
          </div>

          <div class="stat-card">
            <div class="stat-icon">
              <i class="fa fa-money" aria-hidden="true"></i>
            </div>
            <div class="stat-value">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pengeluaran</div>
            <p class="stat-description">Total yang sudah dibayar</p>
          </div>
        </div>

        <!-- Filter Form -->
        <div class="filter-card">
          <h4>
            <i class="fa fa-filter" aria-hidden="true"></i>
            Filter Pencarian
          </h4>
          <form method="GET" action="{{ route('orders.history') }}">
            <div class="row">
              <div class="col-md-3 mb-3">
                <div class="form-group">
                  <label>Pencarian</label>
                  <input type="text" name="search" class="form-control" placeholder="No. Pesanan..." value="{{ request('search') }}">
                </div>
              </div>
              <div class="col-md-2 mb-3">
                <div class="form-group">
                  <label>Status Pesanan</label>
                  <select name="status" class="form-control">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Di Antar</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 mb-3">
                <div class="form-group">
                  <label>Status Pembayaran</label>
                  <select name="payment_status" class="form-control">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 mb-3">
                <div class="form-group">
                  <label>Dari Tanggal</label>
                  <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
              </div>
              <div class="col-md-2 mb-3">
                <div class="form-group">
                  <label>Sampai Tanggal</label>
                  <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
              </div>
              <div class="col-md-1 mb-3">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <button type="submit" class="btn-filter">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <span class="d-none d-md-inline">Filter</span>
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>

        <!-- Orders List -->
        <div class="orders-section">
          @if($orders->count() > 0)
            <div class="table-responsive">
              <table class="orders-table">
                <thead>
                  <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($orders as $order)
                    <tr>
                      <td data-label="No. Pesanan"><strong>{{ $order->order_number }}</strong></td>
                      <td data-label="Tanggal">{{ $order->created_at->format('d M Y H:i') }}</td>
                      <td data-label="Total">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                      <td data-label="Status">
                        @if($order->status == 'pending')
                          <span class="badge badge-pending">Pending</span>
                        @elseif($order->status == 'processing')
                          <span class="badge badge-processing">Processing</span>
                        @elseif($order->status == 'shipped')
                          <span class="badge badge-shipped">Di Antar</span>
                        @elseif($order->status == 'delivered')
                          <span class="badge badge-delivered">Delivered</span>
                        @else
                          <span class="badge badge-cancelled">Cancelled</span>
                        @endif
                      </td>
                      <td data-label="Pembayaran">
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
                          <span class="d-none d-sm-inline">Detail</span>
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
              <h4>Belum Ada Transaksi</h4>
              <p>Anda belum memiliki riwayat transaksi. Mulai berbelanja sekarang!</p>
              <a href="{{ route('products.index') }}" class="btn-primary">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                Belanja Sekarang
              </a>
            </div>
          @endif

          <div class="action-buttons">
            <a href="{{ route('user.dashboard') }}" class="btn-secondary">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>
              Kembali ke Dashboard
            </a>
            <a href="{{ route('products.index') }}" class="btn-primary">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              Lanjutkan Belanja
            </a>
          </div>
        </div>
      </div>
    </section>
  </div>

  @include('partial.footer')

  <script>
    // Ensure dropdown works on this page
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
        
        // Remove any existing listeners by cloning
        var newToggle = toggle.cloneNode(true);
        toggle.parentNode.replaceChild(newToggle, toggle);
        toggle = newToggle;
        
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
        }, true);
        
        document.addEventListener('click', function(e) {
          if (!dropdown || !toggle) return;
          
          if (dropdown.contains(e.target)) {
            return;
          }
          
          if (dropdown.classList.contains('active')) {
            dropdown.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
          }
        }, true);
        
        return true;
      }
      
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

    // Clean up any unwanted large elements
    document.addEventListener('DOMContentLoaded', function() {
      // Remove any large chevron icons that might appear
      var largeIcons = document.querySelectorAll('i.fa-chevron-left, i.fa-chevron-right');
      largeIcons.forEach(function(icon) {
        if (icon.offsetWidth > 50 || icon.offsetHeight > 50) {
          icon.style.fontSize = '14px';
          icon.style.width = 'auto';
          icon.style.height = 'auto';
        }
      });

      // Ensure pagination is clean
      var pagination = document.querySelector('.pagination');
      if (pagination) {
        var allElements = pagination.querySelectorAll('*');
        allElements.forEach(function(el) {
          if (el.offsetWidth > 100 || el.offsetHeight > 100) {
            el.style.maxWidth = '50px';
            el.style.maxHeight = '50px';
            el.style.fontSize = '14px';
          }
        });
      }
    });
  </script>
</body>
</html>

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

  <title>Jkt.SweetDessert</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/bootstrap.css')); ?>" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

  <!-- font awesome style -->
  <link href="<?php echo e(asset('assets/css/font-awesome.min.css')); ?>" rel="stylesheet" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- slidck slider -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css.map" integrity="undefined" crossorigin="anonymous" />


  <!-- Custom styles for this template -->
  <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet" />
  <!-- responsive style -->
  <link href="<?php echo e(asset('assets/css/responsive.css')); ?>" rel="stylesheet" />
  <!-- custom responsive style -->
  <link href="<?php echo e(asset('assets/css/custom-responsive.css')); ?>" rel="stylesheet" />
  <!-- modern navbar style -->
  <link href="<?php echo e(asset('assets/css/modern-navbar.css')); ?>" rel="stylesheet" />
  
  <?php echo $__env->yieldPushContent('styles'); ?>

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

</head>


<header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
            <span>
              Jkt.SweetDessert
            </span>
          </a>
          <div class="" id="">
            <div class="User_option">
              <a href="<?php echo e(route('products.index')); ?>">
                <i class="fa fa-th" aria-hidden="true"></i>
                <span>Products</span>
              </a>
              <?php if(auth()->guard()->check()): ?>
                <div class="user-dropdown">
                  <button class="user-dropdown-toggle" type="button" id="userDropdown" aria-expanded="false" style="pointer-events: auto !important; cursor: pointer !important;">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <span><?php echo e(auth()->user()->name); ?></span>
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                  </button>
                  <div class="user-dropdown-menu" id="userDropdownMenu">
                    <a href="<?php if(auth()->user()->role == 'super_admin'): ?><?php echo e(route('admin.dashboard')); ?><?php elseif(auth()->user()->role == 'karyawan'): ?><?php echo e(route('karyawan.dashboard')); ?><?php else: ?><?php echo e(route('user.dashboard')); ?><?php endif; ?>" class="dropdown-item">
                      <i class="fa fa-dashboard" aria-hidden="true"></i>
                      <span>Dashboard</span>
                    </a>
                    <?php if(auth()->user()->role == 'user'): ?>
                      <a href="<?php echo e(route('user.profile')); ?>" class="dropdown-item">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <span>Settings</span>
                      </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('cart.index')); ?>" class="dropdown-item" style="position: relative;">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                      <span>Cart</span>
                      <?php
                        $cartCount = count(session('cart', []));
                      ?>
                      <?php if($cartCount > 0): ?>
                        <span class="cart-badge"><?php echo e($cartCount); ?></span>
                      <?php endif; ?>
                    </a>
                    <?php if(auth()->user()->role == 'user'): ?>
                      <a href="<?php echo e(route('orders.history')); ?>" class="dropdown-item">
                        <i class="fa fa-history" aria-hidden="true"></i>
                        <span>Riwayat</span>
                      </a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="dropdown-item-form">
                      <?php echo csrf_field(); ?>
                      <button type="submit" class="dropdown-item logout-btn">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        <span>Logout</span>
                      </button>
                    </form>
                  </div>
                </div>
              <?php else: ?>
                <a href="<?php echo e(route('login')); ?>">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <span>Login</span>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </nav>
      </div>
    </header><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/jktsweetdessert/resources/views/partial/header.blade.php ENDPATH**/ ?>
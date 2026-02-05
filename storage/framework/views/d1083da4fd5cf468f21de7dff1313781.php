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

  <title>Jkt.SweetDessert - Profile Settings</title>

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

    .profile-container {
      padding: 40px 0;
      margin-top: 120px;
    }

    .profile-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08),
                  0 1px 3px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(74, 58, 34, 0.1);
      margin-bottom: 30px;
    }

    .profile-header {
      text-align: center;
      margin-bottom: 40px;
      padding-bottom: 30px;
      border-bottom: 2px solid #f0f0f0;
    }

    .profile-header h2 {
      font-size: 2rem;
      font-weight: 700;
      color: #4a3a22;
      margin-bottom: 10px;
    }

    .profile-header p {
      color: #64748b;
      font-size: 1rem;
      margin: 0;
    }

    .profile-icon {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 48px;
      color: #ffffff;
      box-shadow: 0 4px 15px rgba(74, 58, 34, 0.3);
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-group label {
      font-weight: 600;
      color: #4a3a22;
      margin-bottom: 8px;
      display: block;
      font-size: 14px;
    }

    .form-group label .required {
      color: #e53e3e;
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

    .form-control.is-invalid {
      border-color: #e53e3e;
    }

    .invalid-feedback {
      display: block;
      color: #e53e3e;
      font-size: 13px;
      margin-top: 5px;
    }

    .form-text {
      font-size: 13px;
      color: #64748b;
      margin-top: 5px;
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

    .alert {
      padding: 16px 20px;
      border-radius: 12px;
      margin-bottom: 25px;
      border: none;
      font-size: 14px;
    }

    .alert-success {
      background: #d1fae5;
      color: #065f46;
    }

    .alert-danger {
      background: #fee2e2;
      color: #991b1b;
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #4a3a22;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #f0f0f0;
    }

    .password-toggle {
      position: relative;
    }

    .password-toggle-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #64748b;
      cursor: pointer;
      font-size: 18px;
      padding: 5px;
      transition: color 0.3s ease;
    }

    .password-toggle-btn:hover {
      color: #4a3a22;
    }

    @media (max-width: 768px) {
      .profile-container {
        margin-top: 100px;
        padding: 20px 0;
      }

      .profile-card {
        padding: 25px 20px;
        border-radius: 16px;
      }

      .profile-header h2 {
        font-size: 1.5rem;
      }

      .profile-icon {
        width: 80px;
        height: 80px;
        font-size: 36px;
      }
    }
  </style>
</head>
<body>
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
                  <a href="<?php echo e(route('user.profile')); ?>" class="dropdown-item">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <span>Settings</span>
                  </a>
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
  </header>
  <div class="hero_area">
    <section class="recipe_section layout_padding-top profile-container">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="profile-card">
              <div class="profile-header">
                <div class="profile-icon">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <h2>Pengaturan Profile</h2>
                <p>Kelola informasi akun dan keamanan Anda</p>
              </div>

              <?php if(session('success')): ?>
                <div class="alert alert-success">
                  <i class="fa fa-check-circle" aria-hidden="true"></i>
                  <?php echo e(session('success')); ?>

                </div>
              <?php endif; ?>

              <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                  <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                  <strong>Terjadi kesalahan:</strong>
                  <ul class="mb-0 mt-2" style="padding-left: 20px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </div>
              <?php endif; ?>

              <form action="<?php echo e(route('user.profile.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="section-title">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  Informasi Akun
                </div>

                <div class="form-group">
                  <label for="name">
                    Nama Lengkap <span class="required">*</span>
                  </label>
                  <input 
                    type="text" 
                    class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                    id="name" 
                    name="name" 
                    value="<?php echo e(old('name', $user->name)); ?>" 
                    required
                    placeholder="Masukkan nama lengkap"
                  >
                  <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($message); ?></strong>
                    </span>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    value="<?php echo e($user->email); ?>" 
                    disabled
                    style="background: #f8f9fa; cursor: not-allowed;"
                  >
                  <small class="form-text">Email tidak dapat diubah</small>
                </div>

                <div class="section-title" style="margin-top: 40px;">
                  <i class="fa fa-lock" aria-hidden="true"></i>
                  Ubah Password
                </div>

                <div class="form-group">
                  <label for="current_password">
                    Password Lama
                  </label>
                  <div class="password-toggle">
                    <input 
                      type="password" 
                      class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                      id="current_password" 
                      name="current_password" 
                      placeholder="Masukkan password lama"
                    >
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('current_password')">
                      <i class="fa fa-eye" id="current_password_icon"></i>
                    </button>
                  </div>
                  <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($message); ?></strong>
                    </span>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  <small class="form-text">Wajib diisi jika ingin mengubah password</small>
                </div>

                <div class="form-group">
                  <label for="password">
                    Password Baru
                  </label>
                  <div class="password-toggle">
                    <input 
                      type="password" 
                      class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                      id="password" 
                      name="password" 
                      placeholder="Masukkan password baru"
                    >
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                      <i class="fa fa-eye" id="password_icon"></i>
                    </button>
                  </div>
                  <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($message); ?></strong>
                    </span>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  <small class="form-text">Minimal 8 karakter</small>
                </div>

                <div class="form-group">
                  <label for="password_confirmation">
                    Konfirmasi Password Baru
                  </label>
                  <div class="password-toggle">
                    <input 
                      type="password" 
                      class="form-control" 
                      id="password_confirmation" 
                      name="password_confirmation" 
                      placeholder="Konfirmasi password baru"
                    >
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation')">
                      <i class="fa fa-eye" id="password_confirmation_icon"></i>
                    </button>
                  </div>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 40px; flex-wrap: wrap;">
                  <button type="submit" class="btn-primary">
                    <i class="fa fa-save" aria-hidden="true"></i>
                    Simpan Perubahan
                  </button>
                  <a href="<?php echo e(route('user.dashboard')); ?>" class="btn-secondary">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    Kembali
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php echo $__env->make('partial.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <script>
    function togglePassword(inputId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(inputId + '_icon');
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>

<?php /**PATH C:\laragon\www\jktsweetdessert\resources\views/user/profile.blade.php ENDPATH**/ ?>
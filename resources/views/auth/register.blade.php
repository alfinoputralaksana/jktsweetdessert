<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5.0, user-scalable=yes">
  <title>Register - JKT Sweet Dessert</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZm9vZFBhdHRlcm4iIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZjBmMGYwIiBzdHJva2Utd2lkdGg9IjAuNSIgb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0idXJsKCNmb29kUGF0dGVybikiLz48L3N2Zz4=');
      background-size: 200px 200px;
      background-repeat: repeat;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      padding-top: 0;
      padding-bottom: 0;
      width: 100%;
      box-sizing: border-box;
    }

    html {
      height: 100%;
      width: 100%;
      overflow-x: hidden;
      box-sizing: border-box;
    }

    *, *::before, *::after {
      box-sizing: inherit;
    }

    .hero_area {
      position: relative;
      z-index: 1000;
      flex-shrink: 0;
    }

    .header_section {
      position: fixed !important;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1001 !important;
      background: rgba(255, 255, 255, 0.98) !important;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.15) !important;
      padding: 15px 0 !important;
      width: 100%;
      box-sizing: border-box;
    }

    @media (max-width: 768px) {
      .header_section {
        padding: 12px 0 !important;
      }
    }

    @media (max-width: 576px) {
      .header_section {
        padding: 10px 0 !important;
      }
    }

    .header_section .navbar-brand span {
      color: #4a3a22 !important;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%) !important;
      -webkit-background-clip: text !important;
      -webkit-text-fill-color: transparent !important;
      background-clip: text !important;
    }

    .header_section .User_option a,
    .header_section .User_option button {
      color: #333 !important;
    }

    .header_section .User_option a:hover,
    .header_section .User_option button:hover {
      color: #4a3a22 !important;
    }

    .register-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 1 0 auto;
      padding: 40px 20px;
      position: relative;
      margin-top: 100px;
      margin-bottom: 40px;
      min-height: calc(100vh - 200px);
      width: 100%;
      box-sizing: border-box;
    }

    .register-wrapper::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      top: -250px;
      right: -250px;
      animation: float 20s infinite;
    }

    .register-wrapper::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      bottom: -200px;
      left: -200px;
      animation: float 15s infinite reverse;
    }

    @keyframes float {
      0%, 100% { transform: translate(0, 0) rotate(0deg); }
      50% { transform: translate(30px, -30px) rotate(180deg); }
    }

    .register-container {
      width: 100%;
      max-width: 500px;
      z-index: 1;
      animation: slideUp 0.5s ease-out;
      position: relative;
      margin: 0 auto;
      box-sizing: border-box;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .register-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.2);
      max-height: 90vh;
      overflow-y: auto;
      width: 100%;
      box-sizing: border-box;
      overflow-x: hidden;
    }

    .register-card::-webkit-scrollbar {
      width: 6px;
    }

    .register-card::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .register-card::-webkit-scrollbar-thumb {
      background: #4a3a22;
      border-radius: 10px;
    }

    .logo-section {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo-section h1 {
      font-size: 32px;
      font-weight: 700;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 10px;
    }

    .logo-section p {
      color: #666;
      font-size: 14px;
    }

    .alert {
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 14px;
      animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-danger {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .alert-danger ul {
      margin: 0;
      padding-left: 20px;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
      z-index: 1;
      font-size: 14px;
      width: 18px;
      display: inline-block;
      pointer-events: none;
      text-align: center;
    }

    .form-control {
      width: 100%;
      padding: 15px 15px 15px 50px;
      border: 2px solid #e0e0e0;
      border-radius: 12px;
      font-size: 15px;
      transition: all 0.3s ease;
      background: #f8f9fa;
      font-family: 'Poppins', sans-serif;
      text-indent: 0;
    }

    /* Field dengan icon di kanan (password) */
    .input-wrapper.password-field .form-control {
      padding-right: 50px;
    }

    /* Pastikan teks tidak overlap dengan icon */
    .input-wrapper .form-control {
      padding-left: 55px !important;
    }

    .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #999;
      cursor: pointer;
      z-index: 3;
      padding: 5px 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.3s ease;
      width: 35px;
      height: 35px;
    }

    .password-toggle i {
      font-size: 16px;
      display: inline-block;
    }

    .password-toggle:hover {
      color: #4a3a22;
    }

    .password-toggle:focus {
      outline: none;
    }

    /* Ensure Font Awesome icons are displayed */
    .fas, .fa {
      font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "FontAwesome";
      font-weight: 900;
      display: inline-block;
      font-style: normal;
      font-variant: normal;
      text-rendering: auto;
      line-height: 1;
    }

    .form-control:focus {
      outline: none;
      border-color: #4a3a22;
      background: white;
      box-shadow: 0 0 0 4px rgba(74, 58, 34, 0.1);
    }

    .form-control.is-invalid {
      border-color: #dc3545;
    }

    .invalid-feedback {
      display: block;
      color: #dc3545;
      font-size: 12px;
      margin-top: 5px;
    }

    .terms-checkbox {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 25px;
      font-size: 14px;
    }

    .terms-checkbox input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
      accent-color: #4a3a22;
      margin-top: 3px;
      flex-shrink: 0;
    }

    .terms-checkbox label {
      color: #666;
      cursor: pointer;
      user-select: none;
      line-height: 1.5;
    }

    .terms-checkbox label a {
      color: #4a3a22;
      text-decoration: none;
    }

    .terms-checkbox label a:hover {
      text-decoration: underline;
    }

    .btn-register {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: 'Poppins', sans-serif;
      box-shadow: 0 4px 15px rgba(74, 58, 34, 0.4);
    }

    .btn-register:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(74, 58, 34, 0.6);
    }

    .btn-register:active {
      transform: translateY(0);
    }

    .divider {
      text-align: center;
      margin: 25px 0;
      position: relative;
      color: #999;
      font-size: 14px;
    }

    .divider::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      width: 45%;
      height: 1px;
      background: #e0e0e0;
    }

    .divider::after {
      content: '';
      position: absolute;
      right: 0;
      top: 50%;
      width: 45%;
      height: 1px;
      background: #e0e0e0;
    }

    .footer-links {
      text-align: center;
      margin-top: 25px;
    }

    .footer-links a {
      color: #4a3a22;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s ease;
    }

    .footer-links a:hover {
      color: #8e6f41;
      text-decoration: underline;
    }

    .back-home {
      text-align: center;
      margin-top: 15px;
    }

    .back-home a {
      color: #999;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s ease;
    }

    .back-home a:hover {
      color: #4a3a22;
    }

    /* Footer styling - using partial footer */
    .footer_container {
      position: relative;
      margin-top: 0;
      padding: 0 !important;
      background: none !important;
      background-image: none !important;
      width: 100%;
      z-index: 1;
      flex-shrink: 0;
    }

    /* Large Desktop */
    @media (min-width: 1400px) {
      .register-container {
        max-width: 550px;
      }
    }

    /* Tablet and Medium Devices */
    @media (max-width: 1024px) {
      .register-wrapper {
        padding: 35px 20px;
      }

      .register-wrapper::before {
        width: 300px;
        height: 300px;
        top: -150px;
        right: -150px;
      }

      .register-wrapper::after {
        width: 250px;
        height: 250px;
        bottom: -125px;
        left: -125px;
      }

      .register-container {
        max-width: 480px;
      }
    }

    @media (max-width: 991px) {
      .register-wrapper {
        margin-top: 90px;
        padding: 30px 20px;
        min-height: calc(100vh - 180px);
      }

      .register-container {
        max-width: 100%;
        padding: 0 10px;
      }

      .register-card {
        padding: 35px 30px;
        max-height: 88vh;
      }
    }

    @media (max-width: 768px) {
      .register-wrapper {
        margin-top: 75px;
        padding: 25px 15px;
        min-height: calc(100vh - 150px);
      }

      .register-container {
        max-width: 100%;
        padding: 0 5px;
      }

      .register-card {
        padding: 30px 25px;
        border-radius: 18px;
        max-height: 85vh;
      }

      .logo-section {
        margin-bottom: 25px;
      }

      .logo-section h1 {
        font-size: 28px;
      }

      .logo-section p {
        font-size: 13px;
      }

      .form-control {
        font-size: 16px; /* Prevents zoom on iOS */
        padding: 13px 13px 13px 47px;
      }

      .input-wrapper .form-control {
        padding-left: 49px !important;
      }

      .input-icon {
        left: 13px;
        font-size: 13px;
      }

      .btn-register {
        padding: 13px;
        font-size: 15px;
      }

      .terms-checkbox {
        font-size: 13px;
        gap: 8px;
      }
    }

    /* Mobile Devices */
    @media (max-width: 576px) {
      .register-wrapper {
        margin-top: 70px;
        padding: 20px 12px;
        min-height: calc(100vh - 140px);
      }

      .hero_area {
        padding-top: 0 !important;
      }

      .register-wrapper::before,
      .register-wrapper::after {
        display: none; /* Hide decorative circles on small screens */
      }

      .register-container {
        padding: 0;
      }

      .register-card {
        padding: 25px 20px;
        border-radius: 15px;
        max-height: 90vh;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      }

      .logo-section {
        margin-bottom: 22px;
      }

      .logo-section h1 {
        font-size: 24px;
        margin-bottom: 6px;
      }

      .logo-section p {
        font-size: 12px;
      }

      .form-group {
        margin-bottom: 16px;
      }

      .form-control {
        padding: 12px 12px 12px 44px;
        font-size: 16px; /* Prevents zoom on iOS */
        border-radius: 10px;
        border-width: 1.5px;
      }

      .input-wrapper .form-control {
        padding-left: 46px !important;
      }

      .input-wrapper.password-field .form-control {
        padding-right: 44px;
      }

      .input-icon {
        left: 12px;
        font-size: 12px;
        width: 16px;
      }

      .password-toggle {
        right: 10px;
        width: 30px;
        height: 30px;
        padding: 3px 5px;
      }

      .password-toggle i {
        font-size: 13px;
      }

      .terms-checkbox {
        margin-bottom: 18px;
        font-size: 11px;
        gap: 7px;
      }

      .terms-checkbox input[type="checkbox"] {
        width: 15px;
        height: 15px;
        margin-top: 2px;
      }

      .terms-checkbox label {
        line-height: 1.4;
        font-size: 11px;
      }

      .terms-checkbox label a {
        font-size: 11px;
      }

      .btn-register {
        padding: 12px;
        font-size: 15px;
        border-radius: 10px;
      }

      .divider {
        margin: 18px 0;
        font-size: 12px;
      }

      .divider::before,
      .divider::after {
        width: 42%;
      }

      .footer-links {
        margin-top: 18px;
      }

      .footer-links a,
      .back-home a {
        font-size: 12px;
      }

      .back-home {
        margin-top: 12px;
      }

      .alert {
        padding: 10px 12px;
        font-size: 12px;
        margin-bottom: 18px;
      }

      .alert-danger ul {
        padding-left: 16px;
        margin: 5px 0 0 0;
      }

      .alert-danger ul li {
        font-size: 11px;
        margin-bottom: 3px;
      }
    }

    @media (max-width: 480px) {
      .register-wrapper {
        margin-top: 65px;
        padding: 15px 10px;
        min-height: calc(100vh - 130px);
      }

      .hero_area {
        padding-top: 0 !important;
      }

      .register-card {
        padding: 22px 18px;
        border-radius: 12px;
        max-height: 92vh;
      }

      .logo-section h1 {
        font-size: 22px;
      }

      .logo-section p {
        font-size: 11px;
      }

      .form-control {
        padding: 11px 11px 11px 42px;
      }

      .input-wrapper .form-control {
        padding-left: 44px !important;
      }

      .input-icon {
        left: 11px;
        font-size: 11px;
      }

      .password-toggle {
        right: 9px;
        width: 28px;
        height: 28px;
      }

      .btn-register {
        padding: 11px;
        font-size: 14px;
      }

      .terms-checkbox {
        font-size: 10px;
      }

      .terms-checkbox label {
        font-size: 10px;
      }
    }

    /* Small Mobile Devices */
    @media (max-width: 360px) {
      .register-wrapper {
        padding: 12px 8px;
        margin-top: 60px;
        min-height: calc(100vh - 120px);
      }

      .hero_area {
        padding-top: 0 !important;
      }

      .register-card {
        padding: 20px 15px;
        border-radius: 10px;
        max-height: 95vh;
      }

      .logo-section h1 {
        font-size: 20px;
      }

      .logo-section p {
        font-size: 11px;
      }

      .form-control {
        padding: 10px 10px 10px 40px;
        font-size: 16px;
      }

      .input-wrapper .form-control {
        padding-left: 42px !important;
      }

      .input-icon {
        left: 10px;
        font-size: 11px;
        width: 14px;
      }

      .password-toggle {
        right: 8px;
        width: 26px;
        height: 26px;
      }

      .btn-register {
        padding: 10px;
        font-size: 13px;
      }

      .terms-checkbox {
        font-size: 10px;
        gap: 6px;
      }

      .terms-checkbox input[type="checkbox"] {
        width: 14px;
        height: 14px;
      }

      .terms-checkbox label {
        font-size: 10px;
      }

      .alert {
        padding: 8px 10px;
        font-size: 11px;
      }
    }

    /* Landscape Mobile */
    @media (max-width: 768px) and (orientation: landscape) {
      .register-wrapper {
        margin-top: 60px;
        padding: 15px 12px;
        min-height: auto;
        align-items: flex-start;
        padding-top: 20px;
      }

      .register-card {
        max-height: 85vh;
        overflow-y: auto;
        margin-top: 0;
      }

      .logo-section {
        margin-bottom: 15px;
      }

      .logo-section h1 {
        font-size: 22px;
      }

      .form-group {
        margin-bottom: 12px;
      }

      .terms-checkbox {
        margin-bottom: 15px;
      }
    }

    /* Extra Small Devices */
    @media (max-width: 320px) {
      .register-wrapper {
        padding: 10px 5px;
      }

      .register-card {
        padding: 18px 12px;
      }

      .logo-section h1 {
        font-size: 18px;
      }

      .form-control {
        padding: 9px 9px 9px 38px;
        font-size: 16px;
      }

      .input-wrapper .form-control {
        padding-left: 40px !important;
      }

      .terms-checkbox {
        font-size: 9px;
      }

      .terms-checkbox label {
        font-size: 9px;
      }
    }
  </style>
  
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}" />
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
  <!-- font awesome style -->
  <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
  <!-- Font Awesome CDN (backup) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom styles for this template -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
</head>
<body>
  <div class="hero_area">
    @include('partial.header')
  </div>

  <div class="register-wrapper">
    <div class="register-container">
      <div class="register-card">
        <div class="logo-section">
        <h1>JKT Sweet Dessert</h1>
        <p>Create your account</p>
      </div>

      @if($errors->any())
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle"></i>
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('register') }}" method="post">
        @csrf
        
        <div class="form-group">
          <div class="input-wrapper">
            <i class="fas fa-user input-icon"></i>
            <input 
              type="text" 
              name="name" 
              class="form-control @error('name') is-invalid @enderror" 
              placeholder="Full name" 
              value="{{ old('name') }}" 
              required 
              autofocus
            >
          </div>
          @error('name')
            <span class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <div class="input-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input 
              type="email" 
              name="email" 
              class="form-control @error('email') is-invalid @enderror" 
              placeholder="Email address" 
              value="{{ old('email') }}" 
              required
            >
          </div>
          @error('email')
            <span class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <div class="input-wrapper password-field">
            <i class="fas fa-lock input-icon"></i>
            <input 
              type="password" 
              name="password" 
              id="password"
              class="form-control @error('password') is-invalid @enderror" 
              placeholder="Password" 
              required
            >
            <button type="button" class="password-toggle" id="togglePassword">
              <i class="fas fa-eye" id="togglePasswordIcon"></i>
            </button>
          </div>
          @error('password')
            <span class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <div class="input-wrapper password-field">
            <i class="fas fa-lock input-icon"></i>
            <input 
              type="password" 
              name="password_confirmation" 
              id="password_confirmation"
              class="form-control" 
              placeholder="Confirm password" 
              required
            >
            <button type="button" class="password-toggle" id="togglePasswordConfirmation">
              <i class="fas fa-eye" id="togglePasswordConfirmationIcon"></i>
            </button>
          </div>
        </div>

        <div class="terms-checkbox">
          <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
          <label for="agreeTerms">
            I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
          </label>
        </div>

        <button type="submit" class="btn-register">
          <i class="fas fa-user-plus"></i> Create Account
        </button>
      </form>

      <div class="divider">or</div>

      <div class="footer-links">
        <a href="{{ route('login') }}">
          <i class="fas fa-sign-in-alt"></i> Already have an account? Sign in
        </a>
      </div>

      <div class="back-home">
        <a href="{{ route('home') }}">
          <i class="fas fa-arrow-left"></i> Back to Home
        </a>
      </div>
      </div>
    </div>
  </div>

  <br><br><br><br><br><br><br><br>

  @include('partial.footer')

  <!-- jQery -->
  <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
  <!-- bootstrap js -->
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <!-- custom js -->
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  
  <script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('togglePasswordIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    });

    // Toggle password confirmation visibility
    document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
      const passwordInput = document.getElementById('password_confirmation');
      const toggleIcon = document.getElementById('togglePasswordConfirmationIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    });
  </script>
</body>
</html>

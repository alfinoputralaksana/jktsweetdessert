<style>
  /* Enhanced Footer Styles */
  .footer_container {
    flex-shrink: 0;
    width: 100%;
  }

  .info_section {
    padding: 60px 0;
  }

  .info_section .footer-info,
  .info_section .footer-links,
  .info_section .footer-contact {
    margin-bottom: 30px;
  }

  .info_section h4 {
    color: #ffe537;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .info_section .footer-info p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    line-height: 1.8;
    margin: 0;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .info_section .footer-info p:last-child {
    margin-bottom: 0;
  }

  .info_section .footer-info {
    text-align: center;
  }

  .info_section .footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .info_section .footer-links ul li {
    margin-bottom: 12px;
  }

  .info_section .footer-links ul li a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-block;
  }

  .info_section .footer-links ul li a:hover {
    color: #ffe537;
    transform: translateX(5px);
  }

  .info_section .footer-links {
    text-align: center;
  }

  .info_section .footer-contact {
    text-align: center;
  }

  .info_section .footer-contact .contact_box {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 100%;
    margin: 0;
    align-items: center;
  }

  .info_section .footer-contact .contact_box a {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    margin: 0;
  }

  .info_section .footer-contact .contact_box a i {
    font-size: 18px;
    width: 24px;
    text-align: center;
    color: #ffe537;
  }

  .info_section .footer-contact .contact_box a:hover {
    color: #ffe537;
    transform: translateX(5px);
  }

  .info_section .footer-contact .contact_box a:hover i {
    color: #ffffff;
  }

  .footer_section {
    padding: 20px 0;
  }

  .footer_section p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    margin: 0;
  }

  .footer_section p strong {
    color: #ffe537;
  }

  @media (max-width: 768px) {
    .info_section {
      padding: 40px 0;
    }

    .info_section h4 {
      font-size: 18px;
      margin-bottom: 15px;
    }

    .info_section .footer-info,
    .info_section .footer-links,
    .info_section .footer-contact {
      margin-bottom: 30px;
      text-align: center;
    }

    .info_section .footer-contact .contact_box {
      align-items: center;
    }
  }
</style>

<div class="footer_container">
    <!-- info section -->
    <section class="info_section">
      <div class="container">
        <div class="row">
          <div class="col-md-4 footer-info">
            <h4>Operating Hours</h4>
            <p><i class="fa fa-clock-o" style="color: #ffe537;"></i> Open Order</p>
            <p><i class="fa fa-calendar" style="color: #ffe537;"></i> Setiap hari</p>
            <p><i class="fa fa-hourglass-end" style="color: #ffe537;"></i> 09.00 - 20.00 WIB</p>
          </div>
          <div class="col-md-4 footer-links">
            <h4>Quick Links</h4>
            <ul>
              <li><a href="{{ route('home') }}">Home</a></li>
              <li><a href="{{ route('products.index') }}">Products</a></li>
              @auth
                <li><a href="@if(auth()->user()->role == 'super_admin'){{ route('admin.dashboard') }}@elseif(auth()->user()->role == 'karyawan'){{ route('karyawan.dashboard') }}@else{{ route('user.dashboard') }}@endif">Dashboard</a></li>
              @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
              @endauth
            </ul>
          </div>
          <div class="col-md-4 footer-contact">
            <h4>Contact Us</h4>
            <div class="contact_box">
              <a href="https://maps.google.com" target="_blank" title="Location">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>Jakarta, Indonesia</span>
              </a>
              <a href="https://www.instagram.com/jkt.sweetdessert/" target="_blank" title="Instagram">
                <i class="fa fa-instagram" aria-hidden="true"></i>
                <span>Instagram: @jkt.sweetdessert</span>
              </a>
              <a href="mailto:jktsweetdessert@gmail.com" title="Email">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>Email: jktsweetdessert@gmail.com</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end info_section -->
    <footer class="footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> <strong>JKT Sweet Dessert</strong>. All Rights Reserved.
        </p>
      </div>
    </footer>
</div>

<!-- Toast Notification Styles -->
<style>
  .toast-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    pointer-events: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
  }

  .toast-notification {
    background: white;
    border-radius: 16px;
    padding: 24px 32px;
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 360px;
    pointer-events: auto;
    animation: fadeIn 0.3s ease;
    border-left: 5px solid #4a3a22;
  }

  .toast-notification.success {
    border-left-color: #4a3a22;
    background: linear-gradient(135deg, #ffffff 0%, #f9f5f0 100%);
  }

  .toast-notification.success .toast-icon {
    color: #4a3a22;
    font-size: 28px;
    font-weight: bold;
  }

  .toast-notification.error {
    border-left-color: #d84040;
  }

  .toast-notification.error .toast-icon {
    color: #d84040;
    font-size: 28px;
    font-weight: bold;
  }

  .toast-notification .toast-icon {
    flex-shrink: 0;
    min-width: 28px;
    text-align: center;
  }

  .toast-notification .toast-message {
    flex: 1;
    color: #1f2937;
    font-weight: 600;
    font-size: 16px;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }

  @keyframes fadeOut {
    from {
      opacity: 1;
    }
    to {
      opacity: 0;
    }
  }

  .toast-notification.hide {
    animation: fadeOut 0.3s ease forwards;
  }

  @media (max-width: 640px) {
    .toast-notification {
      min-width: auto;
      width: calc(100% - 40px);
      padding: 20px 24px;
      font-size: 14px;
    }
  }
</style>

<!-- jQery -->
<script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
  <!-- bootstrap js -->
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <!-- slick  slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- custom js -->
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  
  <script>
    // Toast Notification System
    function showToast(message, type = 'success') {
      const container = document.querySelector('.toast-container') || (() => {
        const div = document.createElement('div');
        div.className = 'toast-container';
        document.body.appendChild(div);
        return div;
      })();

      const icon = type === 'success' ? '✓' : '✕';
      const toast = document.createElement('div');
      toast.className = `toast-notification ${type}`;
      toast.innerHTML = `
        <span class="toast-icon">${icon}</span>
        <span class="toast-message">${message}</span>
      `;

      container.appendChild(toast);

      setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 400);
      }, 4000);
    }

    // Check for session messages on page load
    document.addEventListener('DOMContentLoaded', function() {
      @if(session('success'))
        showToast('{{ session('success') }}', 'success');
      @endif

      @if(session('error'))
        showToast('{{ session('error') }}', 'error');
      @endif
    });
  </script>
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

  .info_section .footer-contact .contact_box {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 100%;
    margin: 0;
  }

  .info_section .footer-contact .contact_box a {
    display: flex;
    align-items: center;
    gap: 12px;
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
            <h4>JKT Sweet Dessert</h4>
            <p>Tempat terbaik untuk menemukan berbagai macam dessert dan makanan lezat. Kami menyediakan produk berkualitas tinggi dengan cita rasa yang memukau.</p>
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
              <a href="tel:+628123456789" title="Phone">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>+62 812 3456 789</span>
              </a>
              <a href="mailto:contact@jktsweetdessert.com" title="Email">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>contact@jktsweetdessert.com</span>
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
  
<!DOCTYPE html>
<html>
@include('partial.header')

<head>
  <style>
    /* Modern Products Page Styles */
    .products-page {
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

    /* Page Title */
    .products-page-header {
      margin-bottom: 45px;
      text-align: center;
      animation: fadeInDown 0.8s ease;
    }

    .products-page-header h2 {
      font-size: 2.8rem;
      font-weight: 700;
      color: #4a3a22;
      margin-bottom: 0;
      position: relative;
      display: block;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      letter-spacing: -0.5px;
    }

    .products-page-header .title-lines {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 6px;
      margin-top: 12px;
    }

    .products-page-header .title-line {
      height: 3px;
      border-radius: 2px;
      display: block;
    }

    .products-page-header .title-line-orange {
      width: 50px;
      background: #FF8C42;
    }

    .products-page-header .title-line-purple {
      width: 70px;
      background: #4a3a22;
    }

    /* Modern Search Section - Enhanced Design */
    .find_container {
      max-width: 1100px;
      margin: 0 auto 50px;
      padding: 0 20px;
    }

    .find_container .container {
      background: #ffffff;
      border-radius: 24px;
      padding: 35px 40px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08),
                  0 2px 8px rgba(0, 0, 0, 0.04);
      border: 1px solid rgba(74, 58, 34, 0.08);
      transition: all 0.3s ease;
    }

    .find_container .container:hover {
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12),
                  0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .find_container .row {
      margin: 0;
    }

    .find_container .col {
      padding: 0;
    }

    .find_container .form-row {
      display: flex;
      gap: 18px;
      align-items: center;
      align-content: center;
    }

    .find_container .form-group {
      margin: 0;
      position: relative;
      display: flex;
      align-items: center;
      height: 58px;
    }

    .find_container .form-group.col-lg-5 {
      flex: 1;
      min-width: 0;
    }

    .find_container .form-group.col-lg-4 {
      flex: 0 0 260px;
    }

    .find_container .form-group.col-lg-3 {
      flex: 0 0 160px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Search Input with Icon */
    .find_container .search-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
    }

    .find_container .search-wrapper .search-icon {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 18px;
      pointer-events: none;
      z-index: 3;
      transition: color 0.3s ease;
    }

    .find_container .form-control {
      height: 58px;
      min-height: 58px;
      max-height: 58px;
      border: 2px solid #e2e8f0;
      border-radius: 16px;
      padding: 0 20px;
      padding-left: 50px;
      font-size: 15px;
      line-height: 54px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: #ffffff;
      color: #1a202c;
      font-weight: 400;
      width: 100%;
      box-sizing: border-box;
      margin: 0;
      vertical-align: middle;
    }

    .find_container .form-control::placeholder {
      color: #94a3b8;
      font-weight: 400;
    }

    .find_container .form-control:focus {
      border-color: #4a3a22;
      box-shadow: 0 0 0 5px rgba(74, 58, 34, 0.08),
                  0 4px 12px rgba(74, 58, 34, 0.1);
      outline: none;
      background: #fefefe;
    }

    .find_container .form-control:focus + .search-icon,
    .find_container .form-control:not(:placeholder-shown) + .search-icon {
      color: #4a3a22;
    }

    .find_container .category-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
    }

    .find_container .category-wrapper select {
      height: 58px;
      min-height: 58px;
      max-height: 58px;
      cursor: pointer;
      appearance: none;
      padding-right: 50px;
      padding-left: 50px;
      line-height: 54px;
      border: 2px solid #e2e8f0;
      border-radius: 16px;
      background: #ffffff;
      color: #1a202c;
      font-size: 15px;
      font-weight: 400;
      width: 100%;
      box-sizing: border-box;
      margin: 0;
      vertical-align: middle;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .find_container .category-wrapper select:hover {
      border-color: #cbd5e0;
    }

    .find_container .category-wrapper select:focus {
      border-color: #4a3a22;
      box-shadow: 0 0 0 5px rgba(74, 58, 34, 0.08),
                  0 4px 12px rgba(74, 58, 34, 0.1);
      outline: none;
      background: #fefefe;
    }

    .find_container .category-wrapper .tag-icon {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 16px;
      pointer-events: none;
      z-index: 2;
      transition: color 0.3s ease;
    }

    .find_container .category-wrapper select:focus ~ .tag-icon {
      color: #4a3a22;
    }

    .find_container .category-wrapper::after {
      content: '';
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      width: 0;
      height: 0;
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
      border-top: 7px solid #64748b;
      pointer-events: none;
      z-index: 2;
      transition: border-top-color 0.3s ease;
    }

    .find_container .category-wrapper:hover::after {
      border-top-color: #4a3a22;
    }

    .find_container .location_icon {
      display: none;
    }

    .find_container .btn-box {
      width: 100%;
      height: 58px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .find_container .btn {
      height: 58px;
      min-height: 58px;
      max-height: 58px;
      padding: 0 36px;
      background: linear-gradient(135deg, #4a3a22 0%, #8e6f41 100%);
      border: 2px solid transparent;
      border-radius: 16px;
      color: #ffffff;
      font-weight: 700;
      font-size: 15px;
      line-height: 54px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
      white-space: nowrap;
      box-shadow: 0 6px 20px rgba(74, 58, 34, 0.3),
                  0 2px 8px rgba(74, 58, 34, 0.2);
      width: 100%;
      box-sizing: border-box;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      position: relative;
      overflow: hidden;
    }

    .find_container .btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }

    .find_container .btn:hover::before {
      width: 300px;
      height: 300px;
    }

    .find_container .btn:hover {
      background: linear-gradient(135deg, #392d1a 0%, #7a5f35 100%);
      box-shadow: 0 8px 30px rgba(74, 58, 34, 0.4),
                  0 4px 12px rgba(74, 58, 34, 0.25);
      transform: translateY(-3px);
    }

    .find_container .btn:active {
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(74, 58, 34, 0.35);
    }

    .find_container .btn i,
    .find_container .btn span {
      position: relative;
      z-index: 1;
    }

    .find_container .btn i {
      font-size: 14px;
    }

    /* Products Grid */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 40px;
      margin-bottom: 60px;
      animation: fadeIn 0.8s ease 0.4s both;
      max-width: 1400px;
      margin-left: auto;
      margin-right: auto;
    }
    
    @media (max-width: 1200px) {
      .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 35px;
      }
    }

    /* Modern Product Card - Base styles are now in unified section above */
    .products-grid .box {
      opacity: 0;
      animation: slideInUp 0.6s ease both;
      animation-delay: calc(var(--index) * 0.1s);
      cursor: pointer;
    }
    
    .products-grid .box .card-link {
      display: block;
      text-decoration: none;
      color: inherit;
    }

    .products-grid .box.animate-in {
      opacity: 1;
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* Product Actions - Unified */
    .products-grid .detail-box .d-flex,
    .best-seller-grid .detail-box .d-flex,
    .category-products-grid .detail-box .d-flex {
      gap: 0;
      margin-top: auto;
      padding-top: 15px;
      border-top: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: flex-end;
    }

    .products-grid .detail-box .badge-danger {
      background: #fc8181;
      color: #ffffff;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Empty State */
    .alert-info {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 2px solid #e2e8f0;
      border-radius: 20px;
      padding: 60px 40px;
      text-align: center;
      animation: fadeIn 0.8s ease;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .alert-info h4 {
      color: #1a202c;
      margin-bottom: 15px;
      font-weight: 700;
      font-size: 24px;
    }

    .alert-info p {
      color: #718096;
      font-size: 16px;
      margin-bottom: 0;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 60px;
      animation: fadeIn 0.8s ease 0.8s both;
      flex-wrap: wrap;
    }

    .pagination .page-link {
      border-radius: 12px;
      padding: 12px 18px;
      border: 2px solid #e2e8f0;
      color: #4a5568;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.3s ease;
      background: #ffffff;
      min-width: 45px;
      text-align: center;
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

    /* Animations */
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

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    /* Section Background */
    .recipe_section {
      background: transparent;
      padding: 40px 0;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
      .products-page-header h2 {
        font-size: 2.4rem;
      }
      
      .find_container {
        max-width: 100%;
        padding: 0 15px;
      }
      
      .find_container .container {
        padding: 28px 24px;
        border-radius: 20px;
      }
      
      .find_container .form-row {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
      }
      
      .find_container .form-group {
        width: 100%;
      }
      
      .find_container .form-group.col-lg-4,
      .find_container .form-group.col-lg-3,
      .find_container .form-group.col-lg-5 {
        flex: 1 1 100%;
        min-width: 100%;
      }
      
      .find_container .btn-box {
        width: 100%;
        height: auto;
      }
      
      .find_container .btn {
        width: 100%;
      }
      
      .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
      }
      
      .products-grid .img-box {
        height: 240px;
      }
    }

    @media (max-width: 768px) {
      .hero_area {
        padding-top: 100px;
      }
      
      .products-page-header {
        margin-bottom: 35px;
      }
      
      .products-page-header h2 {
        font-size: 2.2rem;
      }
      
      .find_container .container {
        padding: 24px 20px;
        border-radius: 20px;
      }
      
      .find_container .form-control {
        height: 54px;
        font-size: 14px;
        border-radius: 14px;
        padding: 0 18px;
        padding-left: 48px;
      }

      .find_container .search-wrapper .search-icon {
        left: 18px;
        font-size: 16px;
      }

      .find_container .category-wrapper select {
        height: 54px;
        padding-left: 48px;
        padding-right: 48px;
        border-radius: 14px;
        font-size: 14px;
      }

      .find_container .category-wrapper .tag-icon {
        left: 18px;
        font-size: 14px;
      }

      .find_container .category-wrapper::after {
        right: 18px;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 6px solid #64748b;
      }
      
      .find_container .btn-box {
        height: 54px;
      }
      
      .find_container .btn {
        height: 54px;
        padding: 0 28px;
        font-size: 13px;
        border-radius: 14px;
        letter-spacing: 0.6px;
      }

      .find_container .btn span {
        display: inline-block;
      }
      
      .products-grid {
        grid-template-columns: 1fr;
        gap: 25px;
      }
      
      .products-grid .detail-box {
        padding: 20px 18px 18px 18px;
        min-height: 160px;
      }
      
      .products-grid .img-box {
        height: 220px;
      }
      
      .products-grid .detail-box h4 {
        font-size: 20px;
      }
      
      .products-grid .detail-box .description {
        font-size: 12px;
        min-height: 34px;
      }
      
      .products-grid .detail-box .price {
        font-size: 18px;
      }
      
      .products-grid .detail-box .btn-primary {
        width: 48px;
        height: 48px;
      }
      
      .products-grid .detail-box .btn {
        width: 100%;
      }
    }

    @media (max-width: 576px) {
      .products-page-header h2 {
        font-size: 1.8rem;
      }
      
      .find_container {
        margin-bottom: 40px;
      }
      
      .products-grid {
        grid-template-columns: 1fr;
      }
    }

    /* Best Seller Section */
    .best-seller-section {
      margin-bottom: 60px;
      animation: fadeIn 0.8s ease 0.2s both;
    }

    .best-seller-section .section-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .best-seller-section .section-header h3 {
      font-size: 2.2rem;
      font-weight: 700;
      color: #4a3a22;
      margin-bottom: 12px;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .best-seller-section .section-header .title-lines {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 6px;
      margin-top: 12px;
    }

    .best-seller-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }

    @media (max-width: 1200px) {
      .best-seller-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 991px) {
      .best-seller-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
      }
    }

    @media (max-width: 768px) {
      .best-seller-grid {
        grid-template-columns: 1fr;
      }
    }

    /* Category Section */
    .category-section {
      margin-bottom: 60px;
      animation: fadeIn 0.8s ease 0.4s both;
    }

    .category-section-item {
      margin-bottom: 50px;
    }

    .category-section-item:last-child {
      margin-bottom: 0;
    }

    .category-section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 2px solid #e2e8f0;
    }

    .category-section-header h3 {
      font-size: 1.8rem;
      font-weight: 700;
      color: #4a3a22;
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      text-transform: capitalize;
    }

    .category-section-header .view-all-link {
      color: #4a3a22;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .category-section-header .view-all-link:hover {
      color: #8e6f41;
      transform: translateX(4px);
    }

    .category-products-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
    }

    @media (max-width: 991px) {
      .category-products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
      }
    }

    @media (max-width: 768px) {
      .category-products-grid {
        grid-template-columns: 1fr;
      }
    }

    /* Best Seller Badge */
    .best-seller-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
      color: #ffffff;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 3px 10px rgba(255, 140, 66, 0.4);
      z-index: 2;
    }

    /* Unified Card Styles - All cards should have same dimensions */
    .products-grid .box,
    .best-seller-grid .box,
    .category-products-grid .box {
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      border: 1px solid #e2e8f0;
      position: relative;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .products-grid .box:hover,
    .best-seller-grid .box:hover,
    .category-products-grid .box:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      border-color: #cbd5e0;
    }

    .products-grid .box .img-box,
    .best-seller-grid .box .img-box,
    .category-products-grid .box .img-box {
      position: relative;
      width: 100%;
      height: 260px;
      overflow: hidden;
      background: #f7fafc;
    }

    .products-grid .box .img-box img,
    .best-seller-grid .box .img-box img,
    .category-products-grid .box .img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .products-grid .box:hover .img-box img,
    .best-seller-grid .box:hover .img-box img,
    .category-products-grid .box:hover .img-box img {
      transform: scale(1.1);
    }

    .products-grid .box .detail-box,
    .best-seller-grid .box .detail-box,
    .category-products-grid .box .detail-box {
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      min-height: 180px;
    }

    .products-grid .box .detail-box h4,
    .best-seller-grid .box .detail-box h4,
    .category-products-grid .box .detail-box h4 {
      font-size: 1.2rem;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 8px;
      line-height: 1.3;
    }

    .products-grid .box .detail-box .text-muted,
    .best-seller-grid .box .detail-box .text-muted,
    .category-products-grid .box .detail-box .text-muted {
      color: #718096;
      font-size: 0.9rem;
      margin-bottom: 12px;
      text-transform: capitalize;
    }

    .products-grid .box .detail-box .price,
    .best-seller-grid .box .detail-box .price,
    .category-products-grid .box .detail-box .price {
      font-size: 1.3rem;
      font-weight: 700;
      color: #4a3a22;
      margin-bottom: 15px;
    }

    .products-grid .box .detail-box .btn,
    .best-seller-grid .box .detail-box .btn,
    .category-products-grid .box .detail-box .btn {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
      border: none;
      padding: 0;
      margin-left: auto;
    }

    .products-grid .box .detail-box .btn:hover,
    .best-seller-grid .box .detail-box .btn:hover,
    .category-products-grid .box .detail-box .btn:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 18px rgba(102, 126, 234, 0.4);
    }

    .products-grid .box .detail-box .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .products-grid .box .detail-box .btn-primary:hover {
      background: linear-gradient(135deg, #5568d3 0%, #653a8f 100%);
    }
  </style>
</head>

<body class="products-page">
  <div class="hero_area">
    <section class="recipe_section layout_padding-top">
      <div class="container">
        <div class="heading_container heading_center products-page-header">
          <h2>Our Products</h2>
          <div class="title-lines">
            <div class="title-line title-line-orange"></div>
            <div class="title-line title-line-purple"></div>
          </div>
        </div>

        <!-- Search and Filter -->
        <div class="find_container">  
          <div class="container">
            <div class="row">
              <div class="col">
                <form method="GET" action="{{ route('products.index') }}">
                  <div class="form-row">
                    <div class="form-group col-lg-5">
                      <div class="search-wrapper">
                        <i class="fa fa-search search-icon" aria-hidden="true"></i>
                        <input type="text" name="search" class="form-control" id="inputProductName" placeholder="Nama Makanan" value="{{ request('search') }}" autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group col-lg-4">
                      <div class="category-wrapper">
                        <i class="fa fa-tags tag-icon" aria-hidden="true"></i>
                        <select name="category" class="form-control" id="inputCategory" onchange="this.form.submit()">
                          <option value="">Semua Kategori</option>
                          @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                              {{ $category->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-lg-3">
                      <div class="btn-box" style="margin-bottom: 40px;">
                        <button type="submit" class="btn">
                          <i class="fa fa-search" aria-hidden="true"></i>
                          <span>SEARCH</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Menu Paling Laris Section -->
        @if(isset($topProducts) && count($topProducts) > 0 && !request('search') && !request('category'))
        <div class="best-seller-section">
          <div class="section-header">
            <h3>🔥 Menu Paling Laris</h3>
            <p style="color: #666; font-size: 1rem; margin-top: 10px; max-width: 600px; margin-left: auto; margin-right: auto;">
              Menu favorit yang paling banyak dibeli oleh pelanggan kami
            </p>
            <div class="title-lines">
              <div class="title-line title-line-orange"></div>
              <div class="title-line title-line-purple"></div>
            </div>
          </div>
          <style>
            /* Top Product Card - Same size as other cards */
            .top-product-card {
              position: relative;
              background: #ffffff;
              border-radius: 16px;
              overflow: hidden;
              box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
              border: 1px solid #e2e8f0;
              transition: all 0.3s ease;
              height: 100%;
              display: flex;
              flex-direction: column;
            }
            .top-product-card:hover {
              transform: translateY(-8px);
              box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
              border-color: #cbd5e0;
            }
            .top-product-card .img-box {
              position: relative;
              width: 100%;
              height: 260px;
              overflow: hidden;
              background: #f7fafc;
            }
            .top-product-card .img-box img {
              width: 100%;
              height: 100%;
              object-fit: cover;
              transition: transform 0.5s ease;
            }
            .top-product-card:hover .img-box img {
              transform: scale(1.1);
            }
            .top-product-card .rank-badge {
              position: absolute;
              top: 12px;
              left: 12px;
              width: 45px;
              height: 45px;
              background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
              color: white;
              border-radius: 50%;
              display: flex;
              align-items: center;
              justify-content: center;
              font-size: 1.2rem;
              font-weight: 700;
              z-index: 10;
              box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            }
            .top-product-card .popular-badge {
              position: absolute;
              top: 12px;
              right: 12px;
              background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
              color: white;
              padding: 6px 14px;
              border-radius: 20px;
              font-size: 0.75rem;
              font-weight: 700;
              z-index: 10;
              box-shadow: 0 3px 12px rgba(255, 107, 107, 0.4);
              white-space: nowrap;
            }
            .top-product-card .popular-badge i {
              margin-right: 4px;
            }
            .top-product-card .detail-box {
              padding: 20px;
              flex-grow: 1;
              display: flex;
              flex-direction: column;
              min-height: 180px;
            }
            .top-product-card .detail-box h4 {
              font-size: 1.2rem;
              font-weight: 700;
              color: #2d3748;
              margin-bottom: 8px;
              line-height: 1.3;
            }
            .top-product-card .detail-box .text-muted {
              color: #718096;
              font-size: 0.9rem;
              margin-bottom: 12px;
              text-transform: capitalize;
            }
            .top-product-card .detail-box .price {
              font-size: 1.3rem;
              font-weight: 700;
              color: #4a3a22;
              margin-bottom: 15px;
            }
            .top-product-card .product-footer {
              display: flex;
              justify-content: space-between;
              align-items: center;
              margin-top: auto;
              padding-top: 15px;
              border-top: 1px solid #e2e8f0;
            }
            .top-product-card .sold-info {
              display: flex;
              align-items: center;
              color: #718096;
              font-size: 0.85rem;
            }
            .top-product-card .sold-info i {
              margin-right: 6px;
              color: #667eea;
            }
            .top-product-card .view-btn {
              width: 45px;
              height: 45px;
              border-radius: 50%;
              background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
              color: white;
              display: flex;
              align-items: center;
              justify-content: center;
              text-decoration: none;
              transition: all 0.3s ease;
              box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            }
            .top-product-card .view-btn:hover {
              transform: scale(1.1);
              box-shadow: 0 6px 18px rgba(102, 126, 234, 0.4);
            }
          </style>
          <div class="best-seller-grid">
            @foreach($topProducts as $index => $item)
              <div class="top-product-card animate-on-scroll" style="--index: {{ $index % 4 }};">
                <div class="rank-badge">{{ $index + 1 }}</div>
                @if($index < 3)
                  <div class="popular-badge">
                    <i class="fa fa-fire" aria-hidden="true"></i> Paling Laris
                  </div>
                @endif
                <a href="{{ route('products.show', $item['product']->slug) }}" class="card-link" style="text-decoration: none; color: inherit;">
                  <div class="img-box">
                    <img src="{{ asset($item['product']->image ?: 'assets/images/r1.jpg') }}" alt="{{ $item['product']->name }}">
                  </div>
                </a>
                <div class="detail-box">
                  <h4>{{ $item['product']->name }}</h4>
                  <p class="text-muted">{{ $item['product']->category->name }}</p>
                  <p class="price">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                  <div class="product-footer">
                    <span class="sold-info">
                      <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                      <span>Terjual: {{ $item['total_sold'] }}</span>
                    </span>
                    <a href="{{ route('products.show', $item['product']->slug) }}" class="view-btn" title="Lihat Detail Produk" onclick="event.stopPropagation();">
                      <i class="fa fa-arrow-right"></i>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @endif

        <!-- Products by Category Section -->
        @if($productsByCategory->count() > 0 && !request('search') && !request('category'))
        <div class="category-section">
          @foreach($productsByCategory as $category)
            @if($category->products->count() > 0)
            <div class="category-section-item">
              <div class="category-section-header">
                <h3>{{ $category->name }}</h3>
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="view-all-link">
                  Lihat Semua <i class="fa fa-arrow-right"></i>
                </a>
              </div>
              <div class="category-products-grid">
                @foreach($category->products as $index => $product)
                  <div class="box animate-on-scroll" style="--index: {{ $index % 3 }};">
                    <a href="{{ route('products.show', $product->slug) }}" class="card-link" style="text-decoration: none; color: inherit;">
                      <div class="img-box">
                        <img src="{{ asset($product->image ?: 'assets/images/r1.jpg') }}" class="box-img" alt="{{ $product->name }}">
                      </div>
                    </a>
                    <div class="detail-box">
                      <h4>{{ $product->name }}</h4>
                      <p class="text-muted">{{ $product->category->name }}</p>
                      <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                      <div class="d-flex justify-content-end align-items-center">
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary" title="Lihat Detail Produk" onclick="event.stopPropagation();">
                          <i class="fa fa-arrow-right"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            @endif
          @endforeach
        </div>
        @endif

        <!-- All Products Grid (Only show when searching or filtering) -->
        @if(request('search') || request('category'))
        <div class="products-page-header" style="margin-top: 40px;">
          <h2>Hasil Pencarian</h2>
          <div class="title-lines">
            <div class="title-line title-line-orange"></div>
            <div class="title-line title-line-purple"></div>
          </div>
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
          @forelse($products as $index => $product)
            <div class="box animate-on-scroll" style="--index: {{ $index % 6 }};">
              <a href="{{ route('products.show', $product->slug) }}" class="card-link" style="text-decoration: none; color: inherit;">
                <div class="img-box">
                  <img src="{{ asset($product->image ?: 'assets/images/r1.jpg') }}" class="box-img" alt="{{ $product->name }}">
                </div>
              </a>
              <div class="detail-box">
                <h4>{{ $product->name }}</h4>
                <p class="text-muted">{{ $product->category->name }}</p>
                <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="d-flex justify-content-end align-items-center">
                  <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary" title="Lihat Detail Produk" onclick="event.stopPropagation();">
                    <i class="fa fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          @empty
            <div style="grid-column: 1 / -1;">
              <div class="alert alert-info text-center">
                <h4>No products found</h4>
                <p>Try adjusting your search or filter criteria.</p>
              </div>
            </div>
          @endforelse
        </div>

        <!-- Pagination -->
        <div class="row">
          <div class="col-12">
            {{ $products->links() }}
          </div>
        </div>
        @endif
      </div>
    </section>
  </div>

  @include('partial.footer')

  <!-- Animation Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };

      const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animated');
            observer.unobserve(entry.target);
          }
        });
      }, observerOptions);

      document.querySelectorAll('.animate-on-scroll').forEach(box => {
        observer.observe(box);
      });

      setTimeout(() => {
        document.querySelectorAll('.products-grid .box').forEach((box, index) => {
          setTimeout(() => {
            box.classList.add('animate-in');
          }, index * 100);
        });
      }, 100);
    });
  </script>
</body>
</html>


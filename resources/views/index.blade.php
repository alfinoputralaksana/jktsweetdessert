<!DOCTYPE html>
<html>



<body>



  <div class="hero_area">
    <!-- header section strats -->
    @section('header')
        @include('partial.header')
    @show
    <!-- end header section -->

    <!-- slider section -->
    <section class="slider_section ">
      <div class="container ">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <div class="detail-box">
              <h1>
              A Taste of Sweet & Savory Perfection
              </h1>
              <p>
              From rich desserts to flavorful savory dishes, experience the best of both worlds at JKT Sweet Dessert
              </p>
            </div>
            <div class="find_container ">
              <div class="container">
                <div class="row">
                  <div class="col">
                    <form method="GET" action="{{ route('products.index') }}">
                      <div class="form-row ">
                        <div class="form-group col-lg-5">
                          <input type="text" name="search" class="form-control" id="inputProductName" placeholder="Nama Makanan" value="{{ request('search') }}">
                        </div>
                        <div class="form-group col-lg-4">
                          <select name="category" class="form-control" id="inputCategory" style="height: 45px; border-radius: 45px; padding: 0 15px; background-color: #ffffff; border: none;">
                            <option value="">Semua Kategori</option>
                            @php
                              $categories = \App\Models\Category::where('is_active', true)->get();
                            @endphp
                            @foreach($categories as $category)
                              <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                              </option>
                            @endforeach
                          </select>
                          <span class="location_icon">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                          </span>
                        </div>
                        <div class="form-group col-lg-3">
                          <div class="btn-box">
                            <button type="submit" class="btn ">Search</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="slider_container">
        <div class="item">
          <div class="img-box">
            <img src="{{ asset('assets/images/slider-img1.png') }}" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="{{ asset('assets/images/slider-img2.png') }}" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="{{ asset('assets/images/slider-img3.png') }}" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="{{ asset('assets/images/slider-img4.png') }}" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="{{ asset('assets/images/slider-img1.png') }}" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="{{ asset('assets/images/slider-img2.png') }}" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="{{ asset('assets/images/slider-img3.png') }}" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="{{ asset('assets/images/slider-img4.png') }}" alt="" />
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>


  <!-- recipe section -->
  @php
    $topProducts = \App\Http\Controllers\ForecastingController::getTopProducts(6);
  @endphp

  <section class="recipe_section layout_padding-top">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          🔥 Menu Paling Laris
        </h2>
        <p style="color: #666; font-size: 1rem; margin-top: 10px; max-width: 600px; margin-left: auto; margin-right: auto;">
          Menu favorit yang paling banyak dibeli oleh pelanggan kami
        </p>
      </div>
      <style>
        .top-product-card {
          position: relative;
          background: #ffffff;
          border-radius: 16px;
          overflow: hidden;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
          transition: all 0.3s ease;
          height: 100%;
          display: flex;
          flex-direction: column;
        }
        .top-product-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .top-product-card .img-box {
          position: relative;
          width: 100%;
          height: 250px;
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
        }
        .top-product-card .detail-box h4 {
          font-size: 1.3rem;
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
          font-size: 1.4rem;
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
          font-size: 0.9rem;
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
      <div class="row">
        @forelse($topProducts as $index => $item)
          <div class="col-sm-6 col-md-4 mb-4">
            <div class="top-product-card">
              <div class="rank-badge">{{ $index + 1 }}</div>
              @if($index < 3)
                <div class="popular-badge">
                  <i class="fa fa-fire" aria-hidden="true"></i> Paling Laris
                </div>
              @endif
              <div class="img-box">
                <a href="{{ route('products.show', $item['product']->slug) }}">
                  <img src="{{ asset($item['product']->image ?: 'assets/images/r1.jpg') }}" alt="{{ $item['product']->name }}">
                </a>
              </div>
              <div class="detail-box">
                <h4>{{ $item['product']->name }}</h4>
                <p class="text-muted">{{ $item['product']->category->name }}</p>
                <p class="price">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                <div class="product-footer">
                  <span class="sold-info">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <span>Terjual: {{ $item['total_sold'] }}</span>
                  </span>
                  <a href="{{ route('products.show', $item['product']->slug) }}" class="view-btn" title="Lihat Detail">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center">
            <p>Belum ada produk tersedia.</p>
          </div>
        @endforelse
      </div>
      <div class="btn-box">
        <a href="{{ route('products.index') }}">
          Lihat Semua Produk
        </a>
      </div>
    </div>
  </section>

  <!-- end recipe section -->

  

  <!-- client section -->

  <section class="client_section layout_padding">
    <div class="container">
      <div class="col-md-11 col-lg-10 mx-auto">
        <div class="heading_container heading_center">
          <h2>
            Testimonial
          </h2>
        </div>
        <div id="customCarousel1" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="detail-box">
                <h4>
                  Virginia
                </h4>
                <p>
                  Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and
                </p>
                <i class="fa fa-quote-left" aria-hidden="true"></i>
              </div>
            </div>
            <div class="carousel-item">
              <div class="detail-box">
                <h4>
                  Virginia
                </h4>
                <p>
                  Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and
                </p>
                <i class="fa fa-quote-left" aria-hidden="true"></i>
              </div>
            </div>
            <div class="carousel-item">
              <div class="detail-box">
                <h4>
                  Virginia
                </h4>
                <p>
                  Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and
                </p>
                <i class="fa fa-quote-left" aria-hidden="true"></i>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev d-none" href="#customCarousel1" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#customCarousel1" role="button" data-slide="next">
            <i class="fa fa-arrow-right" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- end client section -->

 


    <!-- footer section -->
    @section('footer')
             @include('partial.footer')
            @show
    <!-- footer section -->


  


</body>

</html>
<!DOCTYPE html>
<html>
@include('partial.header')

<head>
  <style>
    body {
      background: #ffffff;
      background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZm9vZFBhdHRlcm4iIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZjBmMGYwIiBzdHJva2Utd2lkdGg9IjAuNSIgb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0idXJsKCNmb29kUGF0dGVybikiLz48L3N2Zz4=');
      background-size: 200px 200px;
      background-repeat: repeat;
      min-height: 100vh;
    }
  </style>
</head>
<body>
  <div class="hero_area">
    <section class="recipe_section layout_padding-top" style="margin-top: 100px;">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Checkout</h2>
        </div>

        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST" class="checkout-form">
          @csrf
          <div class="row">
            <div class="col-md-8">
              <div class="card mb-4">
                <div class="card-header">
                  <h5>Customer Information</h5>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                    @error('customer_name')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                    @error('customer_email')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Phone *</label>
                    <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required>
                    @error('customer_phone')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Delivery Type *</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="delivery_type" id="delivery" value="delivery" {{ old('delivery_type', $deliveryType ?? 'delivery') === 'delivery' ? 'checked' : '' }} required>
                      <label class="form-check-label" for="delivery">
                        Delivery (Ongkir dihitung otomatis sesuai alamat)
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="delivery_type" id="self_pickup" value="self_pickup" {{ old('delivery_type') === 'self_pickup' ? 'checked' : '' }} required>
                      <label class="form-check-label" for="self_pickup">
                        Self Pickup (Ambil Sendiri)
                      </label>
                    </div>
                    @error('delivery_type')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div id="address-group">
                    <div class="form-group">
                      <label>Province *</label>
                      <select name="customer_province" id="customer_province" class="form-control" required>
                        <option value="">Pilih Provinsi</option>
                        <option value="DKI Jakarta" {{ old('customer_province') === 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                        <option value="Jawa Barat" {{ old('customer_province') === 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                        <option value="Jawa Tengah" {{ old('customer_province') === 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                        <option value="Jawa Timur" {{ old('customer_province') === 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                        <option value="Yogyakarta" {{ old('customer_province') === 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                        <option value="Banten" {{ old('customer_province') === 'Banten' ? 'selected' : '' }}>Banten</option>
                        <option value="Sumatera Utara" {{ old('customer_province') === 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                        <option value="Sumatera Barat" {{ old('customer_province') === 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                        <option value="Sumatera Selatan" {{ old('customer_province') === 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                        <option value="Riau" {{ old('customer_province') === 'Riau' ? 'selected' : '' }}>Riau</option>
                        <option value="Kepulauan Riau" {{ old('customer_province') === 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                        <option value="Lampung" {{ old('customer_province') === 'Lampung' ? 'selected' : '' }}>Lampung</option>
                        <option value="Aceh" {{ old('customer_province') === 'Aceh' ? 'selected' : '' }}>Aceh</option>
                        <option value="Bengkulu" {{ old('customer_province') === 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                        <option value="Jambi" {{ old('customer_province') === 'Jambi' ? 'selected' : '' }}>Jambi</option>
                        <option value="Kalimantan Barat" {{ old('customer_province') === 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                        <option value="Kalimantan Tengah" {{ old('customer_province') === 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                        <option value="Kalimantan Selatan" {{ old('customer_province') === 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                        <option value="Kalimantan Timur" {{ old('customer_province') === 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                        <option value="Kalimantan Utara" {{ old('customer_province') === 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                        <option value="Sulawesi Utara" {{ old('customer_province') === 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                        <option value="Sulawesi Tengah" {{ old('customer_province') === 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                        <option value="Sulawesi Selatan" {{ old('customer_province') === 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                        <option value="Sulawesi Tenggara" {{ old('customer_province') === 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                        <option value="Gorontalo" {{ old('customer_province') === 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                        <option value="Sulawesi Barat" {{ old('customer_province') === 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                        <option value="Bali" {{ old('customer_province') === 'Bali' ? 'selected' : '' }}>Bali</option>
                        <option value="Nusa Tenggara Barat" {{ old('customer_province') === 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                        <option value="Nusa Tenggara Timur" {{ old('customer_province') === 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                        <option value="Maluku" {{ old('customer_province') === 'Maluku' ? 'selected' : '' }}>Maluku</option>
                        <option value="Maluku Utara" {{ old('customer_province') === 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                        <option value="Papua" {{ old('customer_province') === 'Papua' ? 'selected' : '' }}>Papua</option>
                        <option value="Papua Barat" {{ old('customer_province') === 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                        <option value="Papua Selatan" {{ old('customer_province') === 'Papua Selatan' ? 'selected' : '' }}>Papua Selatan</option>
                        <option value="Papua Tengah" {{ old('customer_province') === 'Papua Tengah' ? 'selected' : '' }}>Papua Tengah</option>
                        <option value="Papua Pegunungan" {{ old('customer_province') === 'Papua Pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
                      </select>
                      @error('customer_province')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>City *</label>
                      <input type="text" name="customer_city" id="customer_city" class="form-control" value="{{ old('customer_city') }}" placeholder="Contoh: Jakarta Pusat" required>
                      @error('customer_city')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Postal Code</label>
                      <input type="text" name="customer_postal_code" id="customer_postal_code" class="form-control" value="{{ old('customer_postal_code') }}" placeholder="Contoh: 10110">
                      @error('customer_postal_code')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Full Address *</label>
                      <textarea name="customer_address" id="customer_address" class="form-control" rows="3" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" required>{{ old('customer_address') }}</textarea>
                      @error('customer_address')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div id="shipping-info" class="alert alert-info" style="display: none;">
                      <small id="shipping-message"></small>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                  </div>
                </div>
              </div>

              <div class="card">
                <div class="card-header">
                  <h5>Order Items</h5>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($products as $item)
                        <tr>
                          <td>{{ $item['name'] }}</td>
                          <td>{{ $item['quantity'] }}</td>
                          <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                          <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-4 checkout-summary">
              <div class="card" style="border: 2px solid #D4A574; box-shadow: 0 4px 15px rgba(139, 111, 71, 0.15); border-radius: 10px; overflow: hidden;\">
                <div class="card-header" style="background: linear-gradient(135deg, #8B6F47 0%, #6B5637 100%); border: none; padding: 16px;">
                  <h5 style="margin: 0; color: #F5E6D3; font-weight: 700; font-size: 16px;"><i class="fa fa-credit-card" style="margin-right: 8px;"></i>Payment Method</h5>
                </div>
                <div class="card-body" style="padding: 16px; background: #FEFCF8;">
                  <div class="form-group">


                    <!-- Virtual Account Payment (RECOMMENDED) -->
                    <div class="form-check mb-3" style="padding: 16px; background: linear-gradient(135deg, #A0826D 0%, #8B6F47 100%); border-radius: 12px; border: 3px solid #D4A574; box-shadow: 0 6px 20px rgba(139, 111, 71, 0.25); transition: all 0.3s ease;">
                      <input class="form-check-input" type="radio" name="payment_method" id="virtual_account" value="virtual_account" {{ old('payment_method') === 'virtual_account' ? 'checked' : 'checked' }} required>
                      <label class="form-check-label" for="virtual_account" style="cursor: pointer; margin: 0; color: white; display: flex; align-items: center;">
                        <i class="fa fa-university" style="color: #F5E6D3; font-size: 20px; margin-right: 10px;"></i>
                        <div>
                          <strong style="font-size: 15px; display: block;">💰 Virtual Account</strong>
                          <span style="position: absolute; top: 8px; right: 12px; background: #D4A574; color: #6B5637; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; letter-spacing: 0.5px;">RECOMMENDED</span>
                          <small style="color: #F5E6D3; display: block; margin-top: 4px;">Transfer via BCA, BNI, Mandiri, Permata, CIMB, UOB, Danamon</small>
                        </div>
                      </label>
                    </div>
                    <!-- Bank Selection (muncul saat Virtual Account dipilih) -->
                    <div id="bank-selection" class="ml-4 mb-4" style="display: {{ old('payment_method') === 'virtual_account' || !old('payment_method') ? 'block' : 'none' }}; padding: 14px; background: #F5E6D3; border-radius: 10px; border-left: 4px solid #8B6F47;">
                      <label for="va_bank" class="form-label" style="font-size: 13px; font-weight: 600; margin-bottom: 10px; color: #6B5637; display: block;">
                        <i class="fa fa-building" style="color: #A0826D; margin-right: 6px;"></i> Pilih Bank Anda:
                      </label>
                      <select name="va_bank" id="va_bank" class="form-control" style="font-size: 13px; border: 2px solid #D4A574; background: white; color: #6B5637; padding: 8px 12px; border-radius: 6px;">
                        <option value="bca" {{ old('va_bank') === 'bca' ? 'selected' : 'selected' }}>BCA - Bank Central Asia</option>
                        <option value="bni" {{ old('va_bank') === 'bni' ? 'selected' : '' }}>BNI - Bank Negara Indonesia</option>
                        <option value="mandiri" {{ old('va_bank') === 'mandiri' ? 'selected' : '' }}>Mandiri - Bank Mandiri</option>
                        <option value="permata" {{ old('va_bank') === 'permata' ? 'selected' : '' }}>Permata - Bank Permata</option>
                        <option value="cimb" {{ old('va_bank') === 'cimb' ? 'selected' : '' }}>CIMB Niaga - CIMB Niaga</option>
                        <option value="uob" {{ old('va_bank') === 'uob' ? 'selected' : '' }}>UOB - United Overseas Bank</option>
                        <option value="danamon" {{ old('va_bank') === 'danamon' ? 'selected' : '' }}>Danamon - Bank Danamon</option>
                      </select>
                      <small style="color: #8B6F47; margin-top: 8px; display: block; font-style: italic;">
                        <i class="fa fa-lightbulb" style="color: #D4A574;"></i> Setiap order mendapat nomor rekening unik untuk tracking pembayaran.
                      </small>
                    </div>

                    <!-- QRIS Payment -->
                    <div class="form-check mb-3" style="padding: 16px; background: linear-gradient(135deg, #D4A574 0%, #A0826D 100%); border-radius: 12px; border: 2px solid #8B6F47; box-shadow: 0 6px 20px rgba(212, 165, 116, 0.2); transition: all 0.3s ease;">
                      <input class="form-check-input" type="radio" name="payment_method" id="qris" value="qris" {{ old('payment_method') === 'qris' ? 'checked' : '' }} required>
                      <label class="form-check-label" for="qris" style="cursor: pointer; margin: 0; color: white; display: flex; align-items: center;">
                        <i class="fa fa-qrcode" style="font-size: 20px; margin-right: 10px;"></i>
                        <div>
                          <strong style="font-size: 15px; display: block;">🎯 QRIS (Semua E-Wallet)</strong>
                          <small style="color: #F5E6D3; display: block; margin-top: 4px;">Scan QR Code dengan GoPay, OVO, DANA, LinkAja, atau e-wallet lainnya</small>
                        </div>
                      </label>
                    </div>
                    <!-- QRIS Info -->
                    <div id="qris-channel-selection" class="ml-4 mb-4" style="display: {{ old('payment_method') === 'qris' ? 'block' : 'none' }}; padding: 14px; background: #F5E6D3; border-radius: 10px; border-left: 4px solid #D4A574;">
                      <input type="hidden" name="qris_channel" value="gopay">
                      <div style="margin: 0; font-size: 12px;">
                        <strong style="color: #6B5637; display: block; margin-bottom: 8px;"><i class="fa fa-check-circle" style="color: #8B6F47; margin-right: 6px;"></i>Cara Pembayaran QRIS:</strong>
                        <small style="display: block; margin-top: 6px; color: #8B6F47; line-height: 1.6;">
                          1. Scan QR Code menggunakan aplikasi e-wallet Anda<br>
                          2. Pilih e-wallet yang tersedia: GoPay, OVO, DANA, LinkAja, atau e-wallet lainnya<br>
                          3. Lakukan konfirmasi pembayaran di aplikasi
                        </small>
                      </div>
                    </div>

                    <!-- Cash Payment -->
                    <div class="form-check mb-3" style="padding: 16px; background: linear-gradient(135deg, #C9B0A0 0%, #A0826D 100%); border-radius: 12px; border: 2px solid #8B6F47; box-shadow: 0 6px 20px rgba(160, 130, 109, 0.2); transition: all 0.3s ease;">
                      <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" {{ old('payment_method') === 'cash' ? 'checked' : '' }} required>
                      <label class="form-check-label" for="cash" style="cursor: pointer; margin: 0; color: white; display: flex; align-items: center;">
                        <i class="fa fa-money" style="color: #F5E6D3; font-size: 20px; margin-right: 10px;"></i>
                        <div>
                          <strong style="font-size: 15px; display: block;">💵 Cash (Bayar di Tempat)</strong>
                          <small style="color: #F5E6D3; display: block; margin-top: 4px;">Ambil sendiri dan bayar saat pickup</small>
                        </div>
                      </label>
                    </div>
                  </div>
                  @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Payment Method Guide -->
              <div class="card mt-3" style="background: linear-gradient(135deg, #F5E6D3 0%, #E8D7C3 100%); border: 2px solid #D4A574; box-shadow: 0 4px 15px rgba(139, 111, 71, 0.15); border-radius: 10px;">
                <div class="card-header" style="background: linear-gradient(135deg, #8B6F47 0%, #6B5637 100%); border: none; border-radius: 8px 8px 0 0;">
                  <h6 style="margin: 0; font-size: 12px; text-transform: uppercase; font-weight: 700; color: #F5E6D3; letter-spacing: 1px;">
                    <i class="fa fa-lightbulb" style="color: #D4A574; margin-right: 6px;"></i> Panduan Memilih
                  </h6>
                </div>
                <div class="card-body" style="font-size: 13px; padding: 16px; color: #6B5637;">
                  <div style="margin-bottom: 12px; padding: 10px; background: white; border-left: 4px solid #D4A574; border-radius: 4px;">
                    <strong style="color: #8B6F47;">🎯 Untuk pengguna e-wallet:</strong><br>
                    <small style="color: #8B6F47; margin-top: 4px; display: block;">Pilih QRIS & scan dengan GoPay, OVO, DANA, atau LinkAja</small>
                  </div>
                  <div style="margin-bottom: 12px; padding: 10px; background: white; border-left: 4px solid #A0826D; border-radius: 4px;">
                    <strong style="color: #8B6F47;">🏦 Untuk pengguna m-banking:</strong><br>
                    <small style="color: #8B6F47; margin-top: 4px; display: block;">Pilih Virtual Account & transfer dari aplikasi bank Anda</small>
                  </div>
                  <div style="padding: 10px; background: white; border-left: 4px solid #C9B0A0; border-radius: 4px;">
                    <strong style="color: #8B6F47;">💳 Untuk ambil sendiri (self-pickup):</strong><br>
                    <small style="color: #8B6F47; margin-top: 4px; display: block;">Pilih Cash & bayar saat mengambil pesanan</small>
                  </div>
                </div>
              </div>

              <div class="card mt-3" style="border: 2px solid #D4A574; box-shadow: 0 4px 15px rgba(139, 111, 71, 0.15); border-radius: 10px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #8B6F47 0%, #6B5637 100%); border: none; padding: 16px;">
                  <h5 style="margin: 0; color: #F5E6D3; font-weight: 700; font-size: 16px;">📋 Order Summary</h5>
                </div>
                <div class="card-body" style="padding: 16px; background: #FEFCF8;">
                  <div class="d-flex justify-content-between mb-3" style="padding: 10px; background: #F5E6D3; border-radius: 6px;">
                    <span style="color: #6B5637; font-weight: 500;">Subtotal:</span>
                    <span style="color: #8B6F47; font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-3" id="shipping-row" style="padding: 10px; background: #F5E6D3; border-radius: 6px;">
                    <span style="color: #6B5637; font-weight: 500;">Shipping:</span>
                    <span id="shipping-cost" style="color: #8B6F47; font-weight: 600;">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                  </div>
                  <hr style="border: none; border-top: 2px solid #D4A574; margin: 12px 0;">
                  <div class="d-flex justify-content-between mb-4" style="padding: 12px; background: linear-gradient(135deg, #D4A574 0%, #A0826D 100%); border-radius: 8px;">
                    <strong style="color: white; font-size: 15px;">Total:</strong>
                    <strong id="total-amount" style="color: white; font-size: 18px;">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                  </div>
                  <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #8B6F47 0%, #6B5637 100%); color: white; border: none; padding: 12px; font-weight: 600; border-radius: 8px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(139, 111, 71, 0.2);">
                    <i class="fa fa-shopping-cart" style="margin-right: 8px;"></i> Place Order
                  </button>
                  <button type="button" onclick="window.location.href='{{ route('cart.index') }}'" class="btn btn-block mt-2" style="background: white; color: #8B6F47; border: 2px solid #D4A574; padding: 11px; font-weight: 600; border-radius: 8px; transition: all 0.3s ease;">
                    <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Back to Cart
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>

  @include('partial.footer')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const deliveryTypeInputs = document.querySelectorAll('input[name="delivery_type"]');
      const addressGroup = document.getElementById('address-group');
      const shippingRow = document.getElementById('shipping-row');
      const shippingCost = document.getElementById('shipping-cost');
      const totalAmount = document.getElementById('total-amount');
      const shippingInfo = document.getElementById('shipping-info');
      const shippingMessage = document.getElementById('shipping-message');
      const subtotal = {{ $subtotal }};
      
      let currentShippingCost = 0;
      let isCalculating = false;

      // Function to calculate shipping cost
      async function calculateShipping() {
        const province = document.getElementById('customer_province').value;
        const city = document.getElementById('customer_city').value;
        const postalCode = document.getElementById('customer_postal_code').value;
        const address = document.getElementById('customer_address').value;

        if (!province) {
          shippingInfo.style.display = 'none';
          return;
        }

        isCalculating = true;
        shippingInfo.style.display = 'block';
        shippingMessage.textContent = 'Menghitung ongkir...';
        shippingCost.textContent = 'Menghitung...';

        try {
          const response = await fetch('{{ route("api.calculate-shipping") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              province: province,
              city: city,
              postal_code: postalCode,
              address: address,
              weight: 1.0 // Default 1kg untuk dessert
            })
          });

          const data = await response.json();

          if (data.success) {
            currentShippingCost = data.shipping_cost;
            shippingCost.textContent = 'Rp ' + currentShippingCost.toLocaleString('id-ID');
            
            let message = `${data.provider || 'Estimasi ongkir'} untuk ${data.zone}`;
            shippingMessage.style.color = '#28a745'; // Green untuk success
            shippingMessage.style.fontWeight = 'normal';
            
            // Tampilkan jarak dalam kilometer jika tersedia
            if (data.distance_km !== null && data.distance_km !== undefined) {
              message += ` | Jarak: ${parseFloat(data.distance_km).toFixed(2)} km`;
            }
            
            // Prioritaskan menampilkan estimasi waktu dalam menit/jam (same-day delivery)
            if (data.estimated_minutes) {
              const hours = Math.floor(data.estimated_minutes / 60);
              const minutes = data.estimated_minutes % 60;
              if (hours > 0) {
                message += ` (Same-day delivery: Estimasi ${hours} jam${minutes > 0 ? ' ' + minutes + ' menit' : ''})`;
              } else {
                message += ` (Same-day delivery: Estimasi ${minutes} menit)`;
              }
            } else if (data.estimated_days !== undefined) {
              if (data.estimated_days === 0) {
                message += ` (Same-day delivery: Hari ini)`;
              } else {
                message += ` (Estimasi ${data.estimated_days} hari)`;
              }
            }
            
            shippingMessage.textContent = message;
            updateTotal();
          } else {
            throw new Error('Gagal menghitung ongkir');
          }
        } catch (error) {
          console.error('Error calculating shipping:', error);
          shippingMessage.textContent = 'Gagal menghitung ongkir. Menggunakan ongkir default.';
          currentShippingCost = 25000; // Default
          shippingCost.textContent = 'Rp ' + currentShippingCost.toLocaleString('id-ID');
          updateTotal();
        } finally {
          isCalculating = false;
        }
      }

      // Function to update total
      function updateTotal() {
        const selectedDelivery = document.querySelector('input[name="delivery_type"]:checked');
        if (selectedDelivery && selectedDelivery.value === 'delivery') {
          const total = subtotal + currentShippingCost;
          totalAmount.textContent = 'Rp ' + total.toLocaleString('id-ID');
        } else {
          totalAmount.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        }
      }

      // Function to handle delivery type change
      function updateShipping() {
        const selectedDelivery = document.querySelector('input[name="delivery_type"]:checked');
        
        if (selectedDelivery) {
          if (selectedDelivery.value === 'self_pickup') {
            addressGroup.style.display = 'none';
            addressGroup.querySelectorAll('input, select, textarea').forEach(el => {
              el.removeAttribute('required');
            });
            shippingRow.style.display = 'none';
            shippingInfo.style.display = 'none';
            currentShippingCost = 0;
            shippingCost.textContent = 'Rp 0';
            updateTotal();
          } else {
            addressGroup.style.display = 'block';
            addressGroup.querySelectorAll('input[required], select[required], textarea[required]').forEach(el => {
              el.setAttribute('required', 'required');
            });
            shippingRow.style.display = 'flex';
            // Calculate shipping if province is already selected
            const province = document.getElementById('customer_province').value;
            if (province) {
              calculateShipping();
            } else {
              shippingCost.textContent = 'Pilih provinsi';
              currentShippingCost = 0;
              updateTotal();
            }
          }
        }
      }

      // Event listeners
      deliveryTypeInputs.forEach(input => {
        input.addEventListener('change', updateShipping);
      });

      // Debounce function untuk menghindari terlalu banyak request
      let shippingTimeout;
      function debounceCalculateShipping() {
        clearTimeout(shippingTimeout);
        shippingTimeout = setTimeout(() => {
          if (document.querySelector('input[name="delivery_type"]:checked')?.value === 'delivery' && 
              document.getElementById('customer_province').value) {
            calculateShipping();
          }
        }, 500); // Tunggu 500ms setelah user selesai mengetik
      }

      // Auto-calculate shipping when address fields change
      document.getElementById('customer_province').addEventListener('change', function() {
        if (document.querySelector('input[name="delivery_type"]:checked')?.value === 'delivery') {
          calculateShipping();
        }
      });

      // Real-time calculation saat user mengetik (dengan debounce)
      document.getElementById('customer_city').addEventListener('input', debounceCalculateShipping);
      document.getElementById('customer_city').addEventListener('blur', function() {
        if (document.querySelector('input[name="delivery_type"]:checked')?.value === 'delivery' && 
            document.getElementById('customer_province').value) {
          calculateShipping();
        }
      });

      document.getElementById('customer_postal_code').addEventListener('input', debounceCalculateShipping);
      document.getElementById('customer_postal_code').addEventListener('blur', function() {
        if (document.querySelector('input[name="delivery_type"]:checked')?.value === 'delivery' && 
            document.getElementById('customer_province').value) {
          calculateShipping();
        }
      });

      document.getElementById('customer_address').addEventListener('input', debounceCalculateShipping);
      document.getElementById('customer_address').addEventListener('blur', function() {
        if (document.querySelector('input[name="delivery_type"]:checked')?.value === 'delivery' && 
            document.getElementById('customer_province').value) {
          calculateShipping();
        }
      });


      // Initial update
      updateShipping();
      
      // Auto-calculate shipping on page load if address is already filled
      if (document.querySelector('input[name="delivery_type"]:checked')?.value === 'delivery' && 
          document.getElementById('customer_province').value) {
        // Delay sedikit untuk memastikan semua elemen sudah ter-render
        setTimeout(() => {
          calculateShipping();
        }, 300);
      }

      // Handle QRIS channel and bank selection visibility
      const qrisChannelSelection = document.getElementById('qris-channel-selection');
      const bankSelection = document.getElementById('bank-selection');
      const vaBankSelect = document.getElementById('va_bank');
      const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');

      function togglePaymentSelections() {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        
        // Handle QRIS channel selection display (always show when QRIS selected)
        if (selectedPayment && selectedPayment.value === 'qris') {
          qrisChannelSelection.style.display = 'block';
        } else {
          qrisChannelSelection.style.display = 'none';
        }
        
        // Handle bank selection
        if (selectedPayment && selectedPayment.value === 'virtual_account') {
          bankSelection.style.display = 'block';
          vaBankSelect.setAttribute('required', 'required');
        } else {
          bankSelection.style.display = 'none';
          vaBankSelect.removeAttribute('required');
        }
      }

      // Add event listeners to payment method radio buttons
      paymentMethodInputs.forEach(input => {
        input.addEventListener('change', togglePaymentSelections);
      });

      // Initial check on page load
      togglePaymentSelections();
    });
  </script>
</body>
</html>


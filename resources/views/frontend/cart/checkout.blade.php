@extends('frontend.components.master')

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Checkout
            </div>
        </div>
    </div>

    <div class="container mb-80 mt-50">

        <div class="row">
            <div class="col-lg-8 mb-40">
                <h3 class="heading-2 mb-10">Checkout</h3>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are products in your cart</h6>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <h4 class="mb-30">Billing Details</h4>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" required name="shipping_name" placeholder="User Name *" value="{{ auth()->user()->name ?? '' }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="email" required name="shipping_email" placeholder="Email *" value="{{ auth()->user()->email ?? '' }}">
                            </div>
                        </div>

                        <div class="row shipping_calculator">
                            <div class="form-group col-lg-6">
                                <div class="custom_select">
                                    <select name="shipping_division" id="division_id" class="form-control" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('shipping_division')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="tel" required name="shipping_phone" placeholder="Phone *" value="{{ auth()->user()->phone ?? '' }}">
                            </div>
                        </div>

                        <div class="row shipping_calculator">
                            <div class="form-group col-lg-6">
                                <div class="custom_select">
                                    <select name="shipping_district" id="district_id" class="form-control" required>
                                        <option value="">Select District</option>
                                    </select>
                                    @error('shipping_district')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" required name="shipping_post_code" placeholder="Post Code *">
                            </div>
                        </div>

                        <div class="row shipping_calculator">
                            <div class="form-group col-lg-6">
                                <div class="custom_select">
                                    <select name="shipping_state" id="state_id" class="form-control" required>
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" required name="shipping_full_address" placeholder="Full Address *" value="{{ auth()->user()->address ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group mb-30">
                            <textarea rows="5" name="shipping_notes" placeholder="Additional information"></textarea>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Your Order</h4>
                            <h6 class="text-muted">Subtotal</h6>
                        </div>

                        <div class="divider-2 mb-30"></div>

                        <div class="table-responsive order_table checkout">
                            <table class="table no-border">
                                <tbody>
                                    @foreach($cartItems as $cartItem)
                                    <tr>
                                        <td class="image product-thumbnail">
                                            <img src="{{ asset($cartItem->product->product_thumbnail) }}" alt="{{ $cartItem->product->name }}" width="70" height="70">
                                        </td>
                                        <td>
                                            <h6 class="w-160 mb-5">
                                                <a href="{{ url('/product-details/' . $cartItem->product->id . '/' . $cartItem->product->product_slug) }}" class="text-heading">
                                                    {{ $cartItem->product->product_name }}
                                                </a>
                                            </h6>
                                            <div class="product-rate-cover">
                                                @if($cartItem->color)
                                                    <strong>Color: </strong>{{ $cartItem->color }}
                                                @endif

                                                @if($cartItem->size)
                                                    <strong>Size: </strong>{{ $cartItem->size }}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="text-muted pl-20 pr-20">x {{ $cartItem->quantity }}</h6>
                                        </td>
                                        <td>
                                            <h4 class="text-brand">${{ number_format(($cartItem->product->selling_price - $cartItem->product->discount_price) * $cartItem->quantity, 2) }}</h4>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table class="table no-border">
                                <tbody>
                                    @if(Session::has('coupon'))
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">${{ number_format($total, 2) }}</h4>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Coupon Name</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h6 class="text-brand text-end">
                                                <span class="text-success text-end" style="font-size: 16px; font-weight: normal;">
                                                    -{{ session('coupon')['discount'] }}% off -
                                                </span>
                                                {{ session('coupon')['code'] }}
                                            </h6>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Coupon Discount</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">-${{ number_format($total - $finalTotal, 2) }}</h4>
                                        </td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Grand Total</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">${{ number_format($finalTotal, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="payment ml-30">
                        <h4 class="mb-30">Payment</h4>

                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" required type="radio" name="payment_option" value="stripe" id="exampleRadios3" checked>
                                <label class="form-check-label" for="exampleRadios3">Stripe</label>
                            </div>

                            <div class="custome-radio">
                                <input class="form-check-input" required type="radio" name="payment_option" value="cash" id="exampleRadios4">
                                <label class="form-check-label" for="exampleRadios4">Cash on delivery</label>
                            </div>

                            <div class="custome-radio">
                                <input class="form-check-input" required type="radio" name="payment_option" value="card" id="exampleRadios5">
                                <label class="form-check-label" for="exampleRadios5">Online Gateway</label>
                            </div>
                        </div>

                        <div class="payment-logo d-flex">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-paypal.svg') }}" alt="">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-visa.svg') }}" alt="">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-master.svg') }}" alt="">
                            <img src="{{ asset('frontend/assets/imgs/theme/icons/payment-zapper.svg') }}" alt="">
                        </div>

                        <button type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i class="fi-rs-sign-out ml-15"></i></button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <script>
        // Load districts based on the selected division
        function loadDistricts(divisionId, districtSelect, selectedDistrictId = null) {
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (divisionId) {
                fetch(`/get-districts/${divisionId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.districts.forEach(district => {
                            let option = document.createElement('option');
                            option.value = district.id;
                            option.textContent = district.district_name;
                            if (district.id === selectedDistrictId) option.selected = true;
                            districtSelect.appendChild(option);
                        });
                    })
                    .catch(() => alert('Failed to load districts.'));
            }
        }

        // Load states based on the selected district
        function loadStates(districtId, stateSelect) {
            stateSelect.innerHTML = '<option value="">Select State...</option>';

            if (districtId) {
                fetch(`/get-states/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.states.forEach(state => {
                            let option = document.createElement('option');
                            option.value = state.id;
                            option.textContent = state.state_name;
                            stateSelect.appendChild(option);
                        });
                    })
                    .catch(() => alert('Failed to load states.'));
            }
        }

        // Event listener for division change
        document.getElementById('division_id').addEventListener('change', function () {
            loadDistricts(this.value, document.getElementById('district_id'));
            document.getElementById('state_id').innerHTML = '<option value="">Select State...</option>';
        });

        // Event listener for district change
        document.getElementById('district_id').addEventListener('change', function () {
            loadStates(this.value, document.getElementById('state_id'));
        });
    </script>
@endsection

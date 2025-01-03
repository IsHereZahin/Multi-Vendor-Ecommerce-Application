@extends('frontend.components.master')

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span><a href="{{ route('checkout') }}" rel="nofollow">Checkout</a></span>
                <span>Cash on Delivery</span>
            </div>
        </div>
    </div>

    <div class="container mb-80 mt-50">

        <div class="row">
            <div class="col-lg-8 mb-40">
                <h3 class="heading-2 mb-10">Checkout</h3>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">Cash on Delivery</h6>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6">
                <div class="border p-40 cart-totals ml-30 mb-50">
                    <div class="d-flex align-items-end justify-content-between mb-30">
                        <h4>Your Order</h4>
                        <h6 class="text-muted">Subtotal</h6>
                    </div>

                    <div class="divider-2 mb-30"></div>

                    <div class="table-responsive order_table checkout">

                        <table class="table no-border">
                            <tbody>
                                @if (Session::has('coupon'))
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
                                                <span class="text-success text-end"
                                                    style="font-size: 16px; font-weight: normal;">
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
                                            <h4 class="text-brand text-end">-${{ number_format($total - $finalTotal, 2) }}
                                            </h4>
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

            </div>

            <div class="col-lg-6">
                <div class="border p-40 cart-totals ml-30 mb-50">
                    <h4 class="mb-30">Payment</h4>

                    <!-- Cash on Delivery Form -->
                    <form action="{{ route('cash.on.delivery.order') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <input type="hidden" name="name" value="{{ $shippingDetails['shipping_name'] }}">
                            <input type="hidden" name="email" value="{{ $shippingDetails['shipping_email'] }}">
                            <input type="hidden" name="phone" value="{{ $shippingDetails['shipping_phone'] }}">
                            <input type="hidden" name="post_code" value="{{ $shippingDetails['shipping_post_code'] }}">
                            <input type="hidden" name="division_id" value="{{ $shippingDetails['shipping_division'] }}">
                            <input type="hidden" name="district_id" value="{{ $shippingDetails['shipping_district'] }}">
                            <input type="hidden" name="state_id" value="{{ $shippingDetails['shipping_state'] }}">
                            <input type="hidden" name="address" value="{{ $shippingDetails['shipping_full_address'] }}">
                            <input type="hidden" name="notes" value="{{ $shippingDetails['shipping_notes'] }}">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="bi bi-truck mr-2"></i> Place Order with Cash on Delivery
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

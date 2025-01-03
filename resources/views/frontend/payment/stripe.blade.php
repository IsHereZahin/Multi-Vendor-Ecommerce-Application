@extends('frontend.components.master')

@section('content')
    <style>
        /**
             * The CSS shown here will not be introduced in the Quickstart guide, but shows
             * how you can use CSS to style your Element's container.
             */
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span><a href="{{ route('checkout') }}" rel="nofollow">Checkout</a></span>
                <span>Sprint Payment</span>
            </div>
        </div>
    </div>

    <div class="container mb-80 mt-50">

        <div class="row">
            <div class="col-lg-8 mb-40">
                <h3 class="heading-2 mb-10">Checkout</h3>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">Sprint Payment</h6>
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

                    <form action="{{ route('stripe.order') }}" method="post" id="payment-form">
                        @csrf
                        <div class="form-row">
                            <label for="card-element">
                                Credit or Debit Card
                            </label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Display form errors -->
                            <div id="card-errors" role="alert" style="color: red; margin-top: 10px;"></div>
                        </div>
                        <br>
                        <button class="btn btn-primary btn-block">Submit Payment</button>
                    </form>

                </div>

            </div>
        </div>

    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Stripe
            var stripe = Stripe('pk_test_51Qd87wEaVIXahkGH7n836x40faXeyayjGiRoBu4MdLBFBmOClQVooRbLXJytz2cNcWtldToK5FFDROSGhgCOurDT007c2J8oNT'); // Publishable key
            var elements = stripe.elements();

            // Custom styling for the card element
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create and mount the card element
            var card = elements.create('card', { style: style });
            card.mount('#card-element');

            // Handle real-time validation errors
            card.on('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        // Show error in the form
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Submit the token to the server
                        stripeTokenHandler(result.token);
                    }
                });
            });

            // Submit form with the Stripe token
            function stripeTokenHandler(token) {
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        });
    </script>
@endsection

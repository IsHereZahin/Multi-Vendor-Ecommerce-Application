<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nest - Multipurpose eCommerce HTML Template</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.3') }}" />
     <!-- Toaster -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    <!-- Toaster   -->
</head>

<body>
    <!-- Modal -->

    @include('frontend.components.header')

    <main class="main">

        @yield('content')

    </main>

    @include('frontend.components.footer')

    @include('frontend.components.preloader')

    <!-- Vendor JS-->
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
    <script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>

    <!-- Toaster -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
     @if(Session::has('message'))
     var type = "{{ Session::get('alert-type','info') }}"
     switch(type){
        case 'info':
        toastr.info(" {{ Session::get('message') }} ");
        break;
        case 'success':
        toastr.success(" {{ Session::get('message') }} ");
        break;
        case 'warning':
        toastr.warning(" {{ Session::get('message') }} ");
        break;
        case 'error':
        toastr.error(" {{ Session::get('message') }} ");
        break;
     }
     @endif
    </script>
    <script>
        function addToCart(button, productId) {
            let quantity = parseInt(document.getElementById(`qty_${productId}`).value);
            let availableQty = parseInt(document.getElementById(`product_qty_${productId}`).value);
            let size = document.getElementById(`sizeSelect_${productId}`)?.value || null;
            let color = document.getElementById(`colorSelect_${productId}`)?.value || null;

            if (size === "--Choose Size--") {
                toastr.warning("Please select a valid size.");
                return;
            }

            if (color === "--Choose Color--") {
                toastr.warning("Please select a valid color.");
                return;
            }

            if (quantity > availableQty) {
                toastr.warning("You cannot add more than the available stock.");
                return;
            }

            let data = {
                product_id: productId,
                quantity: quantity,
                size: size,
                color: color,
                _token: '{{ csrf_token() }}'
            };

            button.disabled = true;

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        updateCartData();
                    } else {
                        toastr.error(response.message);
                    }
                    button.disabled = false;
                },
                error: function (xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    toastr.error("Something went wrong! Make sure you are logged in.");
                    button.disabled = false;
                }
            });
        }

        function quickAddToCart(productId) {
            let qtyElement = document.getElementById(`product_qty_${productId}`);
            if (!qtyElement) {
                console.error(`Element with id 'product_qty_${productId}' not found.`);
                return;
            }
            let quantity = 1; // Default quantity for quick add
            let availableQty = parseInt(document.getElementById(`product_qty_${productId}`).value);

            if (quantity > availableQty) {
                toastr.warning("You cannot add more than the available stock.");
                return;
            }

            let data = {
                product_id: productId,
                quantity: quantity,
                size: null,
                color: null,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        updateCartData();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    toastr.error("Something went wrong! Make sure you are logged in.");
                }
            });
        }

        function updateCartData() {
            $.ajax({
                url: "{{ route('cart.data') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    // Update cart item count
                    $('.pro-count').text(response.count);

                    // Update cart dropdown content
                    let cartHtml = '';
                    response.cartItems.forEach(item => {
                        cartHtml += `
                            <li>
                                <div class="shopping-cart-img">
                                    <a href="#"><img alt="${item.product.product_name}" src="${item.product.product_thambnail}" /></a>
                                </div>
                                <div class="shopping-cart-title">
                                    <h4><a href="/product-details/${item.product.id}/${item.product.product_slug}">${item.product.product_name}</a></h4>
                                    <h4><span>${item.quantity} × </span>$${(item.product.selling_price - item.product.discount_price)}</h4>
                                </div>
                                <div class="shopping-cart-delete">
                                    <a href="/cart/remove/${item.id}" class="text-body">
                                        <i class="fi-rs-cross-small"></i>
                                    </a>
                                </div>
                            </li>
                        `;
                    });

                    $('.cart-dropdown-wrap ul').html(cartHtml);

                    // Update cart total
                    $('.shopping-cart-total span').text(`$${response.total}`);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching cart data:', xhr.responseText);
                }
            });
        }

    </script>
</body>
</html>

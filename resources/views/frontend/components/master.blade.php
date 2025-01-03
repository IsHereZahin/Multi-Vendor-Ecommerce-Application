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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <!-- Toaster   -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    @php
        $products = \App\Models\Product::all();
    @endphp
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

    <!-- Stripe -->
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
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
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        updateCartData();
                    } else {
                        toastr.error(response.message);
                    }
                    button.disabled = false;
                },
                error: function(xhr, status, error) {
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
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        updateCartData();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    toastr.error("Something went wrong! Make sure you are logged in.");
                }
            });
        }

        function wishToCart(productId) {
            var data = {
                product_id: productId,
                quantity: 1,
                size: '',
                color: '',
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '/cart/add',
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('.cart-count').text(response.count);

                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    toastr.error("Something went wrong! Make sure you are logged in.");
                }
            });
        }

        // Function to increment the quantity
        function incrementQuantity(id) {
            $.ajax({
                url: '/cart/increment/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        updateCartData();
                    } else {
                        toastr.error(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error("An error occurred while updating the quantity.");
                }
            });
        }

        // Function to decrement the quantity
        function decrementQuantity(id) {
            $.ajax({
                url: '/cart/decrement/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        updateCartData();
                    } else {
                        toastr.error(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error("An error occurred while updating the quantity.");
                }
            });
        }

        // Function to update the cart data
        function updateCartData() {
            $.ajax({
                url: "{{ route('cart.data') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // Update cart item count in mini-cart
                    $('.cart-count').text(response.count);
                    $('#cart-count').text(response.count);

                    // Handle empty cart case
                    if (response.cartItems.length === 0) {
                        $('.cart-dropdown-wrap ul').html('<li>Your cart is empty.</li>');
                        $('tbody').html(
                            '<tr><td colspan="8" class="text-center">Your cart is empty.</td></tr>');
                        $('#subtotal').text('$0.00');
                        $('#dropdown-total').text('$0.00');
                        $('#summaryDiscountAmount').text('$0.00');
                        $('.finalTotal').text('$0.00');
                        $('#couponSection').html('');
                        return;
                    }

                    // Update mini-cart dropdown content
                    let cartHtml = '';
                    response.cartItems.forEach(item => {
                        let subtotal = (item.product.selling_price - item.product.discount_price) * item
                            .quantity;
                        let baseUrl = window.location.origin;
                        cartHtml += `
                            <li>
                                <div class="shopping-cart-img">
                                    <a href="#"><img src="${baseUrl}/${item.product.product_thumbnail}" class="p-2" alt="${item.product.product_name}"></a>
                                </div>
                                <div class="shopping-cart-title">
                                    <h4><a href="/product-details/${item.product.id}/${item.product.product_slug}">${item.product.product_name}</a></h4>
                                    <h4><span>${item.quantity} × </span>$${(item.product.selling_price - item.product.discount_price)}</h4>
                                </div>
                                <div class="shopping-cart-delete">
                                    <a href="javascript:void(0);" class="text-body" onclick="CartRemove(${item.id})">
                                        <i class="fi-rs-cross-small"></i>
                                    </a>
                                </div>
                            </li>
                        `;
                    });
                    $('.cart-dropdown-wrap ul').html(cartHtml);

                    // Update main cart table content
                    let cartTableHtml = '';
                    response.cartItems.forEach(item => {
                        let amount = item.product.selling_price - item.product.discount_price;
                        let subtotal = amount * item.quantity;
                        let baseUrl = window.location.origin;
                        cartTableHtml += `
                            <tr class="pt-30">
                                <td class="image product-thumbnail p-2 pt-40">
                                    <img src="${baseUrl}/${item.product.product_thumbnail}" class="p-2" alt="${item.product.product_name}">
                                </td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5">
                                        <a class="product-name mb-10 text-heading" href="/product-details/${item.product.id}/${item.product.product_slug}">
                                            ${item.product.product_name}
                                        </a>
                                    </h6>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">$${amount}</h4>
                                </td>
                                <td class="detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div class="detail-qty border radius">
                                            <a href="javascript:void(0);" class="qty-up" onclick="incrementQuantity(${item.id});">
                                                <i class="fi-rs-angle-small-up"></i>
                                            </a>
                                            <input type="text" name="quantity" id="quantity-${item.id}" class="qty-val" value="${item.quantity}" min="1" readonly>
                                            <a href="javascript:void(0);" class="qty-down" onclick="decrementQuantity(${item.id});">
                                                <i class="fi-rs-angle-small-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price subtotal" data-title="Total" id="subtotal-${item.id}">
                                    <h4 class="text-brand">$${subtotal}</h4>
                                </td>
                                <td class="text-center" data-title="Color">
                                    <span class="text-muted">${item.color ?? '-'}</span>
                                </td>
                                <td class="text-center" data-title="Size">
                                    <span class="text-muted">${item.size ?? '-'}</span>
                                </td>
                                <td class="action text-center" data-title="Remove">
                                    <a href="javascript:void(0);" onclick="CartRemove(${item.id})">
                                        <i class="fi-rs-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                    $('tbody').html(cartTableHtml);

                    // Update total price in cart table and dropdown
                    $('#subtotal').text(`$${response.total}`);
                    $('#dropdown-total').text(`$${response.total}`);

                    // If has coupon
                    let couponHtml = `
                        <form action="#" class="d-flex align-items-center gap-2">
                            <div class="input-group flex-grow-1 mr-2">
                                <input type="text" class="form-control coupon font-medium" id="coupon_name" placeholder="Enter Your Coupon">
                            </div>
                            <button type="button" onclick="applyCoupon()" class="btn btn-success d-flex align-items-center">
                                <i class="bi bi-check-circle mr-2"></i> Apply
                            </button>
                        </form>
                    `;
                    $('#couponSection').html(couponHtml);

                    // If a coupon exists in the session, apply it
                    if (response.coupon) {
                        $('#coupon_name').val(response.coupon.code); // Pre-fill coupon code
                        applyCoupon();
                    } else {
                        // If no coupon exists, finalTotal = subtotal
                        let finalTotal = response.total;
                        $('.finalTotal').text(`$${finalTotal}`);
                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cart data:', xhr.responseText);
                }
            });
        }

        function applyCoupon() {
            let couponName = $('#coupon_name').val();
            $.ajax({
                url: "/coupon-apply",
                type: "POST",
                data: {
                    coupon_name: couponName,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.validity) {
                        updateCartSection(response);
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error applying coupon:', xhr.responseText);
                    toastr.error('Something went wrong. Please try again.', 'Error');
                }
            });
        }

        function updateCartSection(response) {
            // Reset previous coupon data
            $('#couponDiscountSection').hide();
            $('#summaryDiscountAmount').text('$0.00');
            $('#summaryDiscountPercent').text('-0%');
            $('#discountAmount').text('$0.00');
            $('#totalAmount').text('$' + response.cartTotal.toFixed(2));  // Show initial total without coupon
            $('.couponCode').text('N/A');

            // Update subtotal
            $('#subtotal').text('$' + response.cartTotal.toFixed(2));

            // Show discount if it exists
            if (response.discount_amount > 0) {
                $('#couponDiscountSection').show();
                $('#summaryDiscountAmount').text('-$' + response.discount_amount.toFixed(2));
                $('#summaryDiscountPercent').text('-' + response.discount_percent + '%');
                $('#discountAmount').text('-$' + response.discount_amount.toFixed(2));
                $('#totalAmount').text('$' + response.total_amount.toFixed(2));
                $('.couponCode').text(response.coupon_code);
            }

            // Update final total (with or without discount)
            $('.finalTotal').text('$' + response.total_amount.toFixed(2));
        }

        // Function to remove an item from the mini cart via AJAX
        function CartRemove(itemId) {
            $.ajax({
                type: 'GET',
                url: '/minicart/product/remove/' + itemId,
                dataType: 'json',
                success: function(data) {
                    // Refresh the mini cart view
                    updateCartData();
                    if ($.isEmptyObject(data.error)) {
                        toastr.success(data.success);
                    } else {
                        toastr.error(data.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    toastr.error("Something went wrong! Please try again.");
                },
            });
        }

        // Toggle wishlist (add or remove item)
        function toggleWishlist(productId) {
            $.ajax({
                type: "POST",
                url: "/wishlist/toggle/" + productId,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if ($.isEmptyObject(response.error)) {
                        toastr[response.warning ? 'warning' : 'success'](response.success);
                        updateWishlistButton(productId, response.isRemoved);
                        updateWishlistHeader(response.count);
                    } else {
                        toastr.error(response.error);
                    }
                },
                error: function() {
                    toastr.error("Something went wrong. Please try again.");
                }
            });
        }

        // Update all wishlist buttons for a given product
        function updateWishlistButton(productId, isRemoved) {
            const buttons = $('[data-product-id="' + productId + '"]');

            buttons.each(function() {
                const button = $(this);

                if (!isRemoved) {
                    button.addClass('added-to-wishlist')
                        .find('i').addClass('text-danger');
                    button.attr('aria-label', 'Remove from wishlist');
                } else {
                    button.removeClass('added-to-wishlist')
                        .find('i').removeClass('text-danger');
                    button.attr('aria-label', 'Add to wishlist');
                }
            });
        }

        // Update the wishlist count in the header
        function updateWishlistHeader(count) {
            $('.wishlist_button .pro-count').text(count);
            $('.mb-50 .text-brand').text(count);
        }

        // Remove Coupon Function
        function removeCoupon() {
            $.ajax({
                url: '/coupon-remove',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update the cart data
                    updateCartData(response);

                    $('#couponSuccessMessage').hide();
                    $('#couponDiscountSection').hide();

                    $('.couponCode').text('N/A');
                    $('#summaryDiscountPercent').text('0.00%');
                    $('#summaryDiscountAmount').text('-$0.00');

                    toastr.warning('Coupon removed successfully!');
                },
                error: function(xhr, status, error) {
                    console.error('Error removing coupon:', xhr.responseText);
                    toastr.error('Something went wrong. Please try again.');
                }
            });
        }
    </script>
</body>

</html>

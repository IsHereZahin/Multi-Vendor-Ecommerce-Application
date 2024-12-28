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

                    // Update cart dropdown content
                    let cartHtml = '';
                    response.cartItems.forEach(item => {
                        let subtotal = (item.product.selling_price - item.product.discount_price) * item.quantity;
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
                                    <a href="javascript:void(0);" class="text-body" onclick="miniCartRemove(${item.id})">
                                        <i class="fi-rs-cross-small"></i>
                                    </a>
                                </div>
                            </li>
                        `;
                    });

                    $('.cart-dropdown-wrap ul').html(cartHtml);

                    // Update cart table content
                    let cartTableHtml = '';
                    response.cartItems.forEach(item => {
                        let amount = item.product.selling_price - item.product.discount_price;
                        let subtotal = amount * item.quantity;
                        let baseUrl = window.location.origin;
                        cartTableHtml += `
                            <tr class="pt-30">
                                <!-- Product Image Column -->
                                <td class="image product-thumbnail p-2 pt-40">
                                    <img src="${baseUrl}/${item.product.product_thumbnail}" class="p-2" alt="${item.product.product_name}">
                                </td>

                                <!-- Product Name and Rating Column -->
                                <td class="product-des product-name">
                                    <h6 class="mb-5">
                                        <a class="product-name mb-10 text-heading" href="/product-details/${item.product.id}/${item.product.product_slug}">
                                            ${item.product.product_name}
                                        </a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:${item.product.rating * 10}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">(${item.product.rating})</span>
                                    </div>
                                </td>

                                <!-- Price Column -->
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">$${amount}</h4>
                                </td>

                                <!-- Quantity Column -->
                                <td class="text-center detail-info" data-title="Stock">
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

                                <!-- Subtotal Column -->
                                <td class="price subtotal" data-title="Total" id="subtotal-${item.id}">
                                    <h4 class="text-brand">$${subtotal}</h4>
                                </td>

                                <!-- Color Column -->
                                <td class="text-center" data-title="Color">
                                    <span class="text-muted">${item.color ?? '-'}</span>
                                </td>

                                <!-- Size Column -->
                                <td class="text-center" data-title="Size">
                                    <span class="text-muted">${item.size ?? '-'}</span>
                                </td>

                                <!-- Remove Column -->
                                <td class="action text-center" data-title="Remove">
                                    <a href="javascript:void(0);" onclick="miniCartRemove(${item.id})">
                                        <i class="fi-rs-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });

                    // Update the cart table with the new HTML content
                    $('tbody').html(cartTableHtml);

                    // Update the total price
                    $('.shopping-cart-total span').text(`$${response.total}`);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cart data:', xhr.responseText);
                }
            });
        }

        // Function to remove an item from the mini cart via AJAX
        function miniCartRemove(itemId) {
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
                success: function (response) {
                    if ($.isEmptyObject(response.error)) {
                        toastr[response.warning ? 'warning' : 'success'](response.success);
                        updateWishlistButton(productId, response.isRemoved);
                        updateWishlistHeader(response.count);
                    } else {
                        toastr.error(response.error);
                    }
                },
                error: function () {
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
    </script>
</body>
</html>

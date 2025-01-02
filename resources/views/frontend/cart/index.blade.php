@extends('frontend.components.master')

@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Cart
            </div>
        </div>
    </div>

    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-12 mb-40">
                <h1 class="heading-2 mb-10">Your Cart</h1>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are <span class="text-brand" id="cart-count">{{ count($cartItems) }}</span>
                        products in your cart</h6>
                    <h6 class="text-body"><a href="{{ route('cart.clear') }}" class="text-muted"><i
                                class="fi-rs-trash mr-5"></i>Clear Cart</a></h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive shopping-summery">
                    <table class="table table-wishlist">
                        <thead>
                            <tr class="main-heading">
                                <th scope="col" colspan="2">Product</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Color</th>
                                <th scope="col">Size</th>
                                <th scope="col" class="end">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $item)
                                <tr class="pt-30">
                                    <!-- Product Image Column -->
                                    <td class="image product-thumbnail p-2 pt-40">
                                        <img src="{{ asset($item->product->product_thumbnail) }}" class="p-2"
                                            alt="{{ $item->product->product_name }}">
                                    </td>

                                    <!-- Product Name and Rating Column -->
                                    <td class="product-des product-name">
                                        <h6 class="mb-5">
                                            <a class="product-name mb-10 text-heading"
                                                href="{{ url('/product-details/' . $item->product->id . '/' . $item->product->product_slug) }}">
                                                {{ $item->product->product_name }}
                                            </a>
                                        </h6>
                                    </td>

                                    <!-- Price Column -->
                                    <td class="price" data-title="Price">
                                        @php
                                            $amount = $item->product->selling_price - $item->product->discount_price;
                                        @endphp
                                        <h4 class="text-brand">${{ $amount }}</h4>
                                    </td>

                                    <!-- Quantity Column -->
                                    <td class="detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <div class="detail-qty border radius">
                                                <a href="javascript:void(0);" class="qty-up"
                                                    onclick="incrementQuantity({{ $item->id }});">
                                                    <i class="fi-rs-angle-small-up"></i>
                                                </a>
                                                <input type="text" name="quantity" id="quantity-{{ $item->id }}"
                                                    class="qty-val" value="{{ $item->quantity }}" min="1" readonly>
                                                <a href="javascript:void(0);" class="qty-down"
                                                    onclick="decrementQuantity({{ $item->id }});">
                                                    <i class="fi-rs-angle-small-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Subtotal Column -->
                                    <td class="price subtotal" data-title="Total" id="subtotal-{{ $item->id }}">
                                        <h4 class="text-brand">
                                            ${{ $item->quantity * ($item->product->selling_price - $item->product->discount_price) }}
                                        </h4>
                                    </td>

                                    @php
                                        // Extract colors and sizes for the specific product
                                        $availableColors = $item->product
                                            ? array_filter(explode(',', $item->product->product_color ?? ''))
                                            : [];
                                        $availableSizes = $item->product
                                            ? array_filter(explode(',', $item->product->product_size ?? ''))
                                            : [];
                                    @endphp

                                    <!-- Color Column -->
                                    <td data-title="Color d-flax" id="color-cell-{{ $item->id }}">
                                        <div class="d-flex align-items-center">
                                            <h6 id="color-display-{{ $item->id }}" class="text-brand me-2">
                                                {{ $item->color ?? '-' }}</h6>
                                            @if (count($availableColors) > 0)
                                                <!-- Only show the edit button if colors are available -->
                                                <a id="color-edit-link-{{ $item->id }}" href="javascript:void(0);"
                                                    onclick="toggleEditColor({{ $item->id }});">
                                                    <i class="bi bi-pencil text-success"></i>
                                                    <!-- Bootstrap edit icon with green color -->
                                                </a>
                                            @endif
                                        </div>
                                        <form id="color-form-{{ $item->id }}" method="POST"
                                            action="{{ route('cart.update', $item->id) }}" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                            <select name="color" onchange="updateColor({{ $item->id }});">
                                                <option value="">Select Color</option>
                                                @foreach ($availableColors as $color)
                                                    <option value="{{ trim($color) }}"
                                                        {{ $item->color === trim($color) ? 'selected' : '' }}>
                                                        {{ ucfirst(trim($color)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>

                                    <!-- Size Column -->
                                    <td data-title="Size d-flax" id="size-cell-{{ $item->id }}">
                                        <div class="d-flex align-items-center">
                                            <h6 id="size-display-{{ $item->id }}" class="text-brand me-2">
                                                {{ $item->size ?? '-' }}</h6>
                                            @if (count($availableSizes) > 0)
                                                <!-- Only show the edit button if sizes are available -->
                                                <a id="size-edit-link-{{ $item->id }}" href="javascript:void(0);"
                                                    onclick="toggleEditSize({{ $item->id }});">
                                                    <i class="bi bi-pencil text-success"></i>
                                                    <!-- Bootstrap edit icon with green color -->
                                                </a>
                                            @endif
                                        </div>
                                        <form id="size-form-{{ $item->id }}" method="POST"
                                            action="{{ route('cart.update', $item->id) }}" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                            <select name="size" onchange="updateSize({{ $item->id }});">
                                                <option value="">Select Size</option>
                                                @foreach ($availableSizes as $size)
                                                    <option value="{{ trim($size) }}"
                                                        {{ $item->size === trim($size) ? 'selected' : '' }}>
                                                        {{ ucfirst(trim($size)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>

                                    <script>
                                        // Function to toggle the color edit form visibility
                                        function toggleEditColor(itemId) {
                                            const displaySpan = document.getElementById(`color-display-${itemId}`);
                                            const editLink = document.getElementById(`color-edit-link-${itemId}`);
                                            const form = document.getElementById(`color-form-${itemId}`);

                                            if (form.style.display === "none") {
                                                form.style.display = "block";
                                                displaySpan.style.display = "none";
                                                editLink.innerHTML = '<i class="bi bi-x text-danger"></i>';
                                            } else {
                                                form.style.display = "none";
                                                displaySpan.style.display = "block";
                                                editLink.innerHTML = '<i class="bi bi-pencil text-success"></i>';
                                            }
                                        }

                                        // Function to toggle the size edit form visibility
                                        function toggleEditSize(itemId) {
                                            const displaySpan = document.getElementById(`size-display-${itemId}`);
                                            const editLink = document.getElementById(`size-edit-link-${itemId}`);
                                            const form = document.getElementById(`size-form-${itemId}`);

                                            if (form.style.display === "none") {
                                                form.style.display = "block";
                                                displaySpan.style.display = "none";
                                                editLink.innerHTML = '<i class="bi bi-x text-danger"></i>';
                                            } else {
                                                form.style.display = "none";
                                                displaySpan.style.display = "block";
                                                editLink.innerHTML = '<i class="bi bi-pencil text-success"></i>';
                                            }
                                        }

                                        // AJAX function to update color without page reload
                                        function updateColor(itemId) {
                                            const form = document.getElementById(`color-form-${itemId}`);
                                            const formData = new FormData(form);

                                            fetch(form.action, {
                                                    method: 'POST',
                                                    body: formData,
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        const displaySpan = document.getElementById(`color-display-${itemId}`);
                                                        displaySpan.innerText = data.color;
                                                        toggleEditColor(itemId);
                                                    }
                                                })
                                                .catch(error => console.error('Error:', error));
                                        }

                                        // AJAX function to update size without page reload
                                        function updateSize(itemId) {
                                            const form = document.getElementById(`size-form-${itemId}`);
                                            const formData = new FormData(form);

                                            fetch(form.action, {
                                                    method: 'POST',
                                                    body: formData,
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        const displaySpan = document.getElementById(`size-display-${itemId}`);
                                                        displaySpan.innerText = data.size;
                                                        toggleEditSize(itemId);
                                                    }
                                                })
                                                .catch(error => console.error('Error:', error));
                                        }
                                    </script>

                                    <!-- Remove Column -->
                                    <td class="action text-center" data-title="Remove">
                                        <a href="javascript:void(0);" onclick="CartRemove({{ $item->id }})">
                                            <i class="fi-rs-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Your cart is empty.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Left Column: Coupon Section -->
            <div class="col-lg-5">
                <div class="coupon-section p-4">
                    <h4 class="mb-4 font-weight-bold">Apply Coupon</h4>
                    <p class="mb-3 text-muted font-lg">Have a Promo Code?</p>
                    <form action="#" class="d-flex align-items-center gap-2">
                        <!-- Input field for Coupon -->
                        <div class="input-group flex-grow-1 mr-2">
                            <input type="text" class="form-control coupon font-medium" id="coupon_name"
                                placeholder="Enter Your Coupon">
                        </div>
                        <!-- Apply Button -->
                        <button type="button" onclick="applyCoupon()" class="btn btn-success d-flex align-items-center">
                            <i class="fi-rs-label mr-10"></i> Apply
                        </button>
                    </form>

                    <!-- Coupon Applied Message -->
                    @if (session('coupon'))
                        <p class="text-success mt-3 coupon-applied" id="couponSuccessMessage">
                            Coupon Applied Successfully! ||
                            Code: <span class="fw-bold couponCode">{{ session('coupon')['code'] ?? 'N/A' }}</span> ||
                            Discount: <span class="fw-bold text-success"
                                id="summaryDiscountPercent">-{{ session('coupon')['discount'] ?? '0' }}%</span>
                        </p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Cart Summary -->
            <div class="col-lg-7">
                <div class="card border shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 fs-4">Order Summary</h5>

                        <!-- Subtotal Section -->
                        <div class="summary-item d-flex justify-content-between mb-3">
                            <span class="text-muted fs-5">Subtotal</span>
                            <span class="fw-bold fs-5" id="subtotal">${{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Discount Section (dynamically updated) -->
                        <div class="summary-item d-flex justify-content-between mb-3 coupon-applied"
                            id="couponDiscountSection">
                            <span class="text-muted fs-5">
                                Discount (<span class="couponCode">{{ session('coupon')['code'] ?? 'N/A' }}</span>)
                                <a href="javascript:void(0);" class="text-danger ms-2"
                                    onclick="removeCoupon()">
                                    <i class="fi-rs-trash"></i>
                                </a>
                            </span>
                            <span class="fw-bold text-success fs-5" id="summaryDiscountAmount">
                                -${{ session('coupon')['discount_amount'] ?? '0.00' }}
                            </span>
                        </div>

                        <!-- Shipping Section -->
                        <div class="summary-item d-flex justify-content-between mb-3">
                            <span class="text-muted fs-5">Shipping</span>
                            <span class="fw-bold fs-5">Calculated at checkout</span>
                        </div>

                        <hr>

                        <!-- Total Section -->
                        <div class="summary-item d-flex justify-content-between mb-4">
                            <span class="fs-5">Total</span>
                            <span class="fw-bold text-primary finalTotal fs-5">
                                ${{ number_format(session('coupon')['total_amount'] ?? $total, 2) }}
                            </span>
                        </div>

                        <a href="#" class="btn btn-primary w-100 fs-5">
                            Proceed to Checkout <i class="fi-rs-sign-out ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

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
                    <h6 class="text-body">There are <span class="text-brand">{{ count($cartItems) }}</span> products in your cart</h6>
                    <h6 class="text-body"><a href="{{ route('cart.clear') }}" class="text-muted"><i class="fi-rs-trash mr-5"></i>Clear Cart</a></h6>
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
                            @foreach($cartItems as $item)
                            <tr class="pt-30">
                                <!-- Product Image Column -->
                                <td class="image product-thumbnail pt-40">
                                    <img src="{{ asset($item->product->product_thambnail) }}" alt="{{ $item->product->product_name }}">
                                </td>

                                <!-- Product Name and Rating Column -->
                                <td class="product-des product-name">
                                    <h6 class="mb-5">
                                        <a class="product-name mb-10 text-heading" href="{{ url('/product-details/'.$item->product->id.'/'.$item->product->product_slug) }}">
                                            {{ $item->product->product_name }}
                                        </a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:{{ $item->product->rating * 10 }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">({{ $item->product->rating }})</span>
                                    </div>
                                </td>

                                <!-- Price Column -->
                                <td class="price" data-title="Price">
                                    @php
                                        $amount = $item->product->selling_price - $item->product->discount_price;
                                        $subtotal = $amount * $item->quantity;
                                    @endphp
                                    <h4 class="text-brand">${{ $amount }}</h4>
                                </td>

                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down" onclick="updateQuantity('down', {{ $item->product->id }}); return false;">
                                                <i class="fi-rs-angle-small-down"></i>
                                            </a>
                                            <input type="text" name="quantity" id="quantity-{{ $item->product->id }}"
                                                    class="qty-val" value="{{ $item->quantity }}"
                                                    min="1" data-available-qty="{{ $item->product->product_qty }}" readonly>
                                            <a href="#" class="qty-up" onclick="updateQuantity('up', {{ $item->product->id }}); return false;">
                                                <i class="fi-rs-angle-small-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <style>
                                    .qty-up.disabled, .qty-down.disabled {
                                        pointer-events: none;
                                        opacity: 0.5;
                                        cursor: not-allowed;
                                    }
                                </style>

                                <!-- Subtotal Column -->
                                <td class="price subtotal" data-title="Total" id="subtotal-{{ $item->id }}">
                                    <h4 class="text-brand">${{ $item->quantity * ($item->product->selling_price - $item->product->discount_price) }}</h4>
                                </td>

                                <!-- Color Column -->
                                <td class="text-center" data-title="Color">
                                    <span class="text-muted">{{ $item->color ?? '-' }}</span>
                                </td>

                                <!-- Size Column -->
                                <td class="text-center" data-title="Size">
                                    <span class="text-muted">{{ $item->size ?? '-' }}</span>
                                </td>

                                <td class="action text-center" data-title="Remove">
                                    <a href="{{ route('cart.remove', $item->id) }}" class="text-body">
                                        <i class="fi-rs-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

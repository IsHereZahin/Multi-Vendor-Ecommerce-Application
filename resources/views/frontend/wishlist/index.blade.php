@extends('frontend.components.master')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shop <span></span> Wishlist
                </div>
            </div>
        </div>
        <div class="container mb-30 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="mb-50">
                        <h1 class="heading-2 mb-10">Your Wishlist</h1>
                        <h6 class="text-body">There are <span class="text-brand">{{ $wishlistItems->count() }}</span> products in this list</h6>
                    </div>
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col" class="end">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wishlistItems as $item)
                                    <tr>
                                        <td class="image product-thumbnail p-2 pt-40">
                                            <img src="{{ asset($item->product->product_thumbnail) }}" class="p-2" alt="{{ $item->product->product_name }}">
                                        </td>
                                        <td class="product-des product-name">
                                            <h6>
                                                <a class="product-name mb-10 text-heading" href="{{ url('/product-details/'.$item->product->id.'/'.$item->product->product_slug) }}">
                                                    {{ $item->product->product_name }}
                                                </a>
                                            </h6>
                                            <div class="product-detail-rating">
                                                <div class="product-rate-cover text-end">
                                                    <div class="product-rate d-inline-block">
                                                        <!-- Calculate average rating from product reviews -->
                                                        <div class="product-rating" style="width: {{ $item->product->reviews->avg('rating') * 20 }}%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted">
                                                        <!-- Display total number of reviews -->
                                                        ({{ $item->product->reviews->count() }} reviews)
                                                    </span>
                                                </div>
                                            </div>

                                        </td>
                                        <!-- Price Column -->
                                        <td class="price" data-title="Price">
                                            @php
                                                $amount = $item->product->selling_price - $item->product->discount_price;
                                            @endphp
                                            <h4 class="text-brand">${{ $amount }}</h4>
                                        </td>
                                        <td class="detail-info" data-title="Stock">
                                            <span class="stock-status {{ $item->product->product_qty > 0 ? 'in-stock' : 'out-stock' }} mb-0">
                                                {{ $item->product->product_qty > 0 ? 'In Stock' : 'Out of Stock' }}
                                            </span>
                                        </td>
                                        <td class="text-right" data-title="Cart">
                                            @if($item->product->product_qty > 0)
                                                <a class="add btn btn-sm" href="javascript:void(0);" onclick="wishToCart({{ $item->product->id }})">
                                                    Add To Cart
                                                </a>
                                            @else
                                                @if($item->product->vendor->email)
                                                    <a class="contact btn btn-sm btn-secondary" href="mailto:{{ $item->product->vendor->email }}">
                                                        Contact Email
                                                    </a>
                                                @elseif($item->product->vendor->phone)
                                                    <a class="contact btn btn-sm btn-secondary" href="tel:{{ $item->product->vendor->phone }}">
                                                        Contact Phone
                                                    </a>
                                                @else
                                                    <button class="contact btn btn-sm btn-secondary" disabled style="cursor: not-allowed; background-color: #d6d6d6; border-color: #d6d6d6; color: #a1a1a1;">
                                                        Unavailable
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="action" data-title="Wishlist">
                                            @php
                                                $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                                    ->pluck('product_id')
                                                    ->contains($item->product->id);
                                            @endphp

                                            <a class="action-btn" href="javascript:void(0);"
                                                onclick="toggleWishlist({{ $item->product->id }})"
                                                id="wishlist-btn-{{ $item->product->id }}"
                                                data-product-id="{{ $item->product->id }}">
                                            <i class="fi-rs-heart {{ $isInWishlist ? 'text-danger' : '' }}"></i>
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
    </main>
@endsection

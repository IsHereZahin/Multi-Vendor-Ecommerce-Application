@extends('frontend.components.master')
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ '/' }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <a href="{{ '/all/vendors' }}" rel="nofollow"><span> All Vendors</span></a>
                <span>{{ $vendor->name ?? 'Unknown' }}</span>
            </div>
        </div>
    </div>

    <div class="container mb-30">
        <div class="archive-header-2 text-center pt-80 pb-50">
            <h1 class="display-2 mb-50">{{ $vendor->name ?? 'Unknown' }}</h1>
        </div>

        <div class="row flex-row-reverse">
            <div class="col-lg-4-5">
                <div class="shop-product-fillter">
                    <div class="totall-product">
                        @if ($productCount > 0)
                            <p>We found <strong class="text-brand">{{ $productCount ?? '0' }}</strong> items for you!</p>
                        @else
                            <h3 class="text-danger mb-3">No Items Found</h3>
                            <p>We did not find any items for you!</p>
                        @endif
                    </div>
                </div>

                <div class="row product-grid">
                    @foreach ($products as $product)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url('/product-details/' . $product->id . '/' . $product->product_slug) }}">
                                            <img class="default-img" src="{{ asset($product->product_thumbnail) }}"
                                                alt="" />
                                            @if ($product->multiImages->count() > 1)
                                                <img class="hover-img"
                                                    src="{{ asset($product->multiImages->skip(1)->first()->photo_name) }}"
                                                    alt="" />
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="#"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="#"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <!-- Add a unique identifier to each quick view button -->
                                        <a aria-label="Quick view" class="action-btn quick-view-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal{{ $product->id }}"><i
                                                class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        @php
                                            $amount = $product->selling_price - $product->discount_price;
                                            $discount = 100 - ($amount / $product->selling_price) * 100;
                                        @endphp

                                        @if ($product->discount_price == null)
                                            <span class="new">New</span>
                                        @else
                                            <span class="hot">Save {{ round($discount) }} %</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a
                                            href="{{ route('category.products', ['id' => $product->category->id, 'slug' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                                    </div>
                                    <h2><a
                                            href="{{ url('/product-details/' . $product->id . '/' . $product->product_slug) }}">{{ $product->product_name }}</a>
                                    </h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="#">{{ $product->vendor->name ?? 'Owner' }}</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        @if ($product->discount_price == null)
                                            <div class="product-price">
                                                <span>${{ $product->selling_price }}</span>
                                            </div>
                                        @else
                                            <div class="product-price">
                                                <span>${{ $amount }}</span>
                                                <span class="old-price">${{ $product->selling_price }}</span>
                                            </div>
                                        @endif
                                        <div class="add-cart">
                                            <a class="add" href="javascript:void(0);"
                                                onclick="quickAddToCart({{ $product->id }})">
                                                <i class="fi-rs-shopping-cart mr-5"></i>Add
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick view modal for each product -->
                        <div class="modal fade custom-modal" id="quickViewModal{{ $product->id }}" tabindex="-1"
                            aria-labelledby="quickViewModal{{ $product->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                                <div class="detail-gallery">
                                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                                    <!-- MAIN SLIDES -->
                                                    <div class="product-image-slider">
                                                        @foreach ($product->multiImages as $image)
                                                            <figure class="border-radius-10">
                                                                <img src="{{ asset($image->photo_name) }}"
                                                                    alt="product image" />
                                                            </figure>
                                                        @endforeach
                                                    </div>
                                                    <!-- THUMBNAILS -->
                                                    <div class="slider-nav-thumbnails">
                                                        @foreach ($product->multiImages as $image)
                                                            <div><img src="{{ asset($image->photo_name) }}"
                                                                    alt="product image" /></div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <!-- End Gallery -->
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="detail-info pr-30 pl-30">
                                                    <span class="stock-status out-stock">
                                                        @php
                                                            $amount =
                                                                $product->selling_price > 0
                                                                    ? $product->selling_price - $product->discount_price
                                                                    : 0;
                                                            $discount =
                                                                $product->selling_price > 0
                                                                    ? 100 - ($amount / $product->selling_price) * 100
                                                                    : 0;
                                                        @endphp

                                                        @if ($product->discount_price == null)
                                                            @if ($product->hot_deals == 1)
                                                                Hot
                                                            @elseif ($product->featured == 1)
                                                                Featured
                                                            @elseif ($product->special_offer == 1)
                                                                Special
                                                            @elseif ($product->special_deals == 1)
                                                                Special Deals
                                                            @endif
                                                        @else
                                                            <span class="hot">Save {{ round($discount) }} %</span>
                                                        @endif
                                                    </span>
                                                    <h3 class="title-detail"><a
                                                            href="{{ url('/product-details/' . $product->id . '/' . $product->product_slug) }}"
                                                            class="text-heading">{{ $product->product_name }}</a></h3>
                                                    <div class="product-detail-rating">
                                                        <div class="product-rate-cover text-end">
                                                            <div class="product-rate d-inline-block">
                                                                <div class="product-rating" style="width: 90%"></div>
                                                            </div>
                                                            <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                                        </div>
                                                    </div>

                                                    @php
                                                        $product_size = explode(',', $product->product_size);
                                                        $product_color = explode(',', $product->product_color);
                                                    @endphp

                                                    @if (!empty($product->product_size))
                                                        <div class="attr-detail attr-size mb-30">
                                                            <strong class="mr-10" style="width:50px;">Size : </strong>
                                                            <select class="form-control unicase-form-control"
                                                                id="sizeSelect_{{ $product->id }}">
                                                                @if (count($product_size) === 1)
                                                                    <option selected value="{{ $product_size[0] }}">
                                                                        {{ ucwords($product_size[0]) }}</option>
                                                                @else
                                                                    <option selected disabled>--Choose Size--</option>
                                                                    @foreach ($product_size as $size)
                                                                        <option value="{{ $size }}">
                                                                            {{ ucwords($size) }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    @endif

                                                    @if (!empty($product->product_color))
                                                        <div class="attr-detail attr-color mb-30">
                                                            <strong class="mr-10" style="width:50px;">Color: </strong>
                                                            <select class="form-control unicase-form-control"
                                                                id="colorSelect_{{ $product->id }}">
                                                                @if (count($product_color) === 1)
                                                                    <option selected value="{{ $product_color[0] }}">
                                                                        {{ ucwords($product_color[0]) }}</option>
                                                                @else
                                                                    <option selected disabled>--Choose Color--</option>
                                                                    @foreach ($product_color as $color)
                                                                        <option value="{{ $color }}">
                                                                            {{ ucwords($color) }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    @endif

                                                    <div class="clearfix product-price-cover">
                                                        <div class="product-price primary-color float-left">
                                                            <span
                                                                class="current-price text-brand">${{ $amount }}</span>
                                                            @if ($discount > 0)
                                                                <span>
                                                                    <span
                                                                        class="save-price font-md color3 ml-15">{{ round($discount) }}%
                                                                        Off</span>
                                                                    <span
                                                                        class="old-price font-md ml-15">${{ $product->selling_price }}</span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="detail-extralink mb-30">
                                                        <div class="detail-qty border radius">
                                                            <a href="#" class="qty-down"><i
                                                                    class="fi-rs-angle-small-down"></i></a>
                                                            <input type="text" name="quantity"
                                                                id="qty_{{ $product->id }}" class="qty-val"
                                                                value="1" min="1">
                                                            <a href="#" class="qty-up"><i
                                                                    class="fi-rs-angle-small-up"></i></a>
                                                        </div>
                                                        <div class="product-extra-link2">
                                                            <input type="hidden" id="product_id"
                                                                value="{{ $product->id }}">
                                                            <input type="hidden" id="product_qty_{{ $product->id }}"
                                                                value="{{ $product->product_qty }}">
                                                            <button type="submit" class="button button-add-to-cart"
                                                                onClick="addToCart(this, {{ $product->id }})">
                                                                <i class="fi-rs-shopping-cart"></i> Add to cart
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="font-xs">
                                                        <ul class="list-unstyled">
                                                            <li class="mb-3">
                                                                <strong>Vendor:</strong>
                                                                <span class="text-brand">
                                                                    <a href="{{ route('vendor.details', $product->vendor->id) }}"
                                                                        class="text-decoration-none">{{ $product->vendor->name }}</a>
                                                                </span>
                                                            </li>

                                                            @if ($product->created_at)
                                                                <li class="mb-3">
                                                                    <strong>Published On:</strong>
                                                                    <span
                                                                        class="text-brand">{{ $product->created_at->format('F j, Y') }}</span>
                                                                </li>
                                                            @endif

                                                            @if ($product->updated_at && $product->created_at != $product->updated_at)
                                                                <li class="mb-3">
                                                                    <strong>Last Modified:</strong>
                                                                    <span
                                                                        class="text-brand">{{ $product->updated_at->format('F j, Y') }}</span>
                                                                </li>
                                                            @endif

                                                            <li class="mb-3">
                                                                <strong>Stock:</strong>
                                                                <span class="stock-status"
                                                                    style="padding: 5px 15px; border-radius: 5px; font-weight: 500;
                                                            {{ $product->product_qty > 0 ? 'background-color: #d4edda; color: #155724;' : 'background-color: #f8d7da; color: #FF4C51;' }}">
                                                                    @if ($product->product_qty > 0)
                                                                        <strong>In Stack</strong>
                                                                    @else
                                                                        <strong>Out of Stock</strong>
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- Detail Info -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- End Product Grid -->
            </div>

            <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
                <div class="sidebar-widget widget-store-info mb-30 bg-3 border-0">
                    <div class="vendor-logo mb-30">
                        <img class="default-img"
                            src="{{ !empty($vendor->photo) ? url('upload/user/vendor/' . $vendor->photo) : url('adminbackend/assets/images/no_image.jpg') }}"
                            alt="" />
                    </div>
                    <div class="vendor-info">
                        <div class="product-category">
                            <span class="text-muted">Since {{ $vendor->vendor_join_year ?? 'Not found!' }}</span>
                        </div>
                        <h4 class="mb-5"><a href="#"
                                class="text-heading">{{ $vendor->name ?? 'Not found!' }}</a></h4>
                        <div class="product-rate-cover mb-15">
                            <div class="product-rate d-inline-block">
                                <div class="product-rating" style="width: 90%"></div>
                            </div>
                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                        </div>
                        <div class="vendor-des mb-30">
                            <p class="font-sm text-heading">{{ $vendor->vendor_short_info ?? 'Not found!' }}</p>
                        </div>
                        <div class="follow-social mb-20">
                            <h6 class="mb-15">Follow Us</h6>
                            <ul class="social-network">
                                <li class="hover-up">
                                    <a href="#"><img
                                            src="{{ asset('frontend/assets/imgs/theme/icons/social-tw.svg') }}"
                                            alt="" /></a>
                                </li>
                                <li class="hover-up">
                                    <a href="#"> <img
                                            src="{{ asset('frontend/assets/imgs/theme/icons/social-fb.svg') }}"
                                            alt="" /></a>
                                </li>
                                <li class="hover-up">
                                    <a href="#"><img
                                            src="{{ asset('frontend/assets/imgs/theme/icons/social-insta.svg') }}"
                                            alt="" /></a>
                                </li>
                                <li class="hover-up">
                                    <a href="#"><img
                                            src="{{ asset('frontend/assets/imgs/theme/icons/social-pin.svg') }}"
                                            alt="" /></a>
                                </li>
                            </ul>
                        </div>
                        <div class="vendor-info">
                            <ul class="font-sm mb-20">
                                <li><img class="mr-5"
                                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-location.svg') }}"
                                        alt="" /><strong>Address: </strong>
                                    <span>{{ $vendor->address ?? 'Not found!' }}</span></li>
                                <li><img class="mr-5"
                                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}"
                                        alt="" /><strong>Call
                                        Us:</strong><span>{{ $vendor->phone ?? 'Not found!' }}</span></li>
                            </ul>
                            <a href="#" class="btn btn-xs">Contact Seller <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Fillter By Price -->
            </div>
        </div>
    </div>
@endsection

@extends('frontend.components.master')
@section('content')
<div class="page-header mt-30 mb-50">
    <div class="container">
        <div class="archive-header">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    @php
                        $subcategoryId = request()->segment(2); // Get the subcategory ID from the URL
                        $subcategory = App\Models\SubCategory::find($subcategoryId); // Find the subcategory by ID
                    @endphp
                    @if($subcategory)
                        <h1 class="mb-15">{{ $subcategory->name }}</h1>
                        <div class="breadcrumb">
                            <a href="{{ '/' }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span>
                            @if($subcategory->category)
                                <a href="{{ route('category.products', ['id' => $subcategory->category->id, 'slug' => $subcategory->category->slug]) }}">{{ $subcategory->category->name }}</a>
                            @endif
                            <span></span> {{ $subcategory->name }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mb-30">
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
                                <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">
                                    <img class="default-img" src="{{ asset($product->product_thambnail) }}" alt=""/>
                                    @if ($product->multiImages->count() > 1)
                                        <img class="hover-img" src="{{ asset($product->multiImages->skip(1)->first()->photo_name) }}" alt="" />
                                    @endif
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Add To Wishlist" class="action-btn" href="#"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                <!-- Add a unique identifier to each quick view button -->
                                <a aria-label="Quick view" class="action-btn quick-view-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal{{ $product->id }}"><i class="fi-rs-eye"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                @php
                                    $amount = $product->selling_price - $product->discount_price;
                                    $discount = 100 - (($amount / $product->selling_price) * 100);
                                @endphp

                                @if ($product->discount_price == NULL)
                                    <span class="new">New</span>
                                @else
                                    <span class="hot">Save {{ round($discount) }} %</span>
                                @endif
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="#">{{ $product->subcategory->name }}</a>
                            </div>
                            <h2><a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">{{ $product->product_name }}</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div>
                                <span class="font-small text-muted">By <a href="#">{{ $product->vendor->name ?? 'Owner' }}</a></span>
                            </div>
                            <div class="product-card-bottom">
                                @if($product->discount_price == NULL)
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
                                    <a class="add" href="#"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick view modal for each product -->
                <div class="modal fade custom-modal" id="quickViewModal{{ $product->id }}" tabindex="-1" aria-labelledby="quickViewModal{{ $product->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                        <div class="detail-gallery">
                                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                            <!-- MAIN SLIDES -->
                                            <div class="product-image-slider">
                                                @foreach($product->multiImages as $image)
                                                <figure class="border-radius-10">
                                                    <img src="{{ asset($image->photo_name) }}" alt="product image" />
                                                </figure>
                                                @endforeach
                                            </div>
                                            <!-- THUMBNAILS -->
                                            <div class="slider-nav-thumbnails">
                                                @foreach($product->multiImages as $image)
                                                <div><img src="{{ asset($image->photo_name) }}" alt="product image" /></div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- End Gallery -->
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-30 pl-30">
                                            <span class="stock-status out-stock">
                                                @php
                                                    $amount = $product->selling_price - $product->discount_price;
                                                    $discount = 100 - (($amount / $product->selling_price) * 100);
                                                @endphp

                                                @if ($product->discount_price == NULL)
                                                    @if ($product->hot_deals == 1)Hot
                                                    @elseif ($product->featured == 1)Featured
                                                    @elseif ($product->special_offer == 1)Special
                                                    @elseif ($product->special_deals == 1)Special Deals
                                                    @else
                                                    @endif
                                                @else
                                                    <span class="hot">Save {{ round($discount) }} %</span>
                                                @endif
                                            </span>
                                            <h3 class="title-detail"><a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}" class="text-heading">{{ $product->product_name }}</a></h3>
                                            <div class="product-detail-rating">
                                                <div class="product-rate-cover text-end">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                                </div>
                                            </div>
                                            <div class="clearfix product-price-cover">
                                                <div class="product-price primary-color float-left">
                                                    <span class="current-price text-brand">${{ $amount }}</span>
                                                    @if ($discount > 0)
                                                        <span>
                                                            <span class="save-price font-md color3 ml-15">{{ round($discount) }}% Off</span>
                                                            <span class="old-price font-md ml-15">${{ $product->selling_price }} </span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="detail-extralink mb-30">
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                                <div class="product-extra-link2">
                                                    <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                                </div>
                                            </div>
                                            <div class="font-xs">
                                                <ul>
                                                    <li class="mb-5">Vendor: <span class="text-brand">{{ $product->vendor->name }}</span></li>
                                                    @if ($product->created_at)
                                                        <li class="mb-5">Created: <span class="text-brand">{{ $product->created_at->format('F j, Y') }}</span></li>
                                                    @endif
                                                    @if ($product->updated_at && $product->created_at != $product->updated_at)
                                                        <li class="mb-5">Last Updated: <span class="text-brand">{{ $product->updated_at->format('F j, Y') }}</span></li>
                                                    @endif
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

        </div>
        <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
        
        <div class="sidebar-widget widget-category-2 mb-30">
                <h5 class="section-title style-1 mb-30">SubCategory</h5>
                @php
                    $subcategories = App\Models\SubCategory::has('products')->withCount('products')->get();
                @endphp
                <ul>
                    @foreach ($subcategories as $subcategory)
                        <li>
                            <a href="{{ route('subcategory.products', ['id' => $subcategory->id, 'slug' => $subcategory->slug]) }}">
                                @if($subcategory->category->image)
                                    <img src="{{ asset('upload/categories/'.$subcategory->category->image) }}" alt="{{ $subcategory->category->name }}" />
                                @else
                                    <img src="{{ asset('default-category-image.jpg') }}" alt="Default Image" />
                                @endif
                                {{ $subcategory->name }} ({{ $subcategory->products_count }})
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
            <!-- Product sidebar Widget -->
            <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
                <h5 class="section-title style-1 mb-30">New products</h5>

                @php
                    $newproducts = App\Models\Product::latest()->take(5)->get();
                @endphp

                @foreach ($newproducts as $product)
                <div class="single-post clearfix">
                    <div class="image">
                    <img src="{{ asset($product->product_thambnail) }}" alt="{{ $product->product_name }}" onError="this.onerror=null; this.src='path/to/default-image.jpg';">
                    </div>
                    <div class="content pt-10">
                    <h6><a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">{{ $product->product_name }}</a></h6>
                    <p class="price mb-0 mt-5">${{ $product->selling_price }}</p>
                    <div class="product-rate">
                        <div class="product-rating" style="width: {{ rand(0, 100) }}%"> </div>
                    </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none">
                <img src="{{ asset('frontend/assets/imgs/banner/banner-11.png') }}" alt="" />
                <div class="banner-text">
                    <span>Oganic</span>
                    <h4>
                        Save 17% <br />
                        on <span class="text-brand">Oganic</span><br />
                        Juice
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

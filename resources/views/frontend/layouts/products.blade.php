<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3> New Products </h3>
            <ul class="nav nav-tabs links" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">All</button>
                </li>
                @php
                    $products = App\Models\Product::where('status', 1)->orderBy('id', 'ASC')->latest()->limit(10)->get();

                    // Retrieve unique category IDs from the fetched products
                    $categoryIds = $products->pluck('category_id')->unique();

                    // Fetch categories based on the retrieved IDs
                    $categories = App\Models\Category::whereIn('id', $categoryIds)->get();
                @endphp

                @if ($categories->isNotEmpty())
                    @foreach ($categories as $category)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="nav-tab-{{ $category->id }}" data-bs-toggle="tab" href="#category{{ $category->id }}" role="tab" aria-controls="tab-{{ $category->id }}" aria-selected="false">{{ $category->name }}</a>
                        </li>
                    @endforeach
                @else
                    <p>No categories found.</p>
                @endif
            </ul>
        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @foreach($products as $product)
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
                                        <a href="#">{{ $product->category->name }}</a>
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
                <!--End product-grid-4-->
            </div>

            @foreach($categories as $category)
                <div class="tab-pane fade" id="category{{ $category->id }}" role="tabpanel" aria-labelledby="nav-tab-{{ $category->id }}">
                    <div class="row product-grid-4">
                        @php
                            $catwiseProduct = App\Models\Product::where('category_id',$category->id)->orderBy('id','DESC')->get();
                        @endphp

                            @foreach($catwiseProduct as $product)
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
                                            <a aria-label="Quick view" class="action-btn quick-view-btn" data-bs-toggle="modal" data-bs-target="#quickViewModalView{{ $product->id }}"><i class="fi-rs-eye"></i></a>
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
                                            <a href="#">{{ $product->category->name }}</a>
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
                            <div class="modal fade custom-modal" id="quickViewModalView{{ $product->id }}" tabindex="-1" aria-labelledby="quickViewModalView{{ $product->id }}" aria-hidden="true">
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
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="section-padding pb-5">
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn">
            <h3 class=""> Featured Products </h3>
        </div>
        <div class="row">
            <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn">
                <div class="banner-img style-2">
                    <div class="banner-text">
                        <h2 class="mb-100">Bring nature into your home</h2>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                <div class="tab-content" id="myTabContent-1">
                    <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                        <div class="carausel-4-columns-cover arrow-center position-relative">
                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-arrows"></div>
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                @php
                                    $productsdata = App\Models\Product::where('status', 1)->orderBy('id', 'ASC')->latest()->limit(10)->get();
                                @endphp
                                @foreach ($productsdata as $product)
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}" tabindex="0">
                                                    <img class="default-img" src="{{ asset($product->product_thambnail) }}" alt=""/>
                                                    @if ($product->multiImages->count() > 1)
                                                        <img class="hover-img" src="{{ asset($product->multiImages->skip(1)->first()->photo_name) }}" alt="" />
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Full view" class="action-btn small hover-up" href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}"> <i class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
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
                                                <a href="#">{{ $product->category->name }}</a>
                                            </div>
                                            <h2><a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">{{ $product->product_name }}</a></h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10">
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
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                @php
                                                    $randomMultiplier = mt_rand(100, 200) / 100;
                                                    $product_stock = round($product->product_qty * $randomMultiplier);
                                                    $soldPercentage = ($product->product_qty / $product_stock) * 100;
                                                @endphp
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $soldPercentage }}%" aria-valuemin="0" aria-valuemax="{{ $product_stock }}"></div>
                                                </div>
                                                <span class="font-xs text-heading"> Sold: {{ $product->product_qty }}/{{ $product_stock }}</span>
                                            </div>
                                            <a href="#" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Featured Products-->


<!--Special Products-->
<section class="section-padding mb-30">
    <div class="container">
        <div class="row">
            @php
                $hotDeals = App\Models\Product::whereNotNull('hot_deals')->limit(4)->get();
                $featured = App\Models\Product::whereNotNull('featured')->limit(4)->get();
                $specialOffer = App\Models\Product::whereNotNull('special_offer')->limit(4)->get();
                $specialDeals = App\Models\Product::whereNotNull('special_deals')->limit(4)->get();
            @endphp
            @if($hotDeals->isNotEmpty())
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp" data-wow-delay="0">
                    <h4 class="section-title style-1 mb-30 animated animated"> Hot Deals </h4>
                    <div class="product-list-small animated animated">
                        @foreach($hotDeals as $product)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">
                                    <img class="default-img" src="{{ asset($product->product_thambnail) }}" alt=""/>
                                </a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">{{ $product->product_name }}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 70%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                @php
                                    $priceDifference = $product->selling_price - $product->discount_price;
                                @endphp
                                @if($product->discount_price == NULL)
                                    <div class="product-price">
                                        <span>${{ $product->selling_price }}</span>
                                    </div>
                                @else
                                    <div class="product-price">
                                        <span>${{ $priceDifference }}</span>
                                        <span class="old-price">${{ $product->selling_price }}</span>
                                    </div>
                                @endif
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($featured->isNotEmpty())
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp" data-wow-delay="0">
                    <h4 class="section-title style-1 mb-30 animated animated"> Featured </h4>
                    <div class="product-list-small animated animated">
                        @foreach($featured as $product)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">
                                    <img class="default-img" src="{{ asset($product->product_thambnail) }}" alt=""/>
                                </a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">{{ $product->product_name }}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 70%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                @php
                                    $priceDifference = $product->selling_price - $product->discount_price;
                                @endphp
                                @if($product->discount_price == NULL)
                                    <div class="product-price">
                                        <span>${{ $product->selling_price }}</span>
                                    </div>
                                @else
                                    <div class="product-price">
                                        <span>${{ $priceDifference }}</span>
                                        <span class="old-price">${{ $product->selling_price }}</span>
                                    </div>
                                @endif
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($specialOffer->isNotEmpty())
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp" data-wow-delay="0">
                    <h4 class="section-title style-1 mb-30 animated animated"> Special Offer </h4>
                    <div class="product-list-small animated animated">
                        @foreach($specialOffer as $product)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">
                                    <img class="default-img" src="{{ asset($product->product_thambnail) }}" alt=""/>
                                </a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">{{ $product->product_name }}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 70%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                @php
                                    $priceDifference = $product->selling_price - $product->discount_price;
                                @endphp
                                @if($product->discount_price == NULL)
                                    <div class="product-price">
                                        <span>${{ $product->selling_price }}</span>
                                    </div>
                                @else
                                    <div class="product-price">
                                        <span>${{ $priceDifference }}</span>
                                        <span class="old-price">${{ $product->selling_price }}</span>
                                    </div>
                                @endif
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($specialDeals->isNotEmpty())
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp" data-wow-delay="0">
                    <h4 class="section-title style-1 mb-30 animated animated"> Special Deals </h4>
                    <div class="product-list-small animated animated">
                        @foreach($specialDeals as $product)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">
                                    <img class="default-img" src="{{ asset($product->product_thambnail) }}" alt=""/>
                                </a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{ url('/product-details/'.$product->id.'/'.$product->product_slug) }}">{{ $product->product_name }}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 70%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                @php
                                    $priceDifference = $product->selling_price - $product->discount_price;
                                @endphp
                                @if($product->discount_price == NULL)
                                    <div class="product-price">
                                        <span>${{ $product->selling_price }}</span>
                                    </div>
                                @else
                                    <div class="product-price">
                                        <span>${{ $priceDifference }}</span>
                                        <span class="old-price">${{ $product->selling_price }}</span>
                                    </div>
                                @endif
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>
<!--End Special Products-->


<!-- Category Product -->
@php
    $categories = App\Models\Category::withCount('products')->get();
    // Filter categories with more than 4 products
    $categoriesWithMoreThanFourProducts = $categories->filter(function ($category) {
        return $category->products_count > 4;
    });
@endphp
@foreach ($categoriesWithMoreThanFourProducts as $category)
    <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>{{ $category->name }} Category</h3>
            </div>
            <!--End nav-tabs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">

                        @foreach ($category->products->take(5) as $product)
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
                                        <a href="#">{{ $product->category->name }}</a>
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
                    <!--End product-grid-4-->
                </div>
            </div>
            <!--End tab-content-->
        </div>
    </section>
@endforeach
<!--End Category Product -->

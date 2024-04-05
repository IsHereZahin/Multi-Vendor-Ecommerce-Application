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
                                                    <h3 class="title-detail"><a href="shop-product-right.html" class="text-heading">{{ $product->product_name }}</a></h3>
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
                                                        <h3 class="title-detail"><a href="shop-product-right.html" class="text-heading">{{ $product->product_name }}</a></h3>
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

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
                    @foreach ($products as $product)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="#">
                                            <img class="default-img" src="{{ asset($product->product_thambnail) }}" alt=""/>
                                            @if ($product->multiImages->count() > 1)
                                                <img class="hover-img" src="{{ asset($product->multiImages->skip(1)->first()->photo_name) }}" alt="" />
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="#"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        @php
                                            $amount = $product->selling_price - $product->discount_price;
                                            $discount = ($amount / $product->selling_price) * 100;
                                        @endphp

                                        @if ($product->discount_price == NULL)
                                            @if ($product->featured == '1' || $product->special_offer == '1' || $product->special_deals == '1' || $product->hot_deals == '1')
                                                <span class="new">Special</span>
                                            @endif
                                        @else
                                            <span class="hot"> {{ round($discount) }} %</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="#">{{ $product->category->name }}</a>
                                    </div>
                                    <h2><a href="#">{{ $product->product_name }}</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a href="#">{{ $product->vendor->name ?? 'Owner' }}</a></span> <br>
                                        <span class="font-small text-muted">{{ $product->brand->name ?? 'Unknown Brand' }}</span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>${{ $product->selling_price - $product->discount_price ?? 0 }}</span>
                                            @if ($product->discount_price > 0)
                                                <span class="old-price">${{ $product->selling_price }}</span>
                                            @endif
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="#"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
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

                        @forelse($catwiseProduct as $product)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="#">
                                                <img class="default-img" src="{{ asset($product->product_thambnail) }}" alt=""/>
                                                @if ($product->multiImages->count() > 1)
                                                    <img class="hover-img" src="{{ asset($product->multiImages->skip(1)->first()->photo_name) }}" alt="" />
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="#"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            @php
                                                $amount = $product->selling_price - $product->discount_price;
                                                $discount = ($amount / $product->selling_price) * 100;
                                            @endphp

                                            @if ($product->discount_price == NULL)
                                                <span class="new">New</span>
                                            @else
                                                <span class="hot"> {{ round($discount) }} %</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="#">{{ $product->category->name }}</a>
                                        </div>
                                        <h2><a href="#">{{ $product->product_name }}</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            @if($product->vendor_id == NULL)
                                                <span class="font-small text-muted">By <a href="#">Owner</a></span>
                                            @else
                                                <span class="font-small text-muted">By <a href="#">{{ $product->vendor->name }}</a></span>
                                            @endif
                                        </div>
                                        <div class="product-card-bottom">
                                            @if($product->discount_price == NULL)
                                                <div class="product-price">
                                                    <span>${{ $product->selling_price }}</span>
                                                </div>
                                            @else
                                                <div class="product-price">
                                                    <span>${{ $product->discount_price }}</span>
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
                        @empty
                            <h5 class="text-danger"> No Product Found </h5>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

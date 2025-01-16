@extends('frontend\components\master')
@section('content')

@section('title')
{{ $product->product_name }}
@endsection

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ '/' }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> <a
                    href="{{ route('category.products', ['id' => $product->category->id, 'slug' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                <span></span><a
                    href="{{ route('subcategory.products', ['id' => $product->subcategory->id, 'slug' => $product->subcategory->slug]) }}">{{ $product->subcategory->name }}</a>
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <div class="product-detail accordion-detail">
                    <div class="row mb-50 mt-30">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider">
                                    @foreach ($product->multiImages as $image)
                                        <figure class="border-radius-10">
                                            <img src="{{ asset($image->photo_name) }}" alt="product image" />
                                        </figure>
                                    @endforeach
                                </div>
                                <!-- THUMBNAILS -->
                                <div class="slider-nav-thumbnails">
                                    @foreach ($product->multiImages as $image)
                                        <div><img src="{{ asset($image->photo_name) }}" alt="product image" /></div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- End Gallery -->
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                @if ($product->product_qty > 0)
                                    <span class="stock-status in-stock">In Stock</span>
                                @else
                                    <span class="stock-status out-stock">Out Stock</span>
                                @endif
                                <h2 class="title-detail">{{ $product->product_name }}</h2>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <!-- Calculate average rating from product reviews -->
                                            <div class="product-rating"
                                                style="width: {{ $product->reviews->where('status', 1)->avg('rating') * 20 }}%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            <!-- Display total number of reviews -->
                                            ({{ $product->reviews->where('status', 1)->count() }} reviews)
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">

                                        @php
                                            $amount = $product->selling_price - $product->discount_price;
                                            $discount = 100 - ($amount / $product->selling_price) * 100;
                                        @endphp

                                        <span class="current-price text-brand">${{ $amount }}</span>
                                        @if ($discount > 0)
                                            <span>
                                                <span class="save-price font-md color3 ml-15">{{ round($discount) }}%
                                                    Off</span>
                                                <span class="old-price font-md ml-15">${{ $product->selling_price }}
                                                </span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="short-desc mb-30">
                                    <p class="font-lg">{{ $product->short_descp }}</p>
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
                                                    <option value="{{ $size }}">{{ ucwords($size) }}</option>
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
                                                    <option value="{{ $color }}">{{ ucwords($color) }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                @endif

                                <div class="detail-extralink mb-30">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <input type="text" name="quantity" id="qty_{{ $product->id }}" class="qty-val"
                                            value="1" min="1">
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <input type="hidden" id="product_id" value="{{ $product->id }}">
                                        <input type="hidden" id="product_qty_{{ $product->id }}"
                                            value="{{ $product->product_qty }}">
                                        <button type="submit" class="button button-add-to-cart"
                                            onClick="addToCart(this, {{ $product->id }})">
                                            <i class="fi-rs-shopping-cart"></i> Add to cart
                                        </button>
                                    </div>
                                </div>
                                @if ($product->vendor_id == null)
                                    <h6> Sold By <a href="#"> <span class="text-danger"> Owner </span> </a></h6>
                                @else
                                    <h6> Sold By <a href="{{ route('vendor.details', $product->vendor->id) }}"> <span
                                                class="text-danger"> {{ $product['vendor']['name'] }} </span></a></h6>
                                @endif
                                <hr>

                                <div class="font-xs">
                                    <ul class="mr-50 float-start">
                                        <li class="mb-5">Brand: <a
                                                href="{{ route('brand.show', ['id' => $product->brand->id]) }}"><span
                                                    class="text-brand">{{ $product['brand']['name'] }}</span></a></li>
                                        <li class="mb-5">Category:<span class="text-brand"><a
                                                    href="{{ route('category.products', ['id' => $product->category->id, 'slug' => $product->category->slug]) }}">{{ $product['category']['name'] }}</a></span>
                                        </li>
                                        @if ($product->created_at)
                                            <li class="mb-5">Created: <span
                                                    class="text-brand">{{ $product->created_at->format('M j.Y') }}</span>
                                            </li>
                                        @endif
                                        @if ($product->updated_at && $product->created_at != $product->updated_at)
                                            <li class="mb-5">Last Updated: <span
                                                    class="text-brand">{{ $product->updated_at->format('M j.Y') }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                    <ul class="float-start">
                                        <li>SubCategory: <span class="text-brand"><a
                                                    href="{{ route('subcategory.products', ['id' => $product->subcategory->id, 'slug' => $product->subcategory->slug]) }}">{{ $product['subcategory']['name'] }}</a>
                                            </span></li>
                                        <li class="mb-5">Product Code: <a
                                                href="#">{{ $product->product_code }}</a></li>
                                        @php
                                            $tags = explode(',', $product->product_tags ?? '');
                                        @endphp

                                        @if (!empty($product->tags))
                                            <li class="mb-5">Tags:
                                                @foreach ($tags as $index => $tag)
                                                    <a href="#" rel="tag">{{ ucfirst(trim($tag)) }}</a>
                                                    @if ($index < count($tags) - 1)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </li>
                                        @endif
                                        <li>Stock:<span class="in-stock text-brand ml-5">{{ $product->product_qty }} Items
                                                In Stock</span></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Detail Info -->
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="tab-style3">
                            <ul class="nav nav-tabs text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                        href="#Description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                        href="#Additional-info">Additional info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab"
                                        href="#Vendor-info">Vendor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab"
                                        href="#Reviews">Reviews({{ $product->reviews->where('status', 1)->count() }})</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <div class="">
                                        {!! $product->long_descp !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Additional-info">
                                    <table class="font-md">
                                        <tbody>
                                            <tr class="stand-up">
                                                <th>Stand Up</th>
                                                <td>
                                                    <p>35″L x 24″W x 37-45″H(front to back wheel)</p>
                                                </td>
                                            </tr>
                                            <tr class="folded-wo-wheels">
                                                <th>Folded (w/o wheels)</th>
                                                <td>
                                                    <p>32.5″L x 18.5″W x 16.5″H</p>
                                                </td>
                                            </tr>
                                            <tr class="folded-w-wheels">
                                                <th>Folded (w/ wheels)</th>
                                                <td>
                                                    <p>32.5″L x 24″W x 18.5″H</p>
                                                </td>
                                            </tr>
                                            <tr class="door-pass-through">
                                                <th>Door Pass Through</th>
                                                <td>
                                                    <p>24</p>
                                                </td>
                                            </tr>
                                            <tr class="frame">
                                                <th>Frame</th>
                                                <td>
                                                    <p>Aluminum</p>
                                                </td>
                                            </tr>
                                            <tr class="weight-wo-wheels">
                                                <th>Weight (w/o wheels)</th>
                                                <td>
                                                    <p>20 LBS</p>
                                                </td>
                                            </tr>
                                            <tr class="weight-capacity">
                                                <th>Weight Capacity</th>
                                                <td>
                                                    <p>60 LBS</p>
                                                </td>
                                            </tr>
                                            <tr class="width">
                                                <th>Width</th>
                                                <td>
                                                    <p>24″</p>
                                                </td>
                                            </tr>
                                            <tr class="handle-height-ground-to-handle">
                                                <th>Handle height (ground to handle)</th>
                                                <td>
                                                    <p>37-45″</p>
                                                </td>
                                            </tr>
                                            <tr class="wheels">
                                                <th>Wheels</th>
                                                <td>
                                                    <p>12″ air / wide track slick tread</p>
                                                </td>
                                            </tr>
                                            <tr class="seat-back-height">
                                                <th>Seat back height</th>
                                                <td>
                                                    <p>21.5″</p>
                                                </td>
                                            </tr>
                                            <tr class="head-room-inside-canopy">
                                                <th>Head room (inside canopy)</th>
                                                <td>
                                                    <p>25″</p>
                                                </td>
                                            </tr>
                                            <tr class="pa_color">
                                                <th>Color</th>
                                                <td>
                                                    <p>Black, Blue, Red, White</p>
                                                </td>
                                            </tr>
                                            <tr class="pa_size">
                                                <th>Size</th>
                                                <td>
                                                    <p>M, S</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="Vendor-info">
                                    <div class="vendor-logo d-flex mb-30">
                                        <div class="vendor-image">
                                            <img class="default-img"
                                                src="{{ !empty($product->vendor->photo) ? url('upload/user/vendor/' . $product->vendor->photo) : url('adminbackend/assets/images/no_image.jpg') }}"
                                                alt="Vendor Logo" width="60" height="60" />
                                        </div>
                                        <div class="vendor-details ml-15">
                                            <h6 class="vendor-name">
                                                <a
                                                    href="{{ route('vendor.details', $product->vendor->id) }}">{{ $product->vendor->name ?? 'Owner' }}</a>
                                            </h6>
                                            <div class="product-detail-rating">
                                                <div class="product-rate-cover text-end">
                                                    <div class="product-rate d-inline-block">
                                                        <!-- Calculate average rating from product reviews -->
                                                        <div class="product-rating"
                                                            style="width: {{ $product->reviews->where('status', 1)->avg('rating') * 20 }}%">
                                                        </div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted">
                                                        <!-- Display total number of reviews -->
                                                        ({{ $product->reviews->where('status', 1)->count() }} reviews)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="contact-infor mb-50">
                                        <li>
                                            <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-location.svg') }}"
                                                alt="Location Icon" />
                                            <strong>Address: </strong>
                                            <span>{{ $product->vendor->address ?? 'Not detected' }}</span>
                                        </li>
                                        <li>
                                            <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}"
                                                alt="Contact Icon" />
                                            <strong>Contact Seller:</strong>
                                            <span>{{ $product->vendor->phone ?? 'No phone number!' }}</span>
                                        </li>
                                        <li>
                                            <span>
                                                @php
                                                    // Get the current year
                                                    $currentYear = date('Y');

                                                    // Get the vendor's join year
                                                    $joinYear = $product->vendor->vendor_join_year ?? null;

                                                    // Calculate the number of years since the vendor joined
                                                    $yearsSinceJoin = $joinYear ? $currentYear - $joinYear : null;
                                                @endphp
                                                <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-clock.svg') }}"
                                                    alt="Contact Icon" />
                                                <strong>Vendor since:</strong>
                                                @if ($yearsSinceJoin !== null)
                                                    @if ($yearsSinceJoin === 0)
                                                        <span class="vendor-since"> this year</span>
                                                    @elseif($yearsSinceJoin === 1)
                                                        <span class="vendor-since"> last year</span>
                                                    @else
                                                        <span class="vendor-since"> {{ $yearsSinceJoin }} years ago</span>
                                                    @endif
                                                @else
                                                    <span class="vendor-since"> unknown</span>
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                    <div class="d-flex mb-55">
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Rating</p>
                                            <h4 class="mb-0">92%</h4>
                                        </div>
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Ship on time</p>
                                            <h4 class="mb-0">100%</h4>
                                        </div>
                                        <div>
                                            <p class="text-brand font-xs">Chat response</p>
                                            <h4 class="mb-0">89%</h4>
                                        </div>
                                    </div>
                                    <p>{{ $product->vendor->vendor_short_info ?? '' }}</p>
                                </div>
                                <div class="tab-pane fade" id="Reviews">
                                    <!--Comments-->
                                    <div class="comments-area">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4 class="mb-30">Customer questions & answers</h4>
                                                <div class="comment-list">
                                                    @php
                                                        $reviews = $product->reviews()->where('status', 1)->get();
                                                    @endphp
                                                    @foreach ($reviews as $review)
                                                        <div class="single-comment justify-content-between d-flex mb-30">
                                                            <div class="user justify-content-between d-flex">
                                                                <div
                                                                    class="thumb text-center d-flex flex-column align-items-center">
                                                                    <img src="{{ !empty($review->user->photo) ? url('upload/user/user/' . $review->user->photo) : url('adminbackend/assets/images/no_image.jpg') }}"
                                                                        alt="{{ $review->user->name }}"
                                                                        class="img-fluid rounded-circle"
                                                                        style="width: 50px; height: 50px;">
                                                                    <span
                                                                        class="font-heading text-brand mt-2">{{ $review->user->name }}</span>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="d-flex justify-content-between mb-10">
                                                                        <div class="d-flex align-items-center">
                                                                            <span
                                                                                class="font-xs text-muted">{{ $review->created_at->format('F j, Y \a\t g:i a') }}</span>
                                                                        </div>
                                                                        <div class="product-rate d-inline-block">
                                                                            <div class="product-rating"
                                                                                style="width: {{ $review->rating * 20 }}%">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-10">{{ $review->comment }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <h4 class="mb-30">Customer reviews</h4>

                                                @php
                                                    // Get all reviews for the product
                                                    $reviews = $product->reviews;
                                                    $totalReviews = $reviews ? $reviews->count() : 0; // Safely count reviews
                                                    $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0; // Safely calculate average rating

                                                    // Count ratings for each star (1-5 stars)
                                                    $starCounts = [
                                                        1 => $reviews ? $reviews->where('rating', 1)->count() : 0,
                                                        2 => $reviews ? $reviews->where('rating', 2)->count() : 0,
                                                        3 => $reviews ? $reviews->where('rating', 3)->count() : 0,
                                                        4 => $reviews ? $reviews->where('rating', 4)->count() : 0,
                                                        5 => $reviews ? $reviews->where('rating', 5)->count() : 0,
                                                    ];
                                                @endphp

                                                <div class="d-flex mb-30">
                                                    <div class="product-rate d-inline-block mr-15">
                                                        <div class="product-rating"
                                                            style="width: {{ ($averageRating / 5) * 100 }}%"></div>
                                                    </div>
                                                    <h6>{{ number_format($averageRating, 1) }} out of 5</h6>
                                                </div>

                                                @foreach ($starCounts as $star => $count)
                                                    @php
                                                        $percentage =
                                                            $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                                    @endphp
                                                    <div class="progress">
                                                        <span>{{ $star }} star</span>
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $percentage }}%"
                                                            aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                            aria-valuemax="100">{{ number_format($percentage, 1) }}%</div>
                                                    </div>
                                                @endforeach

                                                <!-- Explanation link -->
                                                <a href="#" class="font-xs text-muted"
                                                    id="ratingCalculationLink">How are ratings calculated?</a>

                                                <!-- Explanation section (hidden by default) -->
                                                <div id="ratingExplanation" style="display: none;">
                                                    <p><strong>Ratings Calculation:</strong></p>
                                                    <p>The ratings for this product are based on customer feedback. Here's
                                                        how they are calculated:</p>
                                                    <ul>
                                                        <li><strong>Average Rating:</strong> This is the average of all the
                                                            ratings submitted by customers. Each rating is a number between
                                                            1 and 5, and the average is calculated by adding up all the
                                                            ratings and dividing by the total number of reviews.</li>
                                                        <li><strong>Percentage of Each Rating (1-5 stars):</strong> This
                                                            shows the percentage of customers who rated the product with
                                                            each specific star value. For example, if 50% of customers gave
                                                            the product a 5-star rating, the progress bar for 5 stars will
                                                            show 50%.</li>
                                                    </ul>
                                                </div>

                                                <!-- JavaScript to toggle the explanation -->
                                                <script>
                                                    document.getElementById('ratingCalculationLink').addEventListener('click', function(event) {
                                                        event.preventDefault(); // Prevent the default link behavior

                                                        var explanation = document.getElementById('ratingExplanation');
                                                        if (explanation.style.display === 'none') {
                                                            explanation.style.display = 'block'; // Show the explanation
                                                        } else {
                                                            explanation.style.display = 'none'; // Hide the explanation
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>

                                    <!--comment form-->
                                    <div class="comment-form">
                                        <h4 class="mb-15">Add a review</h4>
                                        @guest
                                            <p class="text-danger">You must be logged in to add a review.</p>
                                            <a href="{{ route('login') }}">
                                                <button class="btn btn-primary">Login here</button>
                                            </a>
                                        @else
                                            @php
                                                // Check if the user has already submitted a review for this product
                                                $existingReview = App\Models\Review::where('product_id', $product->id)
                                                    ->where('user_id', Auth::user()->id)
                                                    ->first();
                                            @endphp

                                            @if ($existingReview)
                                                <p class="text-warning">You have already submitted a review for this product.
                                                </p>
                                            @else
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-12">
                                                        <form class="form-contact comment_form"
                                                            action="{{ route('reviews.store') }}" method="POST"
                                                            id="commentForm">
                                                            @csrf
                                                            <!-- Hidden input fields for product_id, user_id, and vendor_id -->
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::user()->id }}">
                                                            <input type="hidden" name="vendor_id"
                                                                value="{{ $product->vendor_id }}">

                                                            <div class="d-inline-block mb-30">
                                                                <!-- Star Rating (1 to 5 stars) -->
                                                                <div class="product-rating" style="width: 0%"></div>
                                                                <div class="stars">
                                                                    <span data-value="1" class="star">&#9733;</span>
                                                                    <span data-value="2" class="star">&#9733;</span>
                                                                    <span data-value="3" class="star">&#9733;</span>
                                                                    <span data-value="4" class="star">&#9733;</span>
                                                                    <span data-value="5" class="star">&#9733;</span>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                            placeholder="Write Comment"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <input type="hidden" name="rating" id="rating"
                                                                    value="0"> <!-- Hidden field for rating -->
                                                                <button type="submit"
                                                                    class="button button-contactForm">Submit Review</button>
                                                            </div>
                                                        </form>

                                                        <!-- Styles for Stars -->
                                                        <style>
                                                            .stars {
                                                                font-size: 25px;
                                                                color: #ccc;
                                                                cursor: pointer;
                                                                display: inline-flex;
                                                            }

                                                            .star {
                                                                margin-right: 5px;
                                                            }

                                                            .star:hover,
                                                            .star.selected {
                                                                color: gold;
                                                            }
                                                        </style>

                                                        <!-- JavaScript for Star Rating Functionality -->
                                                        <script>
                                                            const stars = document.querySelectorAll('.star');
                                                            const ratingInput = document.getElementById('rating'); // Hidden rating input
                                                            let selectedRating = 0;

                                                            stars.forEach(star => {
                                                                star.addEventListener('click', function() {
                                                                    selectedRating = parseInt(this.getAttribute('data-value'));
                                                                    ratingInput.value = selectedRating; // Update hidden input with selected rating
                                                                    updateRating();
                                                                });

                                                                star.addEventListener('mouseover', function() {
                                                                    const hoverValue = parseInt(this.getAttribute('data-value'));
                                                                    highlightStars(hoverValue);
                                                                });

                                                                star.addEventListener('mouseleave', function() {
                                                                    highlightStars(selectedRating);
                                                                });
                                                            });

                                                            function highlightStars(rating) {
                                                                stars.forEach(star => {
                                                                    if (parseInt(star.getAttribute('data-value')) <= rating) {
                                                                        star.style.color = 'gold';
                                                                    } else {
                                                                        star.style.color = '#ccc';
                                                                    }
                                                                });
                                                            }

                                                            function updateRating() {
                                                                stars.forEach(star => {
                                                                    if (parseInt(star.getAttribute('data-value')) <= selectedRating) {
                                                                        star.style.color = 'gold';
                                                                    } else {
                                                                        star.style.color = '#ccc';
                                                                    }
                                                                });
                                                            }
                                                        </script>
                                                    </div>
                                                </div>
                                            @endif
                                        @endguest
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($relatedProducts->count() > 0)
                        <div class="row mt-60">
                            <div class="col-12">
                                <h2 class="section-title style-1 mb-30">Related products</h2>
                            </div>
                            <div class="col-12">
                                <div class="row related-products">

                                    @foreach ($relatedProducts as $product)
                                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                            <div class="product-cart-wrap hover-up">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a
                                                            href="{{ url('/product-details/' . $product->id . '/' . $product->product_slug) }}">
                                                            <img class="default-img"
                                                                src="{{ asset($product->product_thumbnail) }}"
                                                                alt="" />
                                                            @if ($product->multiImages->count() > 1)
                                                                <img class="hover-img"
                                                                    src="{{ asset($product->multiImages->skip(1)->first()->photo_name) }}"
                                                                    alt="" />
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="product-action-1">
                                                        @php
                                                            $isInWishlist = \App\Models\Wishlist::where(
                                                                'user_id',
                                                                auth()->id(),
                                                            )
                                                                ->pluck('product_id')
                                                                ->contains($product->id);
                                                        @endphp

                                                        <a aria-label="{{ $isInWishlist ? 'Remove from wishlist' : 'Add to Wishlist' }}"
                                                            class="action-btn" href="javascript:void(0);"
                                                            onclick="toggleWishlist({{ $product->id }})"
                                                            id="wishlist-btn-{{ $product->id }}"
                                                            data-product-id="{{ $product->id }}">
                                                            <!-- Add data-product-id -->
                                                            <i
                                                                class="fi-rs-heart {{ $isInWishlist ? 'text-danger' : '' }}"></i>
                                                        </a>

                                                        <a aria-label="Compare" class="action-btn" href="#"><i
                                                                class="fi-rs-shuffle"></i></a>
                                                        <!-- Add a unique identifier to each quick view button -->
                                                        <a aria-label="Quick view" class="action-btn quick-view-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#quickViewModal{{ $product->id }}"><i
                                                                class="fi-rs-eye"></i></a>
                                                    </div>
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        @php
                                                            $amount =
                                                                $product->selling_price - $product->discount_price;
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
                                                    <div class="product-detail-rating">
                                                        <div class="product-rate-cover text-end">
                                                            <div class="product-rate d-inline-block">
                                                                <!-- Calculate average rating from product reviews -->
                                                                <div class="product-rating"
                                                                    style="width: {{ $product->reviews->where('status', 1)->avg('rating') * 20 }}%">
                                                                </div>
                                                            </div>
                                                            <span class="font-small ml-5 text-muted">
                                                                <!-- Display total number of reviews -->
                                                                ({{ $product->reviews->where('status', 1)->count() }}
                                                                reviews)
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="font-small text-muted">By <a
                                                                href="{{ route('vendor.details', $product->vendor->id) }}">{{ $product->vendor->name ?? 'Owner' }}</a></span>
                                                    </div>
                                                    <div class="product-card-bottom">
                                                        @if ($product->discount_price == null)
                                                            <div class="product-price">
                                                                <span>${{ $product->selling_price }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product-price">
                                                                <span>${{ $amount }}</span>
                                                                <span
                                                                    class="old-price">${{ $product->selling_price }}</span>
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
                                        <div class="modal fade custom-modal" id="quickViewModal{{ $product->id }}"
                                            tabindex="-1" aria-labelledby="quickViewModal{{ $product->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                                                <div class="detail-gallery">
                                                                    <span class="zoom-icon"><i
                                                                            class="fi-rs-search"></i></span>
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
                                                                            <div><img
                                                                                    src="{{ asset($image->photo_name) }}"
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
                                                                                $product->selling_price -
                                                                                $product->discount_price;
                                                                            $discount =
                                                                                100 -
                                                                                ($amount / $product->selling_price) *
                                                                                    100;
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
                                                                            @else
                                                                            @endif
                                                                        @else
                                                                            <span class="hot">Save
                                                                                {{ round($discount) }} %</span>
                                                                        @endif
                                                                    </span>
                                                                    <h3 class="title-detail"><a
                                                                            href="{{ url('/product-details/' . $product->id . '/' . $product->product_slug) }}"
                                                                            class="text-heading">{{ $product->product_name }}</a>
                                                                    </h3>
                                                                    <div class="product-detail-rating">
                                                                        <div class="product-rate-cover text-end">
                                                                            <div class="product-rate d-inline-block">
                                                                                <!-- Calculate average rating from product reviews -->
                                                                                <div class="product-rating"
                                                                                    style="width: {{ $product->reviews->where('status', 1)->avg('rating') * 20 }}%">
                                                                                </div>
                                                                            </div>
                                                                            <span class="font-small ml-5 text-muted">
                                                                                <!-- Display total number of reviews -->
                                                                                ({{ $product->reviews->where('status', 1)->count() }}
                                                                                reviews)
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        $product_size = explode(
                                                                            ',',
                                                                            $product->product_size,
                                                                        );
                                                                        $product_color = explode(
                                                                            ',',
                                                                            $product->product_color,
                                                                        );
                                                                    @endphp

                                                                    @if (!empty($product->product_size))
                                                                        <div class="attr-detail attr-size mb-30">
                                                                            <strong class="mr-10"
                                                                                style="width:50px;">Size : </strong>
                                                                            <select
                                                                                class="form-control unicase-form-control"
                                                                                id="sizeSelect_{{ $product->id }}">
                                                                                @if (count($product_size) === 1)
                                                                                    <option selected
                                                                                        value="{{ $product_size[0] }}">
                                                                                        {{ ucwords($product_size[0]) }}
                                                                                    </option>
                                                                                @else
                                                                                    <option selected disabled>--Choose
                                                                                        Size--</option>
                                                                                    @foreach ($product_size as $size)
                                                                                        <option
                                                                                            value="{{ $size }}">
                                                                                            {{ ucwords($size) }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    @endif

                                                                    @if (!empty($product->product_color))
                                                                        <div class="attr-detail attr-color mb-30">
                                                                            <strong class="mr-10"
                                                                                style="width:50px;">Color: </strong>
                                                                            <select
                                                                                class="form-control unicase-form-control"
                                                                                id="colorSelect_{{ $product->id }}">
                                                                                @if (count($product_color) === 1)
                                                                                    <option selected
                                                                                        value="{{ $product_color[0] }}">
                                                                                        {{ ucwords($product_color[0]) }}
                                                                                    </option>
                                                                                @else
                                                                                    <option selected disabled>--Choose
                                                                                        Color--</option>
                                                                                    @foreach ($product_color as $color)
                                                                                        <option
                                                                                            value="{{ $color }}">
                                                                                            {{ ucwords($color) }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    @endif

                                                                    <div class="clearfix product-price-cover">
                                                                        <div
                                                                            class="product-price primary-color float-left">
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
                                                                                id="qty_{{ $product->id }}"
                                                                                class="qty-val" value="1"
                                                                                min="1">
                                                                            <a href="#" class="qty-up"><i
                                                                                    class="fi-rs-angle-small-up"></i></a>
                                                                        </div>
                                                                        <div class="product-extra-link2">
                                                                            <input type="hidden" id="product_id"
                                                                                value="{{ $product->id }}">
                                                                            <input type="hidden"
                                                                                id="product_qty_{{ $product->id }}"
                                                                                value="{{ $product->product_qty }}">
                                                                            <button type="submit"
                                                                                class="button button-add-to-cart"
                                                                                onClick="addToCart(this, {{ $product->id }})">
                                                                                <i class="fi-rs-shopping-cart"></i> Add to
                                                                                cart
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
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

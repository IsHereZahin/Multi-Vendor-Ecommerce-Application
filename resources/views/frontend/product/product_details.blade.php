@extends('frontend\components\master')
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ '/' }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> <a href="#">{{ $product->category->name }}</a> <span></span>{{ $product->subcategory->name }}
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
                                @if ($product->product_qty > 0)
                                    <span class="stock-status in-stock">In Stock</span>
                                @else
                                    <span class="stock-status out-stock">Out Stock</span>
                                @endif
                                <h2 class="title-detail">{{ $product->product_name }}</h2>
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

                                        @php
                                            $amount = $product->selling_price - $product->discount_price;
                                            $discount = 100 - (($amount / $product->selling_price) * 100);
                                        @endphp

                                        <span class="current-price text-brand">${{ $amount }}</span>
                                        @if ($discount > 0)
                                            <span>
                                                <span class="save-price font-md color3 ml-15">{{ round($discount) }}% Off</span>
                                                <span class="old-price font-md ml-15">${{ $product->selling_price }} </span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="short-desc mb-30">
                                    <p class="font-lg">{{ $product->short_descp }}</p>
                                </div>
                                @if(!empty($product_size))
                                    <div class="attr-detail attr-size mb-30">
                                        <strong class="mr-10" style="width:50px;">Size : </strong>
                                        <select class="form-control unicase-form-control" id="sizeSelect">
                                            <option selected disabled>--Choose Size--</option>
                                            @foreach($product_size as $size)
                                                <option value="{{ $size }}">{{ ucwords($size) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @if(!empty($product_color))
                                    <div class="attr-detail attr-color mb-30">
                                        <strong class="mr-10" style="width:50px;">Color : </strong>
                                        <select class="form-control unicase-form-control" id="colorSelect">
                                            <option selected disabled>--Choose Color--</option>
                                            @foreach($product_color as $color)
                                                <option value="{{ $color }}">{{ ucwords($color) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="detail-extralink mb-50">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <input type="number" name="quantity" class="qty-val" value="1" min="1" max="{{ $product->product_qty ?? 1 }}">
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>

                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                        <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                    </div>
                                </div>
                                @if($product->vendor_id == NULL)
                                    <h6> Sold By <a href="#"> <span class="text-danger"> Owner </span> </a></h6>
                                @else
                                    <h6> Sold By <a href="{{ route('vendor.details',$product->vendor->id) }}"> <span class="text-danger"> {{ $product['vendor']['name'] }} </span></a></h6>
                                @endif
                                <hr>

                                <div class="font-xs">
                                    <ul class="mr-50 float-start">
                                        <li class="mb-5">Brand: <span class="text-brand">{{ $product['brand']['name'] }}</span></li>
                                        <li class="mb-5">Category:<span class="text-brand"> {{ $product['category']['name'] }}</span></li>
                                        @if ($product->created_at)
                                            <li class="mb-5">Created: <span class="text-brand">{{ $product->created_at->format('M j.Y') }}</span></li>
                                        @endif
                                        @if ($product->updated_at && $product->created_at != $product->updated_at)
                                            <li class="mb-5">Last Updated: <span class="text-brand">{{ $product->updated_at->format('M j.Y') }}</span></li>
                                        @endif
                                    </ul>
                                    <ul class="float-start">
                                        <li>SubCategory: <span class="text-brand">{{ $product['subcategory']['name'] }}</span></li>
                                        <li class="mb-5">Product Code: <a href="#">{{ $product->product_code }}</a></li>
                                        @php
                                            $tags = explode(',', $product->product_tags ?? '');
                                        @endphp

                                        @if (!empty($tags))
                                            <li class="mb-5">Tags:
                                                @foreach ($tags as $index => $tag)
                                                    <a href="#" rel="tag">{{ ucfirst(trim($tag)) }}</a>@if ($index < count($tags) - 1),@endif
                                                @endforeach
                                            </li>
                                        @endif
                                        <li>Stock:<span class="in-stock text-brand ml-5">{{ $product->product_qty }} Items In Stock</span></li>
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
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab" href="#Additional-info">Additional info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab" href="#Vendor-info">Vendor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews (3)</a>
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
                                            <img class="default-img" src="{{ (!empty($product->vendor->photo)) ? url('upload/user/vendor/'.$product->vendor->photo):url('adminbackend/assets/images/no_image.jpg') }}" alt="Vendor Logo" width="60" height="60" />
                                        </div>
                                        <div class="vendor-details ml-15">
                                            <h6 class="vendor-name">
                                                <a href="{{ route('vendor.details',$product->vendor->id) }}">{{ $product->vendor->name ?? 'Owner' }}</a>
                                            </h6>
                                            <div class="product-rate-cover text-end">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="contact-infor mb-50">
                                        <li>
                                            <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-location.svg')}}" alt="Location Icon" />
                                            <strong>Address: </strong>
                                            <span>{{ $product->vendor->address ?? 'Not detected' }}</span>
                                        </li>
                                        <li>
                                            <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg')}}" alt="Contact Icon" />
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
                                                    <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-clock.svg')}}" alt="Contact Icon" />
                                                    <strong>Vendor since:</strong>
                                                @if($yearsSinceJoin !== null)
                                                    @if($yearsSinceJoin === 0)
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
                                                    <div class="single-comment justify-content-between d-flex mb-30">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="assets/imgs/blog/author-2.png" alt="" />
                                                                <a href="#" class="font-heading text-brand">Sienna</a>
                                                            </div>
                                                            <div class="desc">
                                                                <div class="d-flex justify-content-between mb-10">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="font-xs text-muted">December 4, 2022 at 3:12 pm </span>
                                                                    </div>
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating" style="width: 100%"></div>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi dignissimos sequi repudiandae minus ab deleniti totam officia id incidunt? <a href="#" class="reply">Reply</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-comment justify-content-between d-flex mb-30 ml-30">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="assets/imgs/blog/author-3.png" alt="" />
                                                                <a href="#" class="font-heading text-brand">Brenna</a>
                                                            </div>
                                                            <div class="desc">
                                                                <div class="d-flex justify-content-between mb-10">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="font-xs text-muted">December 4, 2022 at 3:12 pm </span>
                                                                    </div>
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating" style="width: 80%"></div>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi dignissimos sequi repudiandae minus ab deleniti totam officia id incidunt? <a href="#" class="reply">Reply</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-comment justify-content-between d-flex">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="assets/imgs/blog/author-4.png" alt="" />
                                                                <a href="#" class="font-heading text-brand">Gemma</a>
                                                            </div>
                                                            <div class="desc">
                                                                <div class="d-flex justify-content-between mb-10">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="font-xs text-muted">December 4, 2022 at 3:12 pm </span>
                                                                    </div>
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating" style="width: 80%"></div>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi dignissimos sequi repudiandae minus ab deleniti totam officia id incidunt? <a href="#" class="reply">Reply</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <h4 class="mb-30">Customer reviews</h4>
                                                <div class="d-flex mb-30">
                                                    <div class="product-rate d-inline-block mr-15">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <h6>4.8 out of 5</h6>
                                                </div>
                                                <div class="progress">
                                                    <span>5 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                                                </div>
                                                <div class="progress">
                                                    <span>4 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                </div>
                                                <div class="progress">
                                                    <span>3 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                                                </div>
                                                <div class="progress">
                                                    <span>2 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                                                </div>
                                                <div class="progress mb-30">
                                                    <span>1 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                                                </div>
                                                <a href="#" class="font-xs text-muted">How are ratings calculated?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--comment form-->
                                    <div class="comment-form">
                                        <h4 class="mb-15">Add a review</h4>
                                        <div class="product-rate d-inline-block mb-30"></div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12">
                                                <form class="form-contact comment_form" action="#" id="commentForm">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9" placeholder="Write Comment"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="name" id="name" type="text" placeholder="Name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email" id="email" type="email" placeholder="Email" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <input class="form-control" name="website" id="website" type="text" placeholder="Website" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="button button-contactForm">Submit Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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

                                @foreach($relatedProducts as $product)
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap hover-up">
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
                                                <span class="font-small text-muted">By <a href="{{ route('vendor.details',$product->vendor->id) }}">{{ $product->vendor->name ?? 'Owner' }}</a></span>
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
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

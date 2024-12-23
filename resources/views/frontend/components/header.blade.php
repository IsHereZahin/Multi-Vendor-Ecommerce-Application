    <!-- Header  -->
    <header class="header-area header-style-1 header-height-2">
        <div class="mobile-promotion">
            <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
        </div>
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><a href="{{ '/dashboard' }}">My Cart</a></li>
                                <li><a href="shop-wishlist.html">Checkout</a></li>
                                <li><a href="shop-order.html">Order Tracking</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="text-center">
                            <div id="news-flash" class="d-inline-block">
                                <ul>
                                    <li>100% Secure delivery without contacting the courier</li>
                                    <li>Supper Value Deals - Save more with coupons</li>
                                    <li>Trendy 25silver jewelry, save up 35% off today</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            <ul>

                                <li>
                                    <a class="language-dropdown-active" href="#">English <i class="fi-rs-angle-small-down"></i></a>
                                    <ul class="language-dropdown">
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-fr.png') }}" alt="" />Français</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-dt.png') }}" alt="" />Deutsch</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-ru.png') }}" alt="" />Pусский</a>
                                        </li>
                                    </ul>
                                </li>

                                 <li>Need help? Call Us: <strong class="text-brand"> + 1800 900</strong></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ '/' }}"><img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="#">
                                @php
                                    $categories = App\Models\Category::all();
                                @endphp
                                <select class="select-active">
                                    @if ($categories->isEmpty())
                                        <option>No categories found</option>
                                    @else
                                        <option>All Categories</option>
                                        @foreach ($categories as $category)
                                            <option>{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="text" placeholder="Search for items..." />
                            </form>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="search-location">
                                    <form action="#">
                                        <select class="select-active">
                                            <option>Your Location</option>
                                            <option>Alabama</option>
                                            <option>Alaska</option>
                                            <option>Arizona</option>
                                            <option>Delaware</option>
                                            <option>Florida</option>
                                            <option>Georgia</option>
                                            <option>Hawaii</option>
                                            <option>Indiana</option>
                                            <option>Maryland</option>
                                            <option>Nevada</option>
                                            <option>New Jersey</option>
                                            <option>New Mexico</option>
                                            <option>New York</option>
                                        </select>
                                    </form>
                                </div>

                                <div class="header-action-icon-2">
                                    <a href="shop-wishlist.html">
                                        <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                        <span class="pro-count blue">6</span>
                                    </a>
                                    <a href="shop-wishlist.html"><span class="lable">Wishlist</span></a>
                                </div>
                                @include('frontend.cart.art-dropdown-wrap')
                                <div class="header-action-icon-2">
                                    @if(auth()->check())
                                        @if(auth()->user()->role === 'user')
                                            <a href="{{ '/dashboard' }}">
                                                <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                                            </a>
                                            <a href="{{ '/dashboard' }}"><span class="lable ml-0">Account</span></a>
                                            <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                                <ul>
                                                    <li>
                                                        <a href="{{ '/dashboard' }}"><i class="fi fi-rs-user mr-10"></i>My Account</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ '/dashboard' }}"><i class="fi fi-rs-location-alt mr-10"></i>Order Tracking</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ '/dashboard' }}"><i class="fi fi-rs-label mr-10"></i>My Voucher</a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-wishlist.html"><i class="fi fi-rs-heart mr-10"></i>My Wishlist</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ '/dashboard' }}"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('logout') }}"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @elseif(auth()->user()->role === 'admin')
                                            <a href="{{ route('admin.dashboard') }}">
                                                <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                                            </a>
                                            <a href="{{ route('admin.dashboard') }}"><span class="lable ml-0">Account</span></a>
                                            <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                                <ul>
                                                    <li>
                                                        <a href="{{ route('admin.dashboard') }}"><i class="fi fi-rs-user mr-10"></i>Admin Dashboard</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('logout') }}"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @elseif(auth()->user()->role === 'vendor')
                                            <a href="{{ route('vendor.dashboard') }}">
                                                <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                                            </a>
                                            <a href="{{ route('vendor.dashboard') }}"><span class="lable ml-0">Account</span></a>
                                            <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                                <ul>
                                                    <li>
                                                        <a href="{{ route('vendor.dashboard') }}"><i class="fi fi-rs-user mr-10"></i>Vendor Dashboard</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('logout') }}"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}">
                                            <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                                        </a>
                                        <a href="{{ route('login') }}"><span class="lable ml-0">Login</span></a>
                                        <span class="lable" style="margin-left: 2px; margin-right: 2px;"> | </span>
                                        <a href="{{ route('register') }}"><span class="lable ml-0">Register</span></a>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ '/' }}"><img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">

                        {{-- Start Category --}}
                        @php
                            $categories = App\Models\Category::all();
                            $categoriesChunked = $categories->chunk(ceil($categories->count() / 2));
                        @endphp

                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active" href="#">
                                <span class="fi-rs-apps"></span>   All Categories
                                <i class="fi-rs-angle-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                                @if ($categories->isEmpty())
                                    <p>No categories found.</p>
                                @else
                                    <div class="d-flex categori-dropdown-inner">
                                        <ul>
                                            @foreach ($categoriesChunked[0] as $data)
                                                <li>
                                                    <a href="{{ route('category.products', ['id' => $data->id, 'slug' => $data->slug]) }}"> <img src="{{ asset('upload/categories/'.$data->image) }}" alt="" />{{ $data->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <ul class="end">
                                            @foreach ($categoriesChunked[1] as $data)
                                                <li>
                                                    <a href="{{ route('category.products', ['id' => $data->id, 'slug' => $data->slug]) }}"> <img src="{{ asset('upload/categories/'.$data->image) }}">{{ $data->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="more_slide_open" style="display: none">
                                        <div class="d-flex categori-dropdown-inner">
                                            <ul>
                                                @foreach ($categoriesChunked[0] as $data)
                                                    <li>
                                                        <a href="{{ route('category.products', ['id' => $data->id, 'slug' => $data->slug]) }}"> <img src="{{ asset('upload/categories/'.$data->image) }}">{{ $data->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <ul class="end">
                                                @foreach ($categoriesChunked[1] as $data)
                                                    <li>
                                                        <a href="{{ route('category.products', ['id' => $data->id, 'slug' => $data->slug]) }}"> <img src="{{ asset('upload/categories/'.$data->image) }}">{{ $data->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="more_categories"><span class="icon"></span> <span class="heading-sm-1">Show more...</span></div>
                                @endif
                            </div>
                        </div>
                        {{-- End Category --}}


                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>

                                    <li>
                                        <a class="active" href="{{ '/' }}">Home  </a>

                                    </li>
                                    <li>
                                        <a href="page-about.html">About</a>
                                    </li>

                                    {{-- Shop --}}
                                    <li>
                                        @php
                                            $shops = App\Models\User::where('role', 'vendor')->get();
                                        @endphp

                                        <a href="#">Shop <i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            @if ($shops->isEmpty())
                                                <li><a href="#">No shops found</a></li>
                                            @else
                                                @foreach ($shops as $shop)
                                                    <li><a href="{{ route('vendor.details', $shop->id) }}">{{ $shop->name }}</a></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                    {{-- End Shop --}}

                                    {{-- Brand --}}
                                    <li>
                                        @php
                                            $brands = App\Models\Brand::all();
                                        @endphp
                                        <a href="#">Brand <i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            @if ($brands->isEmpty())
                                                <li><a href="#">No brands found</a></li>
                                            @else
                                                @foreach ($brands as $brand)
                                                    <li><a href="{{ route('brand.show', $brand->id) }}">{{ $brand->name }}</a></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                    {{-- End Brand --}}

                                    {{-- SubCategory --}}
                                    @if($categories->isNotEmpty())
                                        <li class="position-static">
                                            <a href="#">Mega menu <i class="fi-rs-angle-down"></i></a>
                                            <ul class="mega-menu">
                                                @foreach ($categories as $category)
                                                    @php
                                                        $subcategories = App\Models\SubCategory::where('category_id', $category->id)->get();
                                                    @endphp
                                                    @if($subcategories->isNotEmpty())
                                                        <li class="sub-mega-menu sub-mega-menu-width-22">
                                                            <a class="menu-title" href="{{ route('category.products', ['id' => $category->id, 'slug' => $category->slug]) }}">{{ $category->name }}</a>
                                                            <ul>
                                                                @foreach ($subcategories as $subcategory)
                                                                    <li><a href="{{ route('subcategory.products', ['id' => $subcategory->id, 'slug' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endif
                                                @endforeach
                                                <li class="sub-mega-menu sub-mega-menu-width-34">
                                                    <div class="menu-banner-wrap">
                                                        <a href="#"><img src="{{ asset('frontend/assets/imgs/banner/banner-menu.png') }}" alt="Nest" /></a>
                                                        <div class="menu-banner-content">
                                                            <h4>Hot deals</h4>
                                                            <h3>
                                                                Don't miss<br />
                                                                Trending
                                                            </h3>
                                                            <div class="menu-banner-price">
                                                                <span class="new-price text-success">Save to 50%</span>
                                                            </div>
                                                            <div class="menu-banner-btn">
                                                                <a href="#">Shop now</a>
                                                            </div>
                                                        </div>
                                                        <div class="menu-banner-discount">
                                                            <h3>
                                                                <span>25%</span>
                                                                off
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                    {{-- End SubCategory --}}

                                    <li>
                                        <a href="blog-category-grid.html">Blog <i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li><a href="blog-category-grid.html">Blog Category Grid</a></li>
                                            <li><a href="blog-category-list.html">Blog Category List</a></li>
                                            <li><a href="blog-category-big.html">Blog Category Big</a></li>
                                            <li><a href="blog-category-fullwidth.html">Blog Category Wide</a></li>
                                            <li>
                                                <a href="#">Single Post <i class="fi-rs-angle-right"></i></a>
                                                <ul class="level-menu level-menu-modify">
                                                    <li><a href="blog-post-left.html">Left Sidebar</a></li>
                                                    <li><a href="blog-post-right.html">Right Sidebar</a></li>
                                                    <li><a href="blog-post-fullwidth.html">No Sidebar</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">Pages <i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li><a href="page-about.html">About Us</a></li>
                                            <li><a href="page-contact.html">Contact</a></li>
                                            <li><a href="{{ '/dashboard' }}">My Account</a></li>
                                            <li><a href="page-login.html">Login</a></li>
                                            <li><a href="page-register.html">Register</a></li>
                                            <li><a href="page-forgot-password.html">Forgot password</a></li>
                                            <li><a href="page-reset-password.html">Reset password</a></li>
                                            <li><a href="page-purchase-guide.html">Purchase Guide</a></li>
                                            <li><a href="page-privacy-policy.html">Privacy Policy</a></li>
                                            <li><a href="page-terms.html">Terms of Service</a></li>
                                            <li><a href="page-404.html">404 Page</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="page-contact.html">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>


                    <div class="hotline d-none d-lg-flex">
                        <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                        <p>1900 - 888<span>24/7 Support Center</span></p>
                    </div>
                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="shop-wishlist.html">
                                    <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count white">4</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="#">
                                    <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count white">2</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="#"><img alt="Nest" src="{{ asset('frontend/assets/imgs/shop/thumbnail-3.jpg') }}" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="#">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="#"><img alt="Nest" src="{{ asset('frontend/assets/imgs/shop/thumbnail-4.jpg') }}" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="#">Macbook Pro 2022</a></h4>
                                                <h3><span>1 × </span>$3500.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>$383.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="shop-cart.html">View cart</a>
                                            <a href="shop-checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
   <!-- End Header  -->

   <div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="{{ '/' }}"><img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="#">
                    <input type="text" placeholder="Search for items…" />
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href="{{ '/' }}">Home</a>

                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">shop</a>
                            <ul class="dropdown">
                                <li><a href="#">Shop Grid – Right Sidebar</a></li>
                                <li><a href="shop-grid-left.html">Shop Grid – Left Sidebar</a></li>
                                <li><a href="shop-list-right.html">Shop List – Right Sidebar</a></li>
                                <li><a href="shop-list-left.html">Shop List – Left Sidebar</a></li>
                                <li><a href="shop-fullwidth.html">Shop - Wide</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#">Single Product</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Product – Right Sidebar</a></li>
                                        <li><a href="shop-product-left.html">Product – Left Sidebar</a></li>
                                        <li><a href="shop-product-full.html">Product – No sidebar</a></li>
                                        <li><a href="shop-product-vendor.html">Product – Vendor Infor</a></li>
                                    </ul>
                                </li>
                                <li><a href="shop-filter.html">Shop – Filter</a></li>
                                <li><a href="shop-wishlist.html">Shop – Wishlist</a></li>
                                <li><a href="shop-cart.html">Shop – Cart</a></li>
                                <li><a href="shop-checkout.html">Shop – Checkout</a></li>
                                <li><a href="shop-compare.html">Shop – Compare</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#">Shop Invoice</a>
                                    <ul class="dropdown">
                                        <li><a href="shop-invoice-1.html">Shop Invoice 1</a></li>
                                        <li><a href="shop-invoice-2.html">Shop Invoice 2</a></li>
                                        <li><a href="shop-invoice-3.html">Shop Invoice 3</a></li>
                                        <li><a href="shop-invoice-4.html">Shop Invoice 4</a></li>
                                        <li><a href="shop-invoice-5.html">Shop Invoice 5</a></li>
                                        <li><a href="shop-invoice-6.html">Shop Invoice 6</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-item-has-children">
                            <a href="#">Mega menu</a>
                            <ul class="dropdown">
                                <li class="menu-item-has-children">
                                    <a href="#">Women's Fashion</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Dresses</a></li>
                                        <li><a href="#">Blouses & Shirts</a></li>
                                        <li><a href="#">Hoodies & Sweatshirts</a></li>
                                        <li><a href="#">Women's Sets</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Men's Fashion</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Jackets</a></li>
                                        <li><a href="#">Casual Faux Leather</a></li>
                                        <li><a href="#">Genuine Leather</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Technology</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Gaming Laptops</a></li>
                                        <li><a href="#">Ultraslim Laptops</a></li>
                                        <li><a href="#">Tablets</a></li>
                                        <li><a href="#">Laptop Accessories</a></li>
                                        <li><a href="#">Tablet Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="blog-category-fullwidth.html">Blog</a>
                            <ul class="dropdown">
                                <li><a href="blog-category-grid.html">Blog Category Grid</a></li>
                                <li><a href="blog-category-list.html">Blog Category List</a></li>
                                <li><a href="blog-category-big.html">Blog Category Big</a></li>
                                <li><a href="blog-category-fullwidth.html">Blog Category Wide</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#">Single Product Layout</a>
                                    <ul class="dropdown">
                                        <li><a href="blog-post-left.html">Left Sidebar</a></li>
                                        <li><a href="blog-post-right.html">Right Sidebar</a></li>
                                        <li><a href="blog-post-fullwidth.html">No Sidebar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Pages</a>
                            <ul class="dropdown">
                                <li><a href="page-about.html">About Us</a></li>
                                <li><a href="page-contact.html">Contact</a></li>
                                <li><a href="{{ '/dashboard' }}">My Account</a></li>
                                <li><a href="page-login.html">Login</a></li>
                                <li><a href="page-register.html">Register</a></li>
                                <li><a href="page-forgot-password.html">Forgot password</a></li>
                                <li><a href="page-reset-password.html">Reset password</a></li>
                                <li><a href="page-purchase-guide.html">Purchase Guide</a></li>
                                <li><a href="page-privacy-policy.html">Privacy Policy</a></li>
                                <li><a href="page-terms.html">Terms of Service</a></li>
                                <li><a href="page-404.html">404 Page</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Language</a>
                            <ul class="dropdown">
                                <li><a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">German</a></li>
                                <li><a href="#">Spanish</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="page-contact.html"><i class="fi-rs-marker"></i> Our location </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="{{ route('login') }}"><i class="fi-rs-user"></i>Log In / Sign Up </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="#"><i class="fi-rs-headphones"></i>(+01) - 2345 - 6789 </a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-twitter-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-pinterest-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-youtube-white.svg') }}" alt="" /></a>
            </div>
            <div class="site-copyright">Copyright 2022 © Nest. All rights reserved. Powered by AliThemes.</div>
        </div>
    </div>
</div>
<!--End header-->

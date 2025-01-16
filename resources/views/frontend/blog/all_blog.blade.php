@extends('frontend.components.master')
@section('content')

@section('title')
    {{ request()->routeIs('category.blogs') ? ucfirst($category->blog_category_name) . ' Blog' : 'All Blogs' }}
@endsection

    <main class="main">
        <div class="page-header mt-30 mb-75">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <h1 class="mb-15">Blog & News</h1>
                            <div class="breadcrumb">
                                <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                                <span></span>
                                @if (request()->routeIs('category.blogs'))
                                    <a href="{{ route('all.blogs') }}">Blogs</a>
                                    <span></span>{{ ucfirst($category->blog_category_name) }}
                                @else
                                    All Blogs
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="shop-product-fillter mb-50 pr-30">
                            <div class="totall-product">
                                <h3>
                                    @if (request()->routeIs('category.blogs'))
                                        Blogs in "{{ ucfirst($category->blog_category_name) }}"
                                    @else
                                        All Categories
                                    @endif
                                </h3>
                            </div>
                            <div class="sort-by-product-area">
                                <div class="sort-by-cover mr-10">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps"></i>Show:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="active" href="#">50</a></li>
                                            <li><a href="#">100</a></li>
                                            <li><a href="#">150</a></li>
                                            <li><a href="#">200</a></li>
                                            <li><a href="#">All</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sort-by-cover">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps-sort"></i>Sort:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span>Featured <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="active" href="#">Featured</a></li>
                                            <li><a href="#">Newest</a></li>
                                            <li><a href="#">Most comments</a></li>
                                            <li><a href="#">Release Date</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="loop-grid loop-list pr-30 mb-50">
                            @foreach ($blogs as $blog)
                                <article class="wow fadeIn animated hover-up mb-30 animated">
                                    <div class="post-thumb" style="background-image: url({{ asset($blog->blog_image) }})">
                                        <div class="entry-meta">
                                            <a href="{{ route('blog.details', [$blog->category->blog_category_slug, $blog->blog_slug]) }}"
                                                class="entry-meta meta-2"><i class="fi-rs-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="entry-content-2 pl-50">
                                        <p>{{ ucwords(strtolower($blog->category->blog_category_name)) }}</p>
                                        <h3 class="post-title mb-20">
                                            <a href="{{ route('blog.details', [$blog->category->blog_category_slug, $blog->blog_slug]) }}"">{{ $blog->blog_title }}</a>
                                        </h3>
                                        <p class="post-exerpt mb-40">{{ $blog->blog_short_description }}</p>
                                        <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
                                            <div>
                                                <span class="post-on">{{ $blog->created_at->format('d M Y') }}</span>
                                                <span class="hit-count has-dot">126k Views</span>
                                            </div>
                                            <a href="{{ route('blog.details', [$blog->category->blog_category_slug, $blog->blog_slug]) }}"
                                                class="text-brand font-heading font-weight-bold">Read more <i
                                                    class="fi-rs-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar">
                        <div class="widget-area">
                            <div class="sidebar-widget-2 widget_search mb-50">
                                <div class="search-form">
                                    <form action="#">
                                        <input type="text" placeholder="Search…" />
                                        <button type="submit"><i class="fi-rs-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="sidebar-widget widget-category-2 mb-50">
                                <h5 class="section-title style-1 mb-30">Category</h5>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('category.blogs', $category->blog_category_slug) }}">
                                                <img src="{{ asset('frontend/assets/imgs/theme/icons/category-1.svg') }}"
                                                    alt="{{ ucfirst($category->blog_category_name) }}">
                                                {{ ucfirst($category->blog_category_name) }}
                                            </a>
                                            <!-- Use count() on the blogs relationship -->
                                            <span>({{ $category->blogs->count() }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
                                <h5 class="section-title style-1 mb-30">New Products</h5>
                                @php
                                    $newproducts = App\Models\Product::latest()->where('status', 1)->take(5)->get();
                                @endphp

                                @foreach ($newproducts as $product)
                                    <div class="single-post clearfix">
                                        <div class="image">
                                            <img src="{{ asset($product->product_thumbnail) }}"
                                                alt="{{ $product->product_name }}"
                                                onError="this.onerror=null; this.src='path/to/default-image.jpg';">
                                        </div>
                                        <div class="content pt-10">
                                            <h6><a
                                                    href="{{ url('/product-details/' . $product->id . '/' . $product->product_slug) }}">{{ $product->product_name }}</a>
                                            </h6>
                                            <p class="price mb-0 mt-5">${{ $product->selling_price }}</p>
                                            <div class="product-rate">
                                                <div class="product-rating" style="width: {{ $product->reviews->where('status', 1)->avg('rating') * 20 }}%"> </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="banner-img wow fadeIn mb-50 animated d-lg-block d-none">
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
            </div>
        </div>
    </main>
@endsection

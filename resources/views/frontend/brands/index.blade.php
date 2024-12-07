@extends('frontend.components.master')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ '/' }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <a href="{{ '/brands' }}"><span>Brands List</span></a>
        </div>
    </div>
</div>

<div class="page-content pt-50">
    <div class="container">
        <!-- Search Section -->
        <div class="archive-header-2 text-center mb-50">
            <h1 class="display-2 mb-30">Explore Our Brands</h1>
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="sidebar-widget-2 widget_search">
                        <div class="search-form">
                            <form action="{{ route('brands') }}" method="GET">
                                <input type="text" name="search" placeholder="Search brands by name or ID..." class="form-control" value="{{ request()->query('search') }}" />
                                <button type="submit" class="btn btn-primary"><i class="fi-rs-search"></i> Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Brands -->
        <div class="row mb-50 text-center">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="totall-product">
                    @php
                        $totalBrands = App\Models\Brand::count();
                    @endphp
                    <p>We have <strong class="text-brand">{{ $totalBrands }}</strong> amazing brands listed</p>
                </div>
            </div>
        </div>

        <!-- Brand Grid -->
        <div class="row brand-grid">
            @foreach ($brands as $brand)
            <div class="col-lg-2 col-md-3 col-12 col-sm-4 justify-content-center">
                <div class="vendor-wrap mb-40">
                    <!-- Brand Image Section -->
                    <div class="vendor-img-action-wrap">
                        <div class="vendor-img">
                            <a href="{{ route('brand.show', $brand->id) }}">
                                <img class="default-img" src="{{ url('upload/brands/'.$brand->image) }}" alt="{{ $brand->name }}" />
                            </a>
                        </div>
                        <div class="product-badges product-badges-position product-badges-mrg">
                            @if ($brand->products->count() > 10)
                                <span class="hot">Top Brand</span>
                            @elseif ($brand->products->count() > 5)
                                <span class="hot">Popular</span>
                            @else
                                <span class="new">New</span>
                            @endif
                        </div>
                    </div>

                    <!-- Brand Content Section -->
                    <div class="vendor-content-wrap">
                        <div class="d-flex justify-content-between align-items-end mb-30">
                            <div>
                                <h4 class="mb-5"><a href="{{ route('brand.show', $brand->id) }}">{{ $brand->name ?? 'Not found!' }}</a></h4>
                                <div class="product-rate-cover">
                                    <span class="font-small total-product">{{ $brand->products->where('status', 1)->count() }} Products</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('brand.show', $brand->id) }}" class="btn btn-xs">Visit Brand <i class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

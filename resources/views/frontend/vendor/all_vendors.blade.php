@extends('frontend.components.master')
@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ '/' }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
             <a href="{{ '/all/vendors' }}"><span>Vendors List</span></a>
        </div>
    </div>
</div>
<div class="page-content pt-50">
    <div class="container">

        <div class="archive-header-2 text-center">
            <h1 class="display-2 mb-50">Vendors List</h1>
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="sidebar-widget-2 widget_search mb-50">
                        <div class="search-form">
                            <form action="{{ route('all.vendors') }}" method="GET">
                                <input type="text" name="search" placeholder="Search vendors (by name or ID)..." />
                                <button type="submit"><i class="fi-rs-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-50 text-center">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="totall-product">
                    @php
                        $totalVendors = App\Models\User::where('role', 'vendor')->count();
                    @endphp
                    <div class="totall-product">
                        <p>We have <strong class="text-brand">{{ $totalVendors }}</strong> vendors now</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row vendor-grid">

            @foreach ($vendors as $vendor)
            <div class="col-lg-3 col-md-6 col-12 col-sm-6">
                <div class="vendor-wrap mb-40">
                    <div class="vendor-img-action-wrap">
                        <div class="vendor-img">
                            <a href="{{ route('vendor.details',$vendor->id) }}">
                                <img class="default-img" src="{{ (!empty($vendor->photo)) ? url('upload/user/vendor/'.$vendor->photo):url('adminbackend/assets/images/no_image.jpg') }}" alt="" />
                            </a>
                        </div>
                        <div class="product-badges product-badges-position product-badges-mrg">
                            @if ($vendor->products->count() > 10)
                                <span class="hot">Super Mall</span>
                            @elseif ($vendor->products->count() > 5)
                                <span class="hot">Mall</span>
                            @elseif ($vendor->products->count() < 2)
                                <span class="new">New</span>
                            @endif
                        </div>
                    </div>
                    <div class="vendor-content-wrap">
                        <div class="d-flex justify-content-between align-items-end mb-30">
                            <div>
                                <div class="product-category">
                                    <span class="text-muted">Since {{ $vendor->vendor_join_year ?? 'Unknown' }}</span>
                                </div>
                                <h4 class="mb-5"><a href="{{ route('vendor.details',$vendor->id) }}">{{ $vendor->name ?? 'Not found!'}}</a></h4>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                            </div>
                            <div class="mb-10">
                                <span class="font-small total-product">{{ $vendor->products->where('status', 1)->count() }} Products</span>
                            </div>
                        </div>
                        <div class="vendor-info mb-30">
                            <ul class="contact-infor text-muted">
                                <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-location.svg') }}" alt="" /><strong>Address: </strong> <span>{{ $vendor->address ?? 'Not found!' }}</span></li>
                                <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}" alt="" /><strong>Call Us:</strong><span>{{ $vendor->phone ?? 'Not found!' }}</span></li>
                            </ul>
                        </div>
                        <a href="{{ route('vendor.details',$vendor->id) }}" class="btn btn-xs">Visit Store <i class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <!--end vendor card-->
            @endforeach

        </div>
    </div>
</div>
@endsection

<!--Vendor List -->
<div class="container">
    <div class="section-title wow animate__animated animate__fadeIn" data-wow-delay="0">
        <h3 class="">All Our Vendor List </h3>
        <a class="show-all" href="{{ route('all.vendors') }}">
            All Vendors
            <i class="fi-rs-angle-right"></i>
        </a>
    </div>


    <div class="row vendor-grid">

        @php
            $vendors = App\Models\User::where('role', 'vendor')->limit(4)->get();
        @endphp
        @foreach ($vendors as $vendor)
        <div class="col-lg-3 col-md-6 col-12 col-sm-6 justify-content-center">
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
                                <span class="font-small total-product">{{ $vendor->products->count() }} Products</span>
                            </div>
                        </div>

                    </div>
                    <div class="vendor-info mb-30">
                        <ul class="contact-infor text-muted">

                            <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}" alt="" /><strong>Call Us:</strong><span>{{ $vendor->phone ?? 'Not found!'}}</span></li>
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
<!--End Vendor List -->

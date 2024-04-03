<section class="banners mb-25">
    <div class="container">
        <div class="row">

            @php
                $banners = App\Models\Banner::take(3)->get();
            @endphp

            @if ($banners->isEmpty())
                <p>No banners found</p>
            @else
                @foreach ($banners as $banner)
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="0">
                            <img src="{{ asset('upload/banners/'.$banner->image) }}" alt="" />
                            <div class="banner-text">
                                <h4>
                                    @php
                                        // Split the banner title into an array of words
                                        $words = explode(' ', $banner->title);
                                        // Get the first three words
                                        $firstThreeWords = implode(' ', array_slice($words, 0, 3));
                                        // Get the rest of the title after the third word
                                        $restOftitle = implode(' ', array_slice($words, 3));
                                    @endphp
                                    {{ $firstThreeWords }}<br>{{ $restOftitle }}
                                </h4>
                                <a href="{{ $banner->url }}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>
<!--End banners-->

<section class="home-slider position-relative mb-30">
    <div class="container">
        <div class="home-slide-cover mt-30">
            <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                @php
                    $sliders = App\Models\Slider::all();
                @endphp

                @if ($sliders->isEmpty())
                    <div class="single-hero-slider single-animation-wrap" style="background-image: url({{ asset('frontend/assets/imgs/slider/slider-2.png') }})">
                        <div class="slider-content">
                            <h1 class="display-2 mb-40">
                                Fresh Vegetables<br />
                                Big discount
                            </h1>
                            <p class="mb-65">Save up to 50% off on your first order</p>
                            <form class="form-subscriber d-flex">
                                <input type="email" placeholder="Your email address" />
                                <button class="btn" type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                @else
                    @foreach ($sliders as $slider)
                        @php
                            // Splitting the title into words
                            $words = explode(' ', $slider->title);
                            // Getting the first three words
                            $firstThreeWords = implode(' ', array_slice($words, 0, 3));
                            // Getting the rest of the title
                            $restOfTitle = implode(' ', array_slice($words, 3));
                        @endphp

                        <div class="single-hero-slider single-animation-wrap" style="background-image: url({{ asset('upload/sliders/'.$slider->image) }})">
                            <div class="slider-content">
                                <h1 class="display-2 mb-40">
                                    {{ $firstThreeWords }}<br />
                                    {{ $restOfTitle }}
                                </h1>
                                <p class="mb-65">{{ $slider->short_title }}</p>
                                <form class="form-subscriber d-flex">
                                    <input type="email" placeholder="Your email address" />
                                    <button class="btn" type="submit">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
            <div class="slider-arrow hero-slider-1-arrow"></div>
        </div>
    </div>
</section>
<!--End hero slider-->

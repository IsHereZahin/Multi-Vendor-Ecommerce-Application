<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title">
            <div class="title">
                <h3>Featured Categories</h3>

            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
        </div>
        <div class="carausel-10-columns-cover position-relative">
            <div class="carausel-10-columns" id="carausel-10-columns">

                @php
                    $categories = App\Models\Category::all();
                @endphp

                @if ($categories->isEmpty())
                    <p>No categories found</p>
                @else
                    @foreach ($categories as $category)
                        @php
                            $products = App\Models\Product::where('category_id', $category->id)->count();
                        @endphp

                        <div class="card-2 bg-10 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                            <figure class="img-hover-scale overflow-hidden">
                                <a href="{{ route('category.products', ['id' => $category->id, 'slug' => $category->slug])}}"><img src="{{ asset('upload/categories/'.$category->image) }}" alt="" /></a>
                            </figure>
                            <h6><a href="{{ route('category.products', ['id' => $category->id, 'slug' => $category->slug])}}">{{ $category->name }}</a></h6>
                            <span>{{ $products }} items</span>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</section>
<!--End category slider-->

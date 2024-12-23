<div class="header-action-icon-2">
    <a class="mini-cart-icon" href="{{ route('cart.index') }}">
        <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
        @php
            $cartItems = \App\Models\Cart::where('user_id', auth()->id())->get();
            $total = $cartItems->sum(function($item) {
                return ($item->product->selling_price - $item->product->discount_price) * $item->quantity;
            });
        @endphp
        <span class="pro-count blue">{{ $cartItems->count() }}</span>
    </a>
    <a href="{{ route('cart.index') }}"><span class="lable">Cart</span></a>

    <div class="cart-dropdown-wrap cart-dropdown-hm2">
        <ul>
            @foreach ($cartItems as $item)
                <li>
                    <div class="shopping-cart-img">
                        <a href="#"><img alt="{{ $item->product->product_name }}" src="{{ asset($item->product->product_thambnail) }}" /></a>
                    </div>
                    <div class="shopping-cart-title">
                        <h4><a href="{{ url('/product-details/'.$item->product->id.'/'.$item->product->product_slug) }}">{{ $item->product->product_name }}</a></h4>
                        <h4><span>{{ $item->quantity }} × </span>${{ $item->product->selling_price - $item->product->discount_price }}</h4>
                    </div>
                    <div class="shopping-cart-delete">
                        <a href="{{ route('cart.remove', $item->id) }}" class="text-body">
                            <i class="fi-rs-cross-small"></i>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="shopping-cart-footer">
            <div class="shopping-cart-total">
                <h4>Total <span>${{ number_format($total, 2) }}</span></h4>
            </div>
            <div class="shopping-cart-button">
                <a href="{{ route('cart.index') }}" class="outline">View cart</a>
                {{-- <a href="{{ route('checkout.index') }}">Checkout</a> --}}
                <a href="#">Checkout</a>
            </div>
        </div>
    </div>
</div>

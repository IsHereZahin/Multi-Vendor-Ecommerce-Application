@extends('frontend.components.master')

@section('content')
    <div class="container">
        <h3>Order Details</h3>

        <h4>Shipping Details</h4>
        <p>Name: {{ $shippingDetails['shipping_name'] }}</p>
        <p>Email: {{ $shippingDetails['shipping_email'] }}</p>
        <p>Phone: {{ $shippingDetails['shipping_phone'] }}</p>
        <p>Full Address: {{ $shippingDetails['shipping_full_address'] }}</p>
        <p>Division: {{ $shippingDetails['shipping_division'] }}</p>
        <p>District: {{ $shippingDetails['shipping_district'] }}</p>
        <p>State: {{ $shippingDetails['shipping_state'] }}</p>
        <p>Post Code: {{ $shippingDetails['shipping_post_code'] }}</p>
        <p>Notes: {{ $shippingDetails['shipping_notes'] }}</p>

        <h4>Cart Items</h4>
        <ul>
            @foreach ($cartItems as $item)
                <li>{{ $item->product->product_name }} - Quantity: {{ $item->quantity }}</li>
            @endforeach
        </ul>

        <h4>Total: ${{ number_format($finalTotal, 2) }}</h4>
    </div>
@endsection

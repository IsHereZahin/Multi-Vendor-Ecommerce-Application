@extends('user.user_dashboard_master')

@section('user-dashboard')
    <div class="order-details">
        <div class="card">
            <div class="card-header">
                <h5>Order Details - Invoice #{{ $order->invoice_no }}</h5>
                <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
            </div>
            <div class="card-body">
                <!-- Section 1: Shipping Details -->
                <div class="mb-4">
                    <h6><strong>Shipping Details</strong></h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $order->name }}</p>
                            <p><strong>Email:</strong> {{ $order->email }}</p>
                            <p><strong>Phone:</strong> {{ $order->phone }}</p>
                            <p><strong>Post Code:</strong> {{ $order->post_code ?? 'N/A' }}</p>
                            <p><strong>Notes:</strong> {{ $order->notes ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>State:</strong> {{ $order->state->state_name ?? 'N/A' }}</p>
                            <p><strong>District:</strong> {{ $order->district->district_name ?? 'N/A' }}</p>
                            <p><strong>Division:</strong> {{ $order->division->division_name ?? 'N/A' }}</p>
                            <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Order Details -->
                <div class="mb-4">
                    <h6><strong>Order Details</strong></h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
                            <!-- Highlighting status with different colors -->
                            <p><strong>Status:</strong>
                                <span
                                    class="badge
                                @if ($order->status == 'pending') bg-warning @elseif($order->status == 'completed') bg-success @elseif($order->status == 'canceled') bg-danger
                                @else bg-secondary @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <!-- Highlighting Payment Method -->
                            <p><strong>Payment Method:</strong>
                                <span class="badge bg-info">{{ $order->payment_method ?? 'N/A' }}</span>
                            </p>
                            <!-- Highlighting Total Amount -->
                            <p><strong>Total Amount:</strong>
                                <span class="badge bg-primary">${{ number_format($order->amount, 2) }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Order Items -->
                <div>
                    <h6><strong>Order Items</strong></h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $orderTotal = 0;
                            @endphp
                            @foreach ($order->orderItems as $item)
                                @php
                                    $orderTotal += $item->qty * $item->price;
                                @endphp
                                <tr>
                                    <td>
                                        <a class="product-name mb-10 text-heading"
                                            href="{{ url('/product-details/' . $item->product->id . '/' . $item->product->product_slug) }}">
                                            {{ $item->product->product_name ?? 'Product not found' }}
                                        </a>
                                    </td>
                                    <td>{{ $item->color ?? 'N/A' }}</td>
                                    <td>{{ $item->size ?? 'N/A' }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Displaying Total Order Values -->
                <p><strong>Order Items Total:</strong> ${{ number_format($orderTotal, 2) }}</p>
                @if ($orderTotal > $order->amount)
                    <p><strong>Order Final Amount:</strong> ${{ number_format($order->amount, 2) }}</p>

                    <!-- Section 4: Coupon Message -->
                    <div class="mt-4">
                        <!-- Show coupon message if the order total is less than the original amount -->
                        <p class="text-warning">
                            You may have used a coupon code, as your total is less than the expected amount of
                            ${{ number_format($orderTotal, 2) }}. 🛍️
                        </p>
                    </div>
                @endif

                <!-- Back to Orders Button -->
                <div class="mt-4">
                    <a href="{{ route('user.orders') }}" class="btn btn-primary">Back to Orders</a>
                </div>
            </div>
        </div>
    </div>
@endsection

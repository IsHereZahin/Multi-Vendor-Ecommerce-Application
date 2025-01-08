@extends('user.user_dashboard_master')

@section('user-dashboard')
    <div class="order-details">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <!-- Header Info Section -->
                <div>
                    <h5 class="mb-1">Order Details - Invoice #{{ $order->invoice_no }}</h5>
                    <p class="mb-0 text-muted"><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
                </div>

                <!-- Three-Dot Action Button -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="orderActionsMenu"
                        data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="orderActionsMenu">
                        <!-- Cancel Order Option -->
                        @if (in_array($order->status, ['pending', 'processing', 'picked']))
                            <li>
                                <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                    data-bs-target="#cancelOrderModal">
                                    <i class="bi bi-x-circle me-2"></i> Cancel Order
                                </button>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endif
                        <!-- Return Order Option -->
                        @if ($order->status == 'delivered')
                            <li>
                                <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                    data-bs-target="#returnOrderModal">
                                    <i class="bi bi-arrow-repeat me-2"></i> Return Order Request
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Cancel Order Modal -->
                <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('user.cancel.order', $order->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <p>Are you sure you want to cancel this order? This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep
                                        Order</button>
                                    <button type="submit" class="btn btn-danger">Yes, Cancel Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Return Order Modal -->
                <div class="modal fade" id="returnOrderModal" tabindex="-1" aria-labelledby="returnOrderModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="returnOrderModalLabel">Return Order Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('user.return.order', $order->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="returnReason" class="form-label">Reason for Return</label>
                                        <textarea name="return_reason" id="returnReason" class="form-control" rows="4"
                                            placeholder="Explain the reason for return..." required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            @if ($order->return_reason)
                <div class="alert alert-warning" role="alert">
                    <strong>Warning!</strong> This order has a return request. Reason: {{ $order->return_reason }}<br>

                    @if ($order->return_date)
                        <strong>Return Request Accepted:</strong> {{ \Carbon\Carbon::parse($order->return_date)->format('F d, Y h:i A') }}
                    @else
                        <strong>Return Request Pending</strong>
                    @endif
                </div>
            @endif

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
                                @if ($order->status == 'pending') bg-warning @elseif($order->status == 'completed') bg-success @elseif($order->status == 'canceled') bg-danger @elseif ($order->status == 'delivered') bg-info
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
                            ${{ number_format($orderTotal, 2) }}. 🎍️
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

@extends('vendor.components.master')
@section('content')
<div class="page-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Admin Order Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Admin Order Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <hr/>

    <!-- Return Request Section -->
    @if ($order->return_reason)
        <div class="alert alert-warning">
            <strong>Return Request:</strong> This order has a return request. Reason: {{ $order->return_reason }}
        </div>
        @if ($order->return_date)
            <div class="alert alert-success">
                <strong>Return Accepted:</strong> The return request was accepted on {{ $order->return_date }}.
            </div>
        @endif
    @endif

    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
        <!-- Shipping Details Section -->
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>Shipping Details</h4>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table" style="font-weight: 600;">
                        <tr>
                            <th>Shipping Name:</th>
                            <td>{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Phone:</th>
                            <td>{{ $order->phone }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Email:</th>
                            <td>{{ $order->email }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Address:</th>
                            <td>{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <th>Division:</th>
                            <td>{{ $order->division->division_name }}</td>
                        </tr>
                        <tr>
                            <th>District:</th>
                            <td>{{ $order->district->district_name }}</td>
                        </tr>
                        <tr>
                            <th>State:</th>
                            <td>{{ $order->state->state_name }}</td>
                        </tr>
                        <tr>
                            <th>Post Code:</th>
                            <td>{{ $order->post_code }}</td>
                        </tr>
                        <tr>
                            <th>Order Date:</th>
                            <td>{{ $order->order_date }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Details Section -->
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>Order Details <span class="text-danger">Invoice: {{ $order->invoice_no }}</span></h4>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table" style="font-weight: 600;">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $order->user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Payment Type:</th>
                            <td>{{ $order->payment_method }}</td>
                        </tr>
                        <tr>
                            <th>Transaction ID:</th>
                            <td>{{ $order->transaction_id }}</td>
                        </tr>
                        <tr>
                            <th>Invoice:</th>
                            <td class="text-danger">{{ $order->invoice_no }}</td>
                        </tr>
                        <tr>
                            <th>Order Amount:</th>
                            <td>${{ $order->amount }}</td>
                        </tr>
                        <tr>
                            <th>Order Status and Date-Time:</th>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</span>
                                @elseif($order->status == 'confirm')
                                    <span class="badge bg-primary" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                                    <span class="text-muted">{{ $order->confirmed_date ? \Carbon\Carbon::parse($order->confirmed_date)->format('d M Y, H:i') : 'Not confirmed yet' }}</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-info" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                                    <span class="text-muted">{{ $order->processing_date ? \Carbon\Carbon::parse($order->processing_date)->format('d M Y, H:i') : 'Not processed yet' }}</span>
                                @elseif($order->status == 'picked')
                                    <span class="badge bg-secondary" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                                    <span class="text-muted">{{ $order->picked_date ? \Carbon\Carbon::parse($order->picked_date)->format('d M Y, H:i') : 'Not picked yet' }}</span>
                                @elseif($order->status == 'shipped')
                                    <span class="badge bg-success" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                                    <span class="text-muted">{{ $order->shipped_date ? \Carbon\Carbon::parse($order->shipped_date)->format('d M Y, H:i') : 'Not shipped yet' }}</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge bg-dark" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                                    <span class="text-muted">{{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('d M Y, H:i') : 'Not delivered yet' }}</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                                    <span class="text-muted">{{ $order->cancel_date ? \Carbon\Carbon::parse($order->cancel_date)->format('d M Y, H:i') : 'Not canceled yet' }}</span>
                                @elseif($order->status == 'returned')
                                    <span class="badge bg-warning text-dark" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                                    <span class="text-muted">{{ $order->return_date ? \Carbon\Carbon::parse($order->return_date)->format('d M Y, H:i') : 'Not returned yet' }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items Section -->
    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-1">
        <div class="col">
            <div class="card">
                <div class="table-responsive">
                    <table class="table" style="font-weight: 600;">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Vendor Name</th>
                                <th>Product Code</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td><img src="{{ asset($item->product->product_thumbnail) }}" style="width:50px; height:50px;" class="img-fluid" alt="Product Image" data-bs-toggle="tooltip" title="Click to enlarge"></td>
                                    <td>{{ $item->product->product_name }}</td>
                                    <td>{{ $item->vendor_id == NULL ? 'Owner' : $item->product->vendor->name }}</td>
                                    <td>{{ $item->product->product_code }}</td>
                                    <td>{{ $item->color ?? '....' }}</td>
                                    <td>{{ $item->size ?? '....' }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>${{ $item->price }} <br> Total = ${{ $item->price * $item->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

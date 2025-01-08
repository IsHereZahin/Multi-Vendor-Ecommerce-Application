@extends('admin.components.master')
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

    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
        <!-- Shipping Details Section -->
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>Shipping Details</h4>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table" style="background:#F4F6FA; font-weight: 600;">
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
                    <table class="table" style="background:#F4F6FA; font-weight: 600;">
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
                            <th>Order Status:</th>
                            <td>
                                <span class="badge bg-danger" style="font-size: 15px;">{{ ucfirst($order->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                @if($order->status == 'pending')
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmOrderModal">Confirm Order</button>
                                @elseif($order->status == 'confirm')
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#processingOrderModal">Processing Order</button>
                                @elseif($order->status == 'processing')
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#deliveredOrderModal">Delivered Order</button>
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

    <!-- Modals for Order Actions -->
    <div class="modal fade" id="confirmOrderModal" tabindex="-1" aria-labelledby="confirmOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmOrderModalLabel">Confirm Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to confirm this order?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="" class="btn btn-primary">Confirm</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Processing Order -->
    <div class="modal fade" id="processingOrderModal" tabindex="-1" aria-labelledby="processingOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="processingOrderModalLabel">Processing Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this order as processing?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="" class="btn btn-primary">Process</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delivered Order -->
    <div class="modal fade" id="deliveredOrderModal" tabindex="-1" aria-labelledby="deliveredOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deliveredOrderModalLabel">Delivered Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this order as delivered?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="" class="btn btn-primary">Delivered</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

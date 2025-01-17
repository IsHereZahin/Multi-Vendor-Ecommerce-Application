@extends('admin.components.master')

@section('content')
    <div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            <!-- Total Revenue Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-dollar fs-2 text-warning'></i>
                        </div>
                        <h5 class="card-title mb-1">Total Revenue</h5>
                        <h4 class="card-text">${{ number_format($totalIncome, 2) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Today's Sale Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-calendar fs-2 text-success'></i>
                        </div>
                        <h5 class="card-title mb-1">Today's Sale</h5>
                        <h4 class="card-text">${{ number_format($todaySale, 2) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Monthly Sale Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-calendar-event fs-2 text-info'></i>
                        </div>
                        <h5 class="card-title mb-1">Monthly Sale</h5>
                        <h4 class="card-text">${{ number_format($monthlySale, 2) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Yearly Sale Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-calendar-check fs-2 text-dark'></i>
                        </div>
                        <h5 class="card-title mb-1">Yearly Sale</h5>
                        <h4 class="card-text">${{ number_format($yearlySale, 2) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-cart fs-2 text-primary'></i>
                        </div>
                        <h5 class="card-title mb-1">Total Orders</h5>
                        <h4 class="card-text">{{ $totalOrders }}</h4>
                    </div>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-time fs-2 text-danger'></i>
                        </div>
                        <h5 class="card-title mb-1">Pending Orders</h5>
                        <h4 class="card-text">{{ $pendingOrders }}</h4>
                    </div>
                </div>
            </div>

            <!-- Total Vendors Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-user-pin fs-2 text-secondary'></i>
                        </div>
                        <h5 class="card-title mb-1">Total Vendors</h5>
                        <h4 class="card-text">{{ $totalOrderVendor }}/{{ $totalVendors }}</h4>
                    </div>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-group fs-2 text-primary'></i>
                        </div>
                        <h5 class="card-title mb-1">Total Users</h5>
                        <h4 class="card-text">{{ $totalOrderUsers }}/{{ $totalUsers }}</h4>
                    </div>
                </div>
            </div>
        </div><!-- end row -->

        <hr />

        <div class="row">

            <!-- Left Column (Top Products) -->
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Top 10 Products</h5>
                        <div class="list-group">

                            @foreach ($topProducts as $key => $product)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <!-- Rank Icons -->
                                    <div class="d-flex align-items-center">
                                        @if ($key == 0)
                                            <i class="bx bx-crown text-warning" style="font-size: 24px; margin-right: 10px;"></i> <!-- King (Crown) -->
                                        @elseif ($key == 1)
                                            <i class="bx bx-medal text-secondary" style="font-size: 24px; margin-right: 10px;"></i> <!-- Silver Medal -->
                                        @elseif ($key == 2)
                                            <i class="bx bx-shield text-brown" style="font-size: 24px; margin-right: 10px;"></i> <!-- Bronze Shield -->
                                        @else
                                            <span class="badge bg-secondary" style="font-size: 16px;">{{ $key + 1 }}</span> <!-- Rank Number -->
                                        @endif
                                    </div>

                                    <!-- Product Information -->
                                    <div class="d-flex">
                                        <img src="{{ asset($product->product->product_thumbnail) }}" alt="{{ $product->product->product_name }}" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                        <div>
                                            <strong>{{ $product->product->product_name }}</strong><br>
                                            <small class="text-muted">Sold: {{ $product->total_quantity }}</small>
                                        </div>
                                    </div>

                                    <!-- Sales Badge -->
                                    <span class="badge bg-success">{{ $product->product->vendor->name }}</span>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (Recent Orders) -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Orders</h5>
                        <div class="table-responsive">
                            <table id="orders-table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->order_date }}</td>
                                            <td>{{ $item->invoice_no }}</td>
                                            <td>${{ number_format($item->amount, 2) }}</td>
                                            <td>{{ $item->payment_method }}</td>
                                            <td>
                                                <span
                                                    class="badge
                                                    @if ($item->status == 'pending') bg-warning
                                                    @elseif($item->status == 'confirm') bg-primary
                                                    @elseif($item->status == 'processing') bg-info
                                                    @elseif($item->status == 'completed') bg-success
                                                    @elseif($item->status == 'returned') bg-danger
                                                    @else bg-secondary @endif">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card -->
            </div>
        </div>

    </div>
@endsection

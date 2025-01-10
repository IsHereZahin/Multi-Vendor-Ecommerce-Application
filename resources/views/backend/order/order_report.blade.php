@extends('admin.components.master')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Orders</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Report Orders (<span style="color: rgb(0, 119, 255);">{{ count($orders) }}</span>)
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Filters Section -->
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.order.report') }}">
                <div class="row">
                    <!-- Order Date -->
                    <div class="col-md-2">
                        <label for="order_date">Order Date</label>
                        <input type="date" class="form-control" name="order_date" id="order_date"
                            value="{{ request('order_date') }}" placeholder="Select Order Date">
                    </div>

                    <!-- Order Month -->
                    <div class="col-md-2">
                        <label for="order_month">Order Month</label>
                        <select class="form-control" name="order_month" id="order_month">
                            <option value="">Select Month</option>
                            @foreach ($months as $month)
                                <option value="{{ $month }}"
                                    {{ request('order_month') == $month ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Order Year -->
                    <div class="col-md-2">
                        <label for="order_year">Order Year</label>
                        <select class="form-control" name="order_year" id="order_year">
                            <option value="">Select Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request('order_year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-2">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Select Status</option>
                            @foreach ($statusOptions as $statusOption)
                                <option value="{{ $statusOption }}"
                                    {{ request('status') == $statusOption ? 'selected' : '' }}>
                                    {{ ucfirst($statusOption) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- User -->
                    <div class="col-md-2">
                        <label for="user">User</label>
                        <select class="form-control" name="user" id="user">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Vendor Filter -->
                    <div class="col-md-2">
                        <label for="vendor">Vendor</label>
                        <select class="form-control" name="vendor" id="vendor">
                            <option value="">Select Vendor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}"
                                    {{ request('vendor') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Apply Filters -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary mt-4">Apply Filters</button>
                    </div>
                </div>
            </form>

            <!-- Reset Filters -->
            <form method="GET" action="{{ route('admin.order.report') }}" class="mt-3">
                <button type="submit" class="btn btn-secondary">Reset Filters</button>
            </form>
        </div>
    </div>

    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            <!-- Total Orders Card -->
            <div class="col">
                <div class="card radius-10 bg-gradient-deepblue">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{ $totalOrders }}</h5>
                            <div class="ms-auto">
                                <i class='bx bx-cart fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Total Orders</p>
                            <p class="mb-0 ms-auto">+4.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue Card -->
            <div class="col">
                <div class="card radius-10 bg-gradient-orange">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">${{ number_format($totalIncome, 2) }}</h5>
                            <div class="ms-auto">
                                <i class='bx bx-dollar fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Total Revenue</p>
                            <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="col">
                <div class="card radius-10 bg-gradient-ohhappiness">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{ $totalUsers }}</h5>
                            <div class="ms-auto">
                                <i class='bx bx-group fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Users</p>
                            <p class="mb-0 ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Returns and Cancellations Card -->
            <div class="col">
                <div class="card radius-10 bg-gradient-ibiza">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{ $totalReturns }}</h5>
                            <div class="ms-auto">
                                <i class='bx bx-envelope fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Return and cancel</p>
                            <p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->order_date }}</td>
                                    <td>{{ $item->invoice_no }}</td>
                                    <td>${{ $item->amount }}</td>
                                    <td>{{ $item->payment_method }}</td>
                                    <td>
                                        <div
                                            class="badge rounded-pill w-100
                                            @if ($item->status == 'pending') bg-warning text-dark
                                            @elseif($item->status == 'confirm') bg-primary text-white
                                            @elseif($item->status == 'processing') bg-info text-dark
                                            @elseif($item->status == 'picked') bg-secondary text-white
                                            @elseif($item->status == 'shipped') bg-light text-dark
                                            @elseif($item->status == 'delivered') bg-success text-white
                                            @elseif($item->status == 'completed') bg-dark text-white
                                            @elseif($item->status == 'returned') bg-danger text-white
                                            @elseif($item->status == 'canceled') bg-light-danger text-danger
                                            @else bg-light text-dark @endif">
                                            {{ ucfirst($item->status) }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.order.details', $item->id) }}" class="btn btn-info"
                                            title="Details">
                                            <i class="fa fa-eye"></i> Info
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

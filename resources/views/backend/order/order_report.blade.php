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

    <div class="page-content">

        <!-- Toggle Filters Button -->
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" id="toggleFilterButton">
                Show Filters
            </button>
        </div>

        <!-- Filters Section -->
        <div class="card" id="filterSection" style="display: none;">
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
                                    <option value="{{ $year }}"
                                        {{ request('order_year') == $year ? 'selected' : '' }}>
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
                                    <option value="{{ $user->id }}"
                                        {{ request('user') == $user->id ? 'selected' : '' }}>
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

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

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

            <!-- Total Users Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-group fs-2 text-success'></i>
                        </div>
                        <h5 class="card-title mb-1">Users</h5>
                        <h4 class="card-text">{{ $totalUsers }}</h4>
                    </div>
                </div>
            </div>

            <!-- Total Returns and Cancellations Card -->
            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="icon-box mb-3">
                            <i class='bx bx-envelope fs-2 text-danger'></i>
                        </div>
                        <h5 class="card-title mb-1">Return & Cancel</h5>
                        <h4 class="card-text">{{ $totalReturns }}</h4>
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
                                        @if (Auth::user()->can('order.view.details'))
                                            <a href="{{ route('admin.order.details', $item->id) }}" class="btn btn-info" title="Details">
                                                <i class="fa fa-eye"></i> Info
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('toggleFilterButton').addEventListener('click', function() {
            const filterSection = document.getElementById('filterSection');
            const isHidden = filterSection.style.display === 'none';
            filterSection.style.display = isHidden ? 'block' : 'none';
            this.textContent = isHidden ? 'Hide Filters' : 'Show Filters';
        });
    </script>
@endsection

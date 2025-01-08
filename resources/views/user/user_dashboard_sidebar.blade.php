<div class="col-md-3">
    <div class="dashboard-menu">
        <ul class="nav flex-column" role="tablist">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="dashboard-tab" href="{{ route('dashboard') }}" role="tab" aria-controls="dashboard">
                    <i class="fi-rs-settings-sliders mr-10"></i>Dashboard
                </a>
            </li>

            <!-- Orders Collapsible Menu -->
            @php
                $user = Auth::user();
                $orders = $user->orders;

                // Count orders based on their status and return_reason
                $pendingCount = $orders->whereIn('status', ['pending', 'confirm', 'processing', 'picked', 'shipped'])->count();
                $canceledCount = $orders->where('status', 'canceled')->count();
                $deliveredCount = $orders->where('status', 'delivered')->count();
                $returnRequestsCount = $orders->where('status', 'delivered')->whereNotNull('return_reason')->count(); // Delivered orders with return reason
                $returnsCount = $orders->where('status', 'returned')->whereNotNull('return_reason')->count(); // Returned orders with return reason
                $isOrdersActive = request()->routeIs('user.orders') || request()->routeIs('user.orders.*');
            @endphp

            <li class="nav-item">
                <a class="nav-link {{ $isOrdersActive ? 'active yellow' : '' }}" data-bs-toggle="collapse" href="#orders-collapse" role="button" aria-expanded="{{ $isOrdersActive ? 'true' : 'false' }}" aria-controls="orders-collapse">
                    <i class="fi-rs-shopping-bag mr-10"></i>Orders
                </a>
                <div class="collapse {{ $isOrdersActive ? 'show' : '' }}" id="orders-collapse">
                    <ul class="nav flex-column p-2">
                        <!-- All Orders -->
                        <li class="nav-item">
                            <a class="nav-link {{ !request('status') && $isOrdersActive ? 'active yellow' : '' }}" href="{{ route('user.orders') }}">
                                All Orders
                                <span class="badge bg-secondary">{{ $orders->count() }}</span>
                            </a>
                        </li>

                        <!-- Pending Orders (Includes 'pending', 'confirm', 'processing', 'picked', and 'shipped') -->
                        <li class="nav-item">
                            <a class="nav-link {{ request('status') == 'pending' ? 'active yellow' : '' }}" href="{{ route('user.orders', ['status' => 'pending']) }}">
                                Pending Orders
                                <span class="badge bg-warning">{{ $pendingCount }}</span>
                            </a>
                        </li>

                        <!-- Canceled Orders -->
                        <li class="nav-item">
                            <a class="nav-link {{ request('status') == 'canceled' ? 'active yellow' : '' }}" href="{{ route('user.orders', ['status' => 'canceled']) }}">
                                Canceled Orders
                                <span class="badge bg-danger">{{ $canceledCount }}</span>
                            </a>
                        </li>

                        <!-- Delivered Orders -->
                        <li class="nav-item">
                            <a class="nav-link {{ request('status') == 'delivered' ? 'active yellow' : '' }}" href="{{ route('user.orders', ['status' => 'delivered']) }}">
                                Delivered Orders
                                <span class="badge bg-success">{{ $deliveredCount }}</span>
                            </a>
                        </li>

                        <!-- Return Requests (Orders with 'delivered' status and a return reason) -->
                        <li class="nav-item">
                            <a class="nav-link {{ request('status') == 'return_requests' ? 'active yellow' : '' }}" href="{{ route('user.orders', ['status' => 'return_requests']) }}">
                                Return Requests
                                <span class="badge bg-info">{{ $returnRequestsCount }}</span>
                            </a>
                        </li>

                        <!-- Returned Orders (Orders with 'returned' status and a return reason) -->
                        <li class="nav-item">
                            <a class="nav-link {{ request('status') == 'returns' ? 'active yellow' : '' }}" href="{{ route('user.orders', ['status' => 'returns']) }}">
                                Returned Orders
                                <span class="badge bg-primary">{{ $returnsCount }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Track Order -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.track.orders') ? 'active' : '' }}" id="track-orders-tab" href="{{ route('user.track.orders') }}" role="tab" aria-controls="track-orders">
                    <i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order
                </a>
            </li>

            <!-- Account Details -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.account.details') ? 'active' : '' }}" id="account-detail-tab" href="{{ route('user.account.details') }}" role="tab" aria-controls="account-detail">
                    <i class="fi-rs-user mr-10"></i>Account Details
                </a>
            </li>

            <!-- Change Password -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.change.password') ? 'active' : '' }}" id="change-password-tab" href="{{ route('user.change.password') }}" role="tab" aria-controls="change-password">
                    <i class="fi-rs-password mr-10"></i>Change Password
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fi-rs-sign-out mr-10"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</div>

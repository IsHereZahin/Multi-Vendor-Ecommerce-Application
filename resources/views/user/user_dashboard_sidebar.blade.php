<div class="col-md-3">
    <div class="dashboard-menu">
        <ul class="nav flex-column" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="dashboard-tab" href="{{ route('dashboard') }}" role="tab" aria-controls="dashboard">
                    <i class="fi-rs-settings-sliders mr-10"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.orders') || request()->routeIs('user.order.details') ? 'active yellow' : '' }}" id="orders-tab" href="{{ route('user.orders') }}" role="tab" aria-controls="orders">
                    <i class="fi-rs-shopping-bag mr-10"></i>Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.track.orders') ? 'active' : '' }}" id="track-orders-tab" href="{{ route('user.track.orders') }}" role="tab" aria-controls="track-orders">
                    <i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.account.details') ? 'active' : '' }}" id="account-detail-tab" href="{{ route('user.account.details') }}" role="tab" aria-controls="account-detail">
                    <i class="fi-rs-user mr-10"></i>Account Details
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.change.password') ? 'active' : '' }}" id="change-password-tab" href="{{ route('user.change.password') }}" role="tab" aria-controls="change-password">
                    <i class="fi-rs-password mr-10"></i>Change Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fi-rs-sign-out mr-10"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</div>

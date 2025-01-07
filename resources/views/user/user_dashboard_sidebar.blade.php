<div class="col-md-3">
    <div class="dashboard-menu">
        <ul class="nav flex-column" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="dashboard-tab" href="{{ route('dashboard') }}" role="tab" aria-controls="dashboard" aria-selected="{{ request()->routeIs('dashboard') ? 'true' : 'false' }}">
                    <i class="fi-rs-settings-sliders mr-10"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.orders') ? 'active' : '' }}" id="orders-tab" href="{{ route('user.orders') }}" role="tab" aria-controls="orders" aria-selected="{{ request()->routeIs('user.orders') ? 'true' : 'false' }}">
                    <i class="fi-rs-shopping-bag mr-10"></i>Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.track.orders') ? 'active' : '' }}" id="track-orders-tab" href="{{ route('user.track.orders') }}" role="tab" aria-controls="track-orders" aria-selected="{{ request()->routeIs('user.track.orders') ? 'true' : 'false' }}">
                    <i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.account.details') ? 'active' : '' }}" id="account-detail-tab" href="{{ route('user.account.details') }}" role="tab" aria-controls="account-detail" aria-selected="{{ request()->routeIs('user.account.details') ? 'true' : 'false' }}">
                    <i class="fi-rs-user mr-10"></i>Account Details
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.change.password') ? 'active' : '' }}" id="change-password-tab" href="{{ route('user.change.password') }}" role="tab" aria-controls="change-password" aria-selected="{{ request()->routeIs('user.change.password') ? 'true' : 'false' }}">
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

<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('adminbackend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text"> <a href="{{ route('admin.dashboard') }}">Admin</a></h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li>
            <a href="{{ route('all.brand') }}">
                <div class="parent-icon"><i class="bx bx-star"></i>
                </div>
                <div class="menu-title">Brand Manage</div>
            </a>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Category</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.category') }}"><i class="bx bx-right-arrow-alt"></i>All Category</a></li>
                <li> <a href="{{ route('add.category') }}"><i class="bx bx-right-arrow-alt"></i>Add Category</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">SubCategory</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.subcategory') }}"><i class="bx bx-right-arrow-alt"></i>All SubCategory</a>
                </li>
                <li> <a href="{{ route('add.subcategory') }}"><i class="bx bx-right-arrow-alt"></i>Add SubCategory</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Slider Manage</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.slider') }}"><i class="bx bx-right-arrow-alt"></i>All Slider</a></li>
                <li> <a href="{{ route('add.slider') }}"><i class="bx bx-right-arrow-alt"></i>Add Slider</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Banner Manage</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.banner') }}"><i class="bx bx-right-arrow-alt"></i>All Banner</a></li>
                <li> <a href="{{ route('add.banner') }}"><i class="bx bx-right-arrow-alt"></i>Add Banner</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Product Manage</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.product') }}"><i class="bx bx-right-arrow-alt"></i>All Product</a>
                </li>
                <li> <a href="{{ route('add.product') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
                </li>

            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Coupon Manage</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.coupon') }}"><i class="bx bx-right-arrow-alt"></i>All Coupon</a>
                </li>
                <li> <a href="{{ route('add.coupon') }}"><i class="bx bx-right-arrow-alt"></i>Add Coupon</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Vendor</li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i>
                </div>
                <div class="menu-title">Vendor Manage</div>
            </a>
            <ul>
                <li> <a href="{{ route('inactive.vendor') }}"><i class="bx bx-right-arrow-alt"></i>Inactive
                        Vendor</a>
                </li>
                <li> <a href="{{ route('active.vendor') }}"><i class="bx bx-right-arrow-alt"></i>Active Vendor</a>
            </ul>
        </li>

        @php
        use App\Models\Order;

        $counts = [
            'pending' => Order::where('status', 'pending')->count(),
            'confirm' => Order::where('status', 'confirm')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'picked' => Order::where('status', 'picked')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'returned' => Order::where('status', 'returned')->count(),
            'canceled' => Order::where('status', 'canceled')->count(),
        ];
        @endphp

        <li class="menu-label">Order</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i></div>
                <div class="menu-title">Order Manage</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'pending']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Pending Orders <span>({{ $counts['pending'] }})</span></a>
                </li>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'confirm']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Confirmed Orders <span>({{ $counts['confirm'] }})</span></a>
                </li>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'processing']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Processing Orders <span>({{ $counts['processing'] }})</span></a>
                </li>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'picked']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Picked Orders <span>({{ $counts['picked'] }})</span></a>
                </li>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'shipped']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Shipped Orders <span>({{ $counts['shipped'] }})</span></a>
                </li>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'delivered']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Delivered Orders <span>({{ $counts['delivered'] }})</span></a>
                </li>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'completed']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Completed Orders <span>({{ $counts['completed'] }})</span></a>
                </li>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'returned']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Returned Orders <span>({{ $counts['returned'] }})</span></a>
                </li>
                <li><a href="{{ route('admin.orders.by.status', ['status' => 'canceled']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Canceled Orders <span>({{ $counts['canceled'] }})</span></a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Shipping Area</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-location-plus'></i></div>
                <div class="menu-title">Shipping Area</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.division') }}"><i class="bx bx-right-arrow-alt"></i>Division</a></li>
                <li> <a href="{{ route('all.district') }}"><i class="bx bx-right-arrow-alt"></i>District</a></li>
                <li> <a href="{{ route('all.state') }}"><i class="bx bx-right-arrow-alt"></i>State</a></li>
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                </div>
                <div class="menu-title">Components</div>
            </a>
            <ul>
                <li> <a href="component-alerts.html"><i class="bx bx-right-arrow-alt"></i>Alerts</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-repeat"></i>
                </div>
                <div class="menu-title">Content</div>
            </a>
            <ul>
                <li> <a href="content-grid-system.html"><i class="bx bx-right-arrow-alt"></i>Grid System</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"> <i class="bx bx-donate-blood"></i>
                </div>
                <div class="menu-title">Icons</div>
            </a>
            <ul>
                <li> <a href="icons-line-icons.html"><i class="bx bx-right-arrow-alt"></i>Line Icons</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Charts & Maps</li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-line-chart"></i>
                </div>
                <div class="menu-title">Charts</div>
            </a>
            <ul>
                <li> <a href="charts-apex-chart.html"><i class="bx bx-right-arrow-alt"></i>Apex</a>
                </li>
                <li> <a href="charts-chartjs.html"><i class="bx bx-right-arrow-alt"></i>Chartjs</a>
                </li>
                <li> <a href="charts-highcharts.html"><i class="bx bx-right-arrow-alt"></i>Highcharts</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="https://themeforest.net/user/codervent" target="_blank">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->

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

        @if (Auth::user()->can('brand.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-package"></i></div>
                    <div class="menu-title">Brand Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('brand.list'))
                        <li> <a href="{{ route('all.brand') }}"><i class="bx bx-right-arrow-alt"></i>All Brand</a></li>
                    @endif
                    @if (Auth::user()->can('brand.add'))
                        <li> <a href="{{ route('add.brand') }}"><i class="bx bx-right-arrow-alt"></i>Add Brand</a></li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- Category Management Menu --}}
        @if (Auth::user()->can('category.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-list-ul"></i></div>
                    <div class="menu-title">Category</div>
                </a>
                <ul>
                    @if (Auth::user()->can('category.list'))
                        <li> <a href="{{ route('all.category') }}"><i class="bx bx-right-arrow-alt"></i>All Category</a></li>
                    @endif
                    @if (Auth::user()->can('category.add'))
                        <li> <a href="{{ route('add.category') }}"><i class="bx bx-right-arrow-alt"></i>Add Category</a></li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- SubCategory Management Menu --}}
        @if (Auth::user()->can('subcategory.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category-alt"></i></div>
                    <div class="menu-title">SubCategory</div>
                </a>
                <ul>
                    @if (Auth::user()->can('subcategory.list'))
                        <li> <a href="{{ route('all.subcategory') }}"><i class="bx bx-right-arrow-alt"></i>All SubCategory</a></li>
                    @endif
                    @if (Auth::user()->can('subcategory.add'))
                        <li> <a href="{{ route('add.subcategory') }}"><i class="bx bx-right-arrow-alt"></i>Add SubCategory</a></li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- Slider Management Menu --}}
        @if (Auth::user()->can('slider.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-slideshow"></i></div>
                    <div class="menu-title">Slider Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('slider.list'))
                        <li> <a href="{{ route('all.slider') }}"><i class="bx bx-right-arrow-alt"></i>All Slider</a></li>
                    @endif
                    @if (Auth::user()->can('slider.add'))
                        <li> <a href="{{ route('add.slider') }}"><i class="bx bx-right-arrow-alt"></i>Add Slider</a></li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- Banner Management Menu --}}
        @if (Auth::user()->can('banner.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-image"></i></div>
                    <div class="menu-title">Banner Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('banner.list'))
                        <li> <a href="{{ route('all.banner') }}"><i class="bx bx-right-arrow-alt"></i>All Banner</a></li>
                    @endif
                    @if (Auth::user()->can('banner.add'))
                        <li> <a href="{{ route('add.banner') }}"><i class="bx bx-right-arrow-alt"></i>Add Banner</a></li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- Product Management Menu --}}
        @if (Auth::user()->can('product.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-cube"></i></div>
                    <div class="menu-title">Product Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('product.list'))
                        <li> <a href="{{ route('all.product') }}"><i class="bx bx-right-arrow-alt"></i>All Product</a></li>
                    @endif
                    @if (Auth::user()->can('product.add'))
                        <li> <a href="{{ route('add.product') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a></li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- Coupon Management Menu --}}
        @if (Auth::user()->can('coupon.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-gift"></i></div>
                    <div class="menu-title">Coupon Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('coupon.list'))
                        <li> <a href="{{ route('all.coupon') }}"><i class="bx bx-right-arrow-alt"></i>All Coupon</a></li>
                    @endif
                    @if (Auth::user()->can('coupon.add'))
                        <li> <a href="{{ route('add.coupon') }}"><i class="bx bx-right-arrow-alt"></i>Add Coupon</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @php
            use App\Models\Order;

            $counts = [
                'orders' => Order::count(),
                'pending' => Order::where('status', 'pending')->count(),
                'confirm' => Order::where('status', 'confirm')->count(),
                'processing' => Order::where('status', 'processing')->count(),
                'picked' => Order::where('status', 'picked')->count(),
                'shipped' => Order::where('status', 'shipped')->count(),
                'delivered' => Order::where('status', 'delivered')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'returned' => Order::whereNotNull('return_date')->count(),
                'canceled' => Order::where('status', 'canceled')->count(),
                'return_requests' => Order::whereNotNull('return_reason')->whereNull('return_date')->count(),
            ];
        @endphp

        @if (Auth::user()->can('order.menu'))
        <li class="menu-label">Order</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-cart'></i></div>
                    <div class="menu-title">Order Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('order.report'))
                        <li><a href="{{ route('admin.order.report') }}">
                                <i class="bx bx-right-arrow-alt"></i>Orders Report<span>({{ $counts['orders'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.pending'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'pending']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Pending Orders <span>({{ $counts['pending'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.confirm'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'confirm']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Confirmed Orders
                                <span>({{ $counts['confirm'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.processing'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'processing']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Processing Orders
                                <span>({{ $counts['processing'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.picked'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'picked']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Picked Orders <span>({{ $counts['picked'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.shipped'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'shipped']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Shipped Orders <span>({{ $counts['shipped'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.delivered'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'delivered']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Delivered Orders
                                <span>({{ $counts['delivered'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.completed'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'completed']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Completed Orders
                                <span>({{ $counts['completed'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.returned'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'returned']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Returned Orders
                                <span>({{ $counts['returned'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.canceled'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'canceled']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Canceled Orders
                                <span>({{ $counts['canceled'] }})</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->can('order.return_requests'))
                        <li><a href="{{ route('admin.orders.by.status', ['status' => 'return_requests']) }}">
                                <i class="bx bx-right-arrow-alt"></i>Return Requests
                                <span>({{ $counts['return_requests'] }})</span></a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (Auth::user()->can('shipping.area.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-location-plus'></i></div>
                    <div class="menu-title">Shipping Area</div>
                </a>
                <ul>
                    @if (Auth::user()->can('view.division'))
                        <li><a href="{{ route('all.division') }}"><i class="bx bx-right-arrow-alt"></i>Division</a></li>
                    @endif
                    @if (Auth::user()->can('view.district'))
                        <li><a href="{{ route('all.district') }}"><i class="bx bx-right-arrow-alt"></i>District</a></li>
                    @endif
                    @if (Auth::user()->can('view.state'))
                        <li><a href="{{ route('all.state') }}"><i class="bx bx-right-arrow-alt"></i>State</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if (Auth::user()->can('review.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-comment-detail'></i></div>
                    <div class="menu-title">Com. & Reviews</div>
                </a>
                <ul>
                    @if (Auth::user()->can('product.review'))
                        <li><a href="{{ route('admin.review') }}"><i class="bx bx-right-arrow-alt"></i>Product Review</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if (Auth::user()->can('blog.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-pencil'></i></div>
                    <div class="menu-title">Blog Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('blog.category.view'))
                        <li><a href="{{ route('admin.blog.category.index') }}"><i class="bx bx-right-arrow-alt"></i>Blog Categories</a></li>
                    @endif
                    @if (Auth::user()->can('blog.view'))
                        <li><a href="{{ route('admin.blog.index') }}"><i class="bx bx-right-arrow-alt"></i>All Blogs</a></li>
                    @endif
                    @if (Auth::user()->can('blog.create'))
                        <li><a href="{{ route('admin.blog.create') }}"><i class="bx bx-right-arrow-alt"></i>Create Blog</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if (Auth::user()->can('support.menu'))
            <li>
                <a href="https://themeforest.net/user/codervent" target="_blank">
                    <div class="parent-icon"><i class="bx bx-support"></i></div>
                    <div class="menu-title">Support</div>
                </a>
            </li>
        @endif

        @if (Auth::user()->can('settings.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i></div>
                    <div class="menu-title">Setting Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('site.settings'))
                        <li><a href="{{ route('admin.site.setting') }}"><i class="bx bx-right-arrow-alt"></i>Site Setting</a></li>
                    @endif
                    @if (Auth::user()->can('seo.settings'))
                        <li><a href="{{ route('admin.seo.setting') }}"><i class="bx bx-right-arrow-alt"></i>Seo Setting</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if (Auth::user()->can('role.permission.menu'))
        <li class="menu-label">Role Permission</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-shield-quarter"></i></div>
                    <div class="menu-title">Role Permission</div>
                </a>
                <ul>
                    @if (Auth::user()->can('view.all.permission'))
                        <li><a href="{{ route('all.permission') }}"><i class="bx bx-right-arrow-alt"></i>All Permission</a></li>
                    @endif
                    @if (Auth::user()->can('view.role.permission'))
                        <li><a href="{{ route('index.role.permission') }}"><i class="bx bx-right-arrow-alt"></i>All Roles in Permission</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if (Auth::user()->can('admin.manage.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-id-card"></i></div>
                    <div class="menu-title">Admin Manage</div>
                </a>
                <ul>
                    @if (Auth::user()->can('view.all.admins'))
                        <li><a href="{{ route('all.admins') }}"><i class="bx bx-right-arrow-alt"></i>All Admin</a></li>
                    @endif
                </ul>
            </li>
        @endif


        @if (Auth::user()->can('user.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-group"></i></div>
                    <div class="menu-title">User Management</div>
                </a>
                <ul>
                    @if (Auth::user()->can('vendor.user.menu'))
                        <li>
                            <a class="has-arrow" href="javascript:;">
                                <i class="bx bx-right-arrow-alt"></i>Vendor Users
                            </a>
                            <ul>
                                @if (Auth::user()->can('vendor.inactive'))
                                    <li><a href="{{ route('inactive.vendor') }}"><i class="bx bx-right-arrow-alt"></i>Inactive Vendors</a></li>
                                @endif
                                @if (Auth::user()->can('vendor.active'))
                                    <li><a href="{{ route('active.vendor') }}"><i class="bx bx-right-arrow-alt"></i>Active Vendors</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Auth::user()->can('general.user.menu'))
                        <li>
                            <a class="has-arrow" href="javascript:;">
                                <i class="bx bx-right-arrow-alt"></i>General Users
                            </a>
                            <ul>
                                @if (Auth::user()->can('view.all.users'))
                                    <li><a href="{{ route('all.users') }}"><i class="bx bx-right-arrow-alt"></i>All Users</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->

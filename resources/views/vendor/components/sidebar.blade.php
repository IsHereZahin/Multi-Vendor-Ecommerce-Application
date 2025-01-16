@php
	$id = Auth::user()->id;
    $vendor = App\Models\User::find($id);
    $verdorId = $vendor;
	$status = $vendor->status;
    $status = $vendor->status;

    use App\Models\OrderItem;

    // Fetch order counts specific to the authenticated vendor
    $counts = [
        'pending' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'pending');
            })->count(),
        'confirm' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'confirm');
            })->count(),
        'processing' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'processing');
            })->count(),
        'picked' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'picked');
            })->count(),
        'shipped' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'shipped');
            })->count(),
        'delivered' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'delivered');
            })->count(),
        'completed' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })->count(),
        'returned' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->whereNotNull('return_date');
            })->count(),
        'canceled' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'canceled');
            })->count(),
        'return_requests' => OrderItem::where('vendor_id', $id)
            ->whereHas('order', function ($query) {
                $query->whereNotNull('return_reason')
                    ->whereNull('return_date');
            })->count(),
    ];
@endphp

<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div>
			<img src="{{ asset('adminbackend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
		</div>
		<div>
			<h4 class="logo-text">Vendor</h4>
		</div>
		<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
		</div>
	</div>
	<!--navigation-->
	<ul class="metismenu" id="menu">
        <li>
			<a href="{{ route('vendor.dashboard') }}">
				<div class="parent-icon"><i class='bx bx-home-circle'></i>
				</div>
				<div class="menu-title">Dashboard</div>
			</a>
		</li>

        @if($status === 'active')
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class="bx bx-category"></i>
				</div>
				<div class="menu-title">Product Manage</div>
			</a>
			<ul>
				<li> <a href="{{ route('vendor.all.product') }}"><i class="bx bx-right-arrow-alt"></i>All Product</a>
                <li> <a href="{{ route('vendor.add.product') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
			</ul>
		</li>

        <li class="menu-label">Order</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i></div>
                <div class="menu-title">Order Manage</div>
            </a>
            <ul>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'pending']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Pending Orders <span>({{ $counts['pending'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'confirm']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Confirmed Orders <span>({{ $counts['confirm'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'processing']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Processing Orders <span>({{ $counts['processing'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'picked']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Picked Orders <span>({{ $counts['picked'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'shipped']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Shipped Orders <span>({{ $counts['shipped'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'delivered']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Delivered Orders <span>({{ $counts['delivered'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'completed']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Completed Orders <span>({{ $counts['completed'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'returned']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Returned Orders <span>({{ $counts['returned'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'canceled']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Canceled Orders <span>({{ $counts['canceled'] }})</span></a>
                </li>
                <li><a href="{{ route('vendor.orders.by.status', ['status' => 'return_requests']) }}">
                    <i class="bx bx-right-arrow-alt"></i>Return Requests <span>({{ $counts['return_requests'] }})</span></a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Comment and Review</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-comment-detail'></i></div>
                <div class="menu-title">Com. & Reviews</div>
            </a>
            <ul>
                <li> <a href="{{ route('vendor.review') }}"><i class="bx bx-right-arrow-alt"></i>Product Review</a></li>
            </ul>
        </li>
        @endif
		<li class="menu-label">Charts</li>
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

@php
	$id = Auth::user()->id;
	$verdorId = App\Models\User::find($id);
	$status = $verdorId->status;
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
				<li> <a href="index.html"><i class="bx bx-right-arrow-alt"></i>All Product</a>
                <li> <a href="dashboard-eCommerce.html"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
			</ul>
		</li>

        {{-- Order --}}
		<li class="menu-label">Order</li>
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class='bx bx-cart'></i>
				</div>
				<div class="menu-title">All Order</div>
			</a>
			<ul>
				<li> <a href="ecommerce-products.html"><i class="bx bx-right-arrow-alt"></i>All Order</a>
				</li>
				<li> <a href="ecommerce-products-details.html"><i class="bx bx-right-arrow-alt"></i>Add Order</a>
				</li>
			</ul>
		</li>
        @else

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

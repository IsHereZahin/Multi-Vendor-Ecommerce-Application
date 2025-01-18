@extends('admin.components.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Coupons</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">All Coupons (<span style="color: rgb(0, 119, 255);">{{ count($coupons) }}</span>)</li>
                    </ol>
                </nav>
            </div>
            @if (Auth::user()->can('coupon.add'))
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.coupon') }}" class="btn btn-primary">Add Coupon</a>
                </div>
            </div>
            @endif
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Coupon Code</th>
                                <th>Discount (%)</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $key => $coupon)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>
                                        @if ($coupon->discount == 0)
                                            <span class="badge rounded-pill bg-light-warning text-warning w-100">No Discount</span>
                                        @else
                                            <span class="badge rounded-pill bg-light-success text-success w-100">{{ $coupon->discount }}%</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('F d, Y') }}</td>
                                    <td>
                                        @if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($coupon->expiry_date)))
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif($coupon->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (Auth::user()->can('coupon.edit'))
                                            <!-- Edit Button -->
                                            <a href="{{ route('edit.coupon', $coupon->id) }}" class="btn btn-info">Edit</a>
                                        @endif

                                        @if (Auth::user()->can('coupon.delete'))
                                            <!-- Delete Button -->
                                            <form action="{{ route('delete.coupon', $coupon->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the coupon with code: {{ $coupon->code }}?')">Delete</button>
                                            </form>
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
@endsection

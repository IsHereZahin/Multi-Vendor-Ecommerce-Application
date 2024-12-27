@extends('admin.components.master')
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">All Products (<span
                                style="color: rgb(0, 119, 255);">{{ count($products) }}</span>)</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.product') }}" class="btn btn-primary">Add Product</a>
                </div>
            </div>
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
                                <th>Image </th>
                                <th>Product Name </th>
                                <th>Price </th>
                                <th>Discount </th>
                                <th>QTY </th>
                                <th>Status </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> <img src="{{ asset($item->product_thumbnail) }}" style="width: 70px; height:40px;">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->selling_price }}</td>
                                    <td>
                                        @if ($item->selling_price == 0)
                                            <span class="badge rounded-pill bg-light-warning text-warning w-100">
                                                Price Not Available
                                            </span>
                                        @elseif ($item->discount_price < 0 || $item->discount_price > $item->selling_price)
                                            <span class="badge rounded-pill bg-light-danger text-danger w-100">
                                                Invalid Discount
                                            </span>
                                        @elseif ($item->discount_price == 0)
                                            <span class="badge rounded-pill bg-light-danger text-danger w-100">
                                                No Discount Available
                                            </span>
                                        @elseif ($item->discount_price == $item->selling_price)
                                            <span class="badge rounded-pill bg-light-danger text-danger w-100">
                                                {{ $item->discount_price }}
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-light-success text-success w-100">
                                                {{ $item->discount_price }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->product_qty }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <form method="post" action="{{ route('inactive.product.approve') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-sm btn-success w-100">Active</button>
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('active.product.approve') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit"
                                                    class="btn btn-sm btn-secondary w-100">Inactive</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('edit.product', $item->id) }}" class="btn btn-info">Edit</a>
                                        <a href="{{ route('delete.product', $item->id) }}" class="btn btn-danger"
                                            id="delete">Delete</a>
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

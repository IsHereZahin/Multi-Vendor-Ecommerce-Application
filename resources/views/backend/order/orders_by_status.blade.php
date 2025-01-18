@extends('admin.components.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Orders</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ ucfirst($status) }} Orders
                            (<span style="color: rgb(0, 119, 255);">{{ count($orders) }}</span>)
                        </li>
                    </ol>
                </nav>
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
                                            @if($item->status == 'pending') bg-warning text-dark
                                            @elseif($item->status == 'confirm') bg-primary text-white
                                            @elseif($item->status == 'processing') bg-info text-dark
                                            @elseif($item->status == 'picked') bg-secondary text-white
                                            @elseif($item->status == 'shipped') bg-light text-dark
                                            @elseif($item->status == 'delivered') bg-success text-white
                                            @elseif($item->status == 'completed') bg-dark text-white
                                            @elseif($item->status == 'returned') bg-danger text-white
                                            @elseif($item->status == 'canceled') bg-light-danger text-danger
                                            @else bg-light text-dark
                                            @endif">
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
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

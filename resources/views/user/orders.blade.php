@extends('user.user_dashboard_master')

@section('user-dashboard')
<div class="card">
    <div class="card-header">
        <h5>
            Your Orders -
            @switch($status)
                @case('pending')
                    Pending Orders
                    @break
                @case('canceled')
                    Canceled Orders
                    @break
                @case('delivered')
                    Delivered Orders
                    @break
                @case('return_requests')
                    Return Requests
                    @break
                @case('returns')
                    Returned Orders
                    @break
                @default
                    All Orders
            @endswitch
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Invoice</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Amount</th>

                        <!-- Show Return Reason Column only for 'return_requests' and 'returns' statuses -->
                        @if($status == 'return_requests' || $status == 'returns')
                            <th>Return Reason</th>
                        @endif

                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->created_at->format('F d, Y') }}</td>
                            <td>{{ $order->invoice_no }}</td>
                            <td>
                                <span class="badge
                                    @if($order->status == 'pending')
                                        bg-primary
                                    @elseif($order->status == 'confirmed')
                                        bg-secondary
                                    @elseif($order->status == 'picked')
                                        bg-info
                                    @elseif($order->status == 'shipped')
                                        bg-dark
                                    @elseif($order->status == 'delivered')
                                        bg-success
                                    @elseif($order->status == 'canceled')
                                        bg-danger
                                    @elseif($order->status == 'returned')
                                        bg-muted
                                    @else
                                        bg-warning text-dark
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->payment_method }}</td>
                            <td>${{ number_format($order->amount, 2) }}</td>

                            <!-- Display Return Reason if the order status is 'return_requests' or 'returns' -->
                            @if($status == 'return_requests' || $status == 'returns')
                                <td>
                                    @if($order->return_reason)
                                        <span>{{ $order->return_reason }}</span>
                                    @else
                                        <span class="text-muted">No reason provided</span>
                                    @endif
                                </td>
                            @endif

                            <td>
                                <a href="{{ route('user.order.details', $order->invoice_no) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('order.downloadInvoice', $order->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-file-earmark-text"></i> Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $status == 'return_requests' || $status == 'returns' ? '8' : '7' }}" class="text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

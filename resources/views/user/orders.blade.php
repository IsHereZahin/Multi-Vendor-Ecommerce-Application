@extends('user.user_dashboard_master')

@section('user-dashboard')
<div class="card">
    <div class="card-header">
        <h5>Your Orders</h5>
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
                                <span class="badge bg-{{ $order->status == 'Completed' ? 'success' : ($order->status == 'Processing' ? 'warning text-dark' : 'danger') }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->payment_method }}</td>
                            <td>${{ number_format($order->amount, 2) }}</td>
                            <td>
                                <a href="{{ route('user.order.details', $order->invoice_no) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-file-earmark-text"></i> Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

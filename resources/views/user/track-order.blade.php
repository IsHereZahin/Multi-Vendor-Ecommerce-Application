@extends('user.user_dashboard_master')

@section('user-dashboard')
    <div class="card" @if (isset($track)) hidden @endif>
        <div class="card-header">
            <h3 class="mb-0">Track Your Order</h3>
        </div>
        <div class="card-body">
            <p>Enter your Invoice ID and Billing Email to track your order.</p>

            <form action="{{ route('user.track.order') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Invoice ID</label>
                    <input name="invoice_no" placeholder="Invoice ID" type="text" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Billing Email</label>
                    <input name="billing_email" placeholder="Email" type="email" class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary">Track Order</button>
            </form>
        </div>
    </div>

    @if (isset($track))
        @section('title')
            Order Tracking Page
        @endsection

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
            integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style type="text/css">
            body {}

            .container {}

            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                background-color: #fff;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 0.10rem;
            }

            .card-header:first-child {
                border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0;
            }

            .card-header {
                padding: 0.75rem 1.25rem;
                margin-bottom: 0;
                background-color: #fff;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .track {
                position: relative;
                background-color: #ddd;
                height: 7px;
                display: flex;
                margin-bottom: 60px;
                margin-top: 50px;
            }

            .track .step {
                flex-grow: 1;
                width: 12%;
                margin-top: -18px;
                text-align: center;
                position: relative;
            }

            .track .step.active:before {
                background: #3BB77E;
            }

            .track .step::before {
                height: 7px;
                position: absolute;
                content: "";
                width: 100%;
                left: 0;
                top: 18px;
            }

            .track .step.active .icon {
                background: #3BB77E;
                color: #fff;
            }

            .track .icon {
                display: inline-block;
                width: 40px;
                height: 40px;
                line-height: 40px;
                position: relative;
                border-radius: 100%;
                background: #ddd;
            }

            .track .step.active .text {
                font-weight: 400;
                color: #000;
            }

            .track .text {
                display: block;
                margin-top: 7px;
            }

            .itemside {
                display: flex;
                width: 100%;
            }

            .itemside .info {
                padding-left: 15px;
                padding-right: 7px;
            }

            .itemside .title {
                display: block;
                margin-bottom: 5px;
                color: #212529;
            }

            p {
                margin-top: 0;
                margin-bottom: 1rem;
            }

            .btn-warning {
                color: #ffffff;
                background-color: #3BB77E;
                border-color: #3BB77E;
                border-radius: 1px;
            }

            .btn-warning:hover {
                color: #ffffff;
                background-color: #ff2b00;
                border-color: #ff2b00;
                border-radius: 1px;
            }
        </style>

        <div class="container">
            <article class="card">
                <header class="card-header"> My Orders / Tracking </header>
                <div class="card-body">
                    <h6>Invoice Number : {{ $track->invoice_no }} </h6>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col"> <strong>Order Date:</strong> <br>{{ $track->order_date }} </div>
                            <div class="col"> <strong>Shipping BY:</strong> <br> {{ $track->name }} | <i
                                    class="fa fa-phone"></i>{{ $track->phone }} / {{ $track->division->division_name }} /
                                {{ $track->district->district_name }} </div>
                            <div class="col"> <strong>Payment Method:</strong> <br>{{ $track->payment_method }} </div>
                            <div class="col"> <strong>Total Amount #:</strong> <br>${{ $track->amount }}</div>
                        </div>
                    </article>
                    @php
                        function getStatusIcon($status)
                        {
                            switch ($status) {
                                case 'pending':
                                    return 'fa-clock';
                                case 'confirm':
                                    return 'fa-user-check';
                                case 'processing':
                                    return 'fa-cogs';
                                case 'picked':
                                    return 'fa-check-circle';
                                case 'shipped':
                                    return 'fa-truck';
                                case 'delivered':
                                    return 'fa-box-open';
                                case 'completed':
                                    return 'fa-thumbs-up';
                                case 'returned':
                                    return 'fa-undo';
                                case 'canceled':
                                    return 'fa-times-circle';
                                case 'return_requests':
                                    return 'fa-exclamation-triangle';
                                default:
                                    return 'fa-question-circle';
                            }
                        }
                    @endphp
                    <div class="track">
                        <div
                            class="step {{ in_array($track->status, ['pending', 'confirm', 'processing', 'picked', 'shipped', 'delivered', 'completed']) ? 'active' : '' }}">
                            <span class="icon">
                                <i class="fa {{ getStatusIcon('pending') }}"></i>
                                <div class="date-tooltip">
                                    {{ $track->order_date ? \Carbon\Carbon::parse($track->order_date)->format('j M, Y h:i A') : '' }}
                                </div>
                            </span>
                            <span class="text">Pending</span>
                        </div>

                        <div
                            class="step {{ in_array($track->status, ['confirm', 'processing', 'picked', 'shipped', 'delivered', 'completed']) ? 'active' : '' }}">
                            <span class="icon">
                                <i class="fa {{ getStatusIcon('confirm') }}"></i>
                                <div class="date-tooltip">
                                    {{ $track->confirmed_date ? \Carbon\Carbon::parse($track->confirmed_date)->format('j M, Y h:i A') : '' }}
                                </div>
                            </span>
                            <span class="text">Confirmed</span>
                        </div>

                        <div
                            class="step {{ in_array($track->status, ['processing', 'picked', 'shipped', 'delivered', 'completed']) ? 'active' : '' }}">
                            <span class="icon">
                                <i class="fa {{ getStatusIcon('processing') }}"></i>
                                <div class="date-tooltip">
                                    {{ $track->processing_date ? \Carbon\Carbon::parse($track->processing_date)->format('j M, Y h:i A') : '' }}
                                </div>
                            </span>
                            <span class="text">Processing</span>
                        </div>

                        <div
                            class="step {{ in_array($track->status, ['picked', 'shipped', 'delivered', 'completed']) ? 'active' : '' }}">
                            <span class="icon">
                                <i class="fa {{ getStatusIcon('picked') }}"></i>
                                <div class="date-tooltip">
                                    {{ $track->picked_date ? \Carbon\Carbon::parse($track->picked_date)->format('j M, Y h:i A') : '' }}
                                </div>
                            </span>
                            <span class="text">Picked</span>
                        </div>

                        <div
                            class="step {{ in_array($track->status, ['shipped', 'delivered', 'completed']) ? 'active' : '' }}">
                            <span class="icon">
                                <i class="fa {{ getStatusIcon('shipped') }}"></i>
                                <div class="date-tooltip">
                                    {{ $track->shipped_date ? \Carbon\Carbon::parse($track->shipped_date)->format('j M, Y h:i A') : '' }}
                                </div>
                            </span>
                            <span class="text">Shipped</span>
                        </div>

                        <div class="step {{ in_array($track->status, ['delivered', 'completed']) ? 'active' : '' }}">
                            <span class="icon">
                                <i class="fa {{ getStatusIcon('delivered') }}"></i>
                                <div class="date-tooltip">
                                    {{ $track->delivered_date ? \Carbon\Carbon::parse($track->delivered_date)->format('j M, Y h:i A') : '' }}
                                </div>
                            </span>
                            <span class="text">Delivered</span>
                        </div>

                        @if (!is_null($track->return_reason))
                            <div class="step active">
                                <span class="icon">
                                    <i class="fa {{ getStatusIcon('return_requests') }}"></i>
                                    <div class="date-tooltip">
                                        {{ $track->return_date ? \Carbon\Carbon::parse($track->return_date)->format('j M, Y h:i A') : '' }}
                                    </div>
                                </span>
                                <span class="text">Return Requested</span>
                            </div>
                        @endif

                        @if ($track->status == 'returned')
                            <div class="step active">
                                <span class="icon">
                                    <i class="fa {{ getStatusIcon('returned') }}"></i>
                                    <div class="date-tooltip">
                                        {{ $track->return_date ? \Carbon\Carbon::parse($track->return_date)->format('j M, Y h:i A') : '' }}
                                    </div>
                                </span>
                                <span class="text">Returned</span>
                            </div>
                        @endif

                        @if ($track->status == 'canceled')
                            <div class="step active">
                                <span class="icon">
                                    <i class="fa {{ getStatusIcon('canceled') }}"></i>
                                    <div class="date-tooltip">
                                        {{ $track->updated_at ? \Carbon\Carbon::parse($track->updated_at)->format('j M, Y h:i A') : '' }}
                                    </div>
                                </span>
                                <span class="text">Canceled</span>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <a href="{{ route('user.track.orders') }}" class="btn btn-warning" data-abc="true"> <i
                            class="fa fa-chevron-left"></i>Back</a>
                </div>
            </article>
        </div>

        <style>
            .icon i {
                cursor: pointer;
            }

            .date-tooltip {
                display: none;
                position: absolute;
                top: 40px;
                left: 0;
                background-color: #333;
                color: #fff;
                padding: 5px;
                border-radius: 5px;
                font-size: 12px;
                white-space: nowrap;
            }

            .step .icon:hover .date-tooltip {
                display: block;
            }
        </style>
    @endif
@endsection

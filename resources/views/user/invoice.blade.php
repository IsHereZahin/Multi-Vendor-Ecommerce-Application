<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->invoice_no }}</title>
</head>

<body
    style="font-family: 'Helvetica Neue', Arial, sans-serif; margin: 0; padding: 40px 20px; background: linear-gradient(135deg, #f6f9fc 0%, #ecf1f7 100%);">
    <div
        style="max-width: 850px; margin: 0 auto; background: white; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); overflow: hidden;">
        <!-- Top Banner -->
        <table style="width: 100%; background: linear-gradient(90deg, #1a365d 0%, #2c5282 100%); color: white;">
            <tr>
                <td style="padding: 40px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <h1 style="margin: 0; font-size: 42px; font-weight: 700; letter-spacing: -1px;">INVOICE
                                </h1>
                                <p style="margin: 8px 0 0; opacity: 0.9; font-size: 15px;">#{{ $order->invoice_no }}</p>
                            </td>
                            @if ($order->transaction_id)
                                <td style="width: 50%; text-align: right;">
                                    <div
                                        style="background: transparent; color: white; padding: 10px 15px; border-radius: 8px; display: inline-block;">
                                        <p style="margin: 0; font-size: 14px;">Transaction ID</p>
                                        <p style="margin: 5px 0 0; font-weight: 600;">
                                            {{ $order->transaction_id ?? 'N/A' }}</p>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Main Content -->
        <div style="padding: 40px;">
            <!-- Info Grid -->
            <table style="width: 100%; border-collapse: separate; border-spacing: 30px 0; margin-bottom: 40px;">
                <tr>
                    <!-- Shipping Info -->
                    <td
                        style="width: 50%; background: #f8fafc; border-radius: 12px; padding: 25px; vertical-align: top;">
                        <h3 style="margin: 0 0 20px; color: #1a365d; font-size: 18px; font-weight: 600;">Shipping
                            Details</h3>
                        <div style="font-size: 14px; line-height: 1.6;">
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Name:</strong> {{ $order->name }}
                            </p>
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Email:</strong>
                                {{ $order->email }}</p>
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Phone:</strong>
                                {{ $order->phone }}</p>
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Address:</strong>
                                {{ $order->address ?? 'N/A' }}</p>
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Post Code:</strong>
                                {{ $order->post_code ?? 'N/A' }}</p>
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Notes:</strong>
                                {{ $order->notes ?? 'N/A' }}</p>
                        </div>
                    </td>

                    <!-- Order Info -->
                    <td
                        style="width: 50%; background: #f8fafc; border-radius: 12px; padding: 25px; vertical-align: top;">
                        <h3 style="margin: 0 0 20px; color: #1a365d; font-size: 18px; font-weight: 600;">Order Details
                        </h3>
                        <div style="font-size: 14px; line-height: 1.6;">
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Order Date:</strong>
                                {{ $order->order_date }}</p>
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Status:</strong> <span
                                    style="background: #c6f6d5; color: #22543d; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ ucfirst($order->status) }}</span>
                            </p>
                            <p style="margin: 8px 0;"><strong style="color: #4a5568;">Payment Method:</strong>
                                {{ $order->payment_method ?? 'N/A' }}</p>
                            <p style="margin: 16px 0; font-size: 20px; color: #1a365d;"><strong>Total Amount:</strong>
                                ${{ number_format($order->amount, 2) }}</p>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Order Items -->
            <div style="margin-bottom: 40px;">
                <h3 style="margin: 0 0 20px; color: #1a365d; font-size: 18px; font-weight: 600;">Order Items</h3>
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 8px;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th
                                style="padding: 12px 15px; text-align: left; color: #4a5568; font-weight: 600; border-radius: 8px 0 0 8px;">
                                Product</th>
                            <th style="padding: 12px 15px; text-align: left; color: #4a5568; font-weight: 600;">Details
                            </th>
                            <th style="padding: 12px 15px; text-align: center; color: #4a5568; font-weight: 600;">
                                Quantity</th>
                            <th
                                style="padding: 12px 15px; text-align: right; color: #4a5568; font-weight: 600; border-radius: 0 8px 8px 0;">
                                Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItem as $item)
                            <tr style="background: #f8fafc;">
                                <td style="padding: 15px; border-radius: 8px 0 0 8px;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 60px;">
                                                <img src="{{ $item->product->product_thumbnail }}"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                                                    alt="{{ $item->product->product_name }}">
                                            </td>
                                            <td style="padding-left: 15px;">
                                                <span
                                                    style="font-weight: 500;">{{ $item->product->product_name }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="padding: 15px;">
                                    <p style="margin: 0; font-size: 14px;">Color: <span
                                            style="color: #4a5568;">{{ $item->color ?? 'N/A' }}</span></p>
                                    <p style="margin: 4px 0 0; font-size: 14px;">Size: <span
                                            style="color: #4a5568;">{{ $item->size ?? 'N/A' }}</span></p>
                                </td>
                                <td style="padding: 15px; text-align: center;">{{ $item->qty }}</td>
                                <td
                                    style="padding: 15px; text-align: right; font-weight: 600; border-radius: 0 8px 8px 0;">
                                    ${{ number_format($item->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total -->
            <table style="width: 100%; margin-bottom: 40px;">
                <tr>
                    <td style="background: #1a365d; color: white; padding: 20px 25px; border-radius: 12px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="font-size: 18px; font-weight: 600;">Total Amount</td>
                                <td style="color: white; text-align: right; font-size: 24px; font-weight: 700;">
                                    ${{ number_format($order->amount, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <div style="text-align: center; color: #718096; font-size: 13px;">
                <p style="margin: 0;">&copy; {{ date('d F Y') }} Easy Shop. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>

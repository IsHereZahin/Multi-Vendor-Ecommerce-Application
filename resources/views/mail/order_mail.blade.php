<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Your Order Has Been Placed!</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: Arial, sans-serif; color: #333;">

    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); overflow: hidden;">

        <!-- Header -->
        <div style="background-color: #2d3748; padding: 20px; color: #fff; text-align: center;">
            <img src="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" alt="Easy Shop Logo"
                style="width: 80px; margin-bottom: 15px;">
            <h2 style="font-size: 24px; margin: 0;">Thank You for Your Order!</h2>
        </div>

        <!-- Body -->
        <div style="padding: 30px; font-size: 16px; line-height: 1.5;">
            <!-- Greeting with Larger Name -->
            <h1 style="color: #4a5568; font-size: 26px; margin-bottom: 5px;">Hello {{ $order['name'] }}!</h1>
            <!-- Email below name in smaller font -->
            <p style="color: #4a5568; font-size: 14px; margin-bottom: 20px;">Your email: <strong>{{ $order['email']
                    }}</strong></p>

            <p style="color: #2d3748;">We’ve received your order and are currently processing it. Below are your order
                details:</p>

            <!-- Order Details -->
            <div style="background-color: #edf2f7; padding: 15px; border-radius: 6px; margin-top: 20px;">
                <p style="margin: 5px 0; color: #4a5568;"><strong>Invoice Number:</strong> {{ $order['invoice_no'] }}
                </p>
                <p style="margin: 5px 0; color: #4a5568;"><strong>Amount:</strong> ${{ number_format($order['amount'],
                    2) }}</p>
                <p style="margin: 5px 0; color: #4a5568;"><strong>Payment Method:</strong> {{ $order['payment_method']
                    }}</p>
                <p style="margin: 5px 0; color: #4a5568;"><strong>Shipping Address:</strong> {{
                    $order['shipping_address'] }}</p>
            </div>

            <!-- Action Button -->
            <a href="#"
                style="display: inline-block; padding: 10px 20px; background-color: #3182ce; color: #fff; text-decoration: none; border-radius: 4px; margin-top: 20px;">View
                Your Order Details</a>
        </div>

        <!-- Footer -->
        <div style="background-color: #f1f5f9; text-align: center; padding: 15px; font-size: 12px; color: #718096;">
            <p>If you have any questions, please contact our support team.</p>
            <p>© 2025 Easy Shop. All rights reserved.</p>
        </div>
    </div>

</body>

</html>

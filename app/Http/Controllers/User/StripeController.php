<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function StripeOrder(Request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51Qd87wEaVIXahkGHRG3UbQ6qzUDdErm7X9q6ELtW9NyvgGICClKhghCXL9sB8cEPwIBeMvUir6BCcg3WQOUanh6z00Bd2rzKRB'); // Secret key

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
            'amount' => 999*100,
            'currency' => 'usd',
            'description' => 'Easy Multi Vendor Shop Payment',
            'source' => $token,
            'metadata' => ['order_id' => '6735'],
        ]);

        dd($charge);
    }
}

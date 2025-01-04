<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function StripeOrder(Request $request)
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        // Calculate the total amount
        $total = $cartItems->sum(function ($item) {
            return ($item->product->selling_price - $item->product->discount_price) * $item->quantity;
        });

        $finalTotal = $total;

        // Apply the coupon discount if a valid coupon is present in the session
        if (Session::has('coupon')) {
            $coupon = session('coupon');
            $finalTotal = $total - (($total * $coupon['discount']) / 100);
        }

        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
            'amount' => $finalTotal * 100,
            'currency' => 'usd',
            'description' => 'Easy Multi Vendor Shop Payment',
            'source' => $token,
            'metadata' => ['order_id' => uniqid()],
        ]);

        // dd($charge);

        $order_id = Order::insertGetId([
            // Customer Info
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address ?? null,
            'post_code' => $request->post_code ?? null,
            'notes' => $request->notes ?? null,

            // Payment Info
            'payment_type' => $charge->payment_method,
            'payment_method' => 'Stripe',
            'transaction_id' => $charge->balance_transaction,
            'currency' => $charge->currency,
            'amount' => $finalTotal,

            // Order Info
            'order_number' => $charge->metadata->order_id,
            'invoice_no' => 'EOS' . mt_rand(10000000, 99999999),
            'confirmed_date' => $request->confirmed_date ?? null,
            'processing_date' => $request->processing_date ?? null,
            'picked_date' => $request->picked_date ?? null,
            'shipped_date' => $request->shipped_date ?? null,
            'delivered_date' => $request->delivered_date ?? null,
            'cancel_date' => $request->cancel_date ?? null,
            'return_date' => $request->return_date ?? null,
            'return_reason' => $request->return_reason ?? null,

            // Geographic Info
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_id' => $request->state_id,

            // Date Info
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),

            // Status and Time
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Start Send Email

        $invoice = Order::findOrFail($order_id);

        $data = [

            'invoice_no' => $invoice->invoice_no,
            'amount' => $finalTotal,
            'name' => $invoice->name,
            'email' => $invoice->email,
            'payment_method' => $invoice->payment_method,
            'shipping_address' => $invoice->address,

        ];

        Mail::to($request->email)->send(new OrderMail($data));

        // End Send Email

        foreach ($cartItems as $item) {
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $item->product->id,
                'vendor_id' => $item->product->vendor_id,
                'color' => $item->color ?? null,
                'size' => $item->size ?? null,
                'qty' => $item->quantity,
                'price' => $item->product->selling_price,
                'created_at' => Carbon::now(),
            ]);
        }

        // Clear coupon if applied
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        if (Cart::where('user_id', auth()->id())->exists()) {
            Cart::where('user_id', auth()->id())->delete();
        } else {
            return response()->json(['message' => 'No items to delete']);
        }

        Session::flash('message', 'Your order has been placed successfully!');
        Session::flash('alert-type', 'success');

        return redirect()->route('home');
    }

    public function cashOnDeliveryOrder(Request $request)
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        // Calculate the total amount
        $total = $cartItems->sum(function ($item) {
            return ($item->product->selling_price - $item->product->discount_price) * $item->quantity;
        });

        $finalTotal = $total;

        // Apply the coupon discount if a valid coupon is present in the session
        if (Session::has('coupon')) {
            $coupon = session('coupon');
            $finalTotal = $total - (($total * $coupon['discount']) / 100);
        }

        $order_id = Order::insertGetId([
            // Customer Info
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address ?? null,
            'post_code' => $request->post_code ?? null,
            'notes' => $request->notes ?? null,

            // Payment Info
            'payment_type' => 'Cash On Delivery',
            'payment_method' => 'Cash On Delivery',
            'currency' => 'USD',
            'amount' => $finalTotal,

            // Order Info
            'invoice_no' => 'EOS' . mt_rand(10000000, 99999999),
            'confirmed_date' => $request->confirmed_date ?? null,
            'processing_date' => $request->processing_date ?? null,
            'picked_date' => $request->picked_date ?? null,
            'shipped_date' => $request->shipped_date ?? null,
            'delivered_date' => $request->delivered_date ?? null,
            'cancel_date' => $request->cancel_date ?? null,
            'return_date' => $request->return_date ?? null,
            'return_reason' => $request->return_reason ?? null,

            // Geographic Info
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_id' => $request->state_id,

            // Date Info
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),

            // Status and Time
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Start Send Email

        $invoice = Order::findOrFail($order_id);

        $data = [

            'invoice_no' => $invoice->invoice_no,
            'amount' => $finalTotal,
            'name' => $invoice->name,
            'email' => $invoice->email,
            'payment_method' => 'Cash On Delivery',
            'shipping_address' => $invoice->address,

        ];

        Mail::to($request->email)->send(new OrderMail($data));

        // End Send Email

        foreach ($cartItems as $item) {
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $item->product->id,
                'vendor_id' => $item->product->vendor_id,
                'color' => $item->color ?? null,
                'size' => $item->size ?? null,
                'qty' => $item->quantity,
                'price' => $item->product->selling_price,
                'created_at' => Carbon::now(),
            ]);
        }

        // Clear coupon if applied
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        if (Cart::where('user_id', auth()->id())->exists()) {
            Cart::where('user_id', auth()->id())->delete();
        } else {
            return response()->json(['message' => 'No items to delete']);
        }

        Session::flash('message', 'Your order has been placed successfully!');
        Session::flash('alert-type', 'success');

        return redirect()->route('home');
    }
}

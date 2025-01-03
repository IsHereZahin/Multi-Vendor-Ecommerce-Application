<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ShipDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    // Check Out Module
    public function checkout(Request $request)
    {
        // Check if the cart is empty
        $cartItems = Cart::where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            session()->flash('message', 'Your cart is empty. Please add at least one item to checkout.');
            session()->flash('alert-type', 'info');
            return redirect()->route('home');
        }

        // Check if a color and size are selected for items that require them
        foreach ($cartItems as $cartItem) {
            if (($cartItem->product->product_color && !$cartItem->color) || ($cartItem->product->product_size && !$cartItem->size)) {
                session()->flash('message', 'Please select a color and size for all applicable items.');
                session()->flash('alert-type', 'error');
                return redirect()->route('cart.index');
            }
        }

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

        // Shipping Address data
        $divisions = ShipDivision::orderBy('division_name', 'ASC')->get();

        return view('frontend.cart.checkout', compact('cartItems', 'total', 'finalTotal', 'divisions'));
    }

    public function CheckoutStore(Request $request)
    {
        $shippingDetails = [
            'shipping_name' => $request->shipping_name,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $request->shipping_phone,
            'shipping_division' => $request->shipping_division,
            'shipping_district' => $request->shipping_district,
            'shipping_state' => $request->shipping_state,
            'shipping_full_address' => $request->shipping_full_address,
            'shipping_post_code' => $request->shipping_post_code,
            'shipping_notes' => $request->shipping_notes,
        ];

        // Get cart items for the logged-in user
        $cartItems = Cart::where('user_id', auth()->id())->get();

        // Check if a color and size are selected for items that require them
        foreach ($cartItems as $cartItem) {
            if (($cartItem->product->product_color && !$cartItem->color) || ($cartItem->product->product_size && !$cartItem->size)) {
                session()->flash('message', 'Please select a color and size for all applicable items.');
                session()->flash('alert-type', 'error');
                return redirect()->route('cart.index');
            }
        }

        // Calculate the total price of items in the cart
        $total = $cartItems->sum(function ($item) {
            return ($item->product->selling_price - $item->product->discount_price) * $item->quantity;
        });

        $finalTotal = $total;

        // Apply discount if a valid coupon exists
        if (Session::has('coupon')) {
            $coupon = session('coupon');
            $finalTotal = $total - (($total * $coupon['discount']) / 100);
        }

        // Pass data to the view
        if ($request->payment_option == 'stripe') {
            return view('frontend.payment.stripe', compact('shippingDetails', 'cartItems', 'finalTotal', 'total'));
        } elseif ($request->payment_option == 'cash') {
            return view('frontend.payment.cash', compact('shippingDetails', 'cartItems', 'finalTotal', 'total'));
        } elseif ($request->payment_option == 'card') {
            return 'Card Payment Page';
        } else {
            return redirect()->back()->with('error', 'Invalid payment option');
        }
    }
}

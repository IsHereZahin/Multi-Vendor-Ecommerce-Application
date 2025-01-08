<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function PendingOrder()
    {
        $orders = Order::where('status', 'pending')->orderBy('id', 'DESC')->get();
        return view('backend.order.pending_order', compact('orders'));
    }

    public function AdminOrderDetails($id)
    {
        $order = Order::with(['orderItems', 'orderItems.product', 'state', 'district', 'division'])
        ->where('id', $id)
        ->first();

        if (!$order) {
            return redirect()->route('user.orders')->with('alert-type', 'error')->with('message', 'Order not found!');
        }

        return view('backend.order.details_order', compact('order'));
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function OrdersByStatus($status = null)
    {
        $validStatuses = ['pending', 'confirm', 'processing', 'picked', 'shipped', 'delivered', 'completed', 'returned', 'canceled', 'return_requests'];

        // If an invalid status is provided, redirect with an error
        if ($status && !in_array($status, $validStatuses)) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid order status.');
        }

        // Filter based on status
        $orders = Order::when($status === 'return_requests', function ($query) {
            $query->whereNotNull('return_reason')->where('status', 'delivered')
                ->orWhere('status', 'returned');
        })->when($status && $status !== 'return_requests', function ($query) use ($status) {
            $query->where('status', $status);
        })->orderBy('id', 'DESC')->get();

        return view('backend.order.orders_by_status', compact('orders', 'status'));
    }

    public function AdminOrderDetails($id)
    {
        $order = Order::with(['orderItems', 'orderItems.product', 'state', 'district', 'division'])
        ->where('id', $id)
            ->first();

        if (!$order) {
            return back()->with('alert-type', 'error')->with('message', 'Order not found!');
        }

        return view('backend.order.details_order', compact('order'));
    }

    public function AdminConfirmedOrder($id)
    {
        $order = Order::findOrFail($id);

        // Check if the order is pending before confirming
        if ($order->status == 'pending') {
            $order->status = 'confirm';
            $order->confirmed_date = Carbon::now();  // Save current date and time
            $order->save();

            return redirect()->route('admin.orders.by.status', ['status' => 'confirm'])
            ->with('alert-type', 'success')
            ->with('message', 'Order confirmed successfully!');
        }

        return redirect()->route('admin.orders.by.status', ['status' => 'pending'])
        ->with('alert-type', 'error')
        ->with('message', 'Order is already confirmed or processed.');
    }

    public function AdminProcessingOrder($id)
    {
        $order = Order::findOrFail($id);

        // Check if the order is confirmed before processing
        if ($order->status == 'confirm') {
            $order->status = 'processing';
            $order->processing_date = Carbon::now();
            $order->save();

            return redirect()->route('admin.orders.by.status', ['status' => 'processing'])
            ->with('alert-type', 'success')
            ->with('message', 'Order marked as processing successfully!');
        }

        return redirect()->route('admin.orders.by.status', ['status' => 'confirm'])
        ->with('alert-type', 'error')
        ->with('message', 'Order must be confirmed before processing.');
    }

    public function AdminPickedOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'processing') {
            $order->status = 'picked';
            $order->picked_date = Carbon::now();
            $order->save();

            return redirect()->route('admin.orders.by.status', ['status' => 'picked'])
            ->with('alert-type', 'success')
            ->with('message', 'Order marked as picked successfully!');
        }

        return redirect()->route('admin.orders.by.status', ['status' => 'processing'])
        ->with('alert-type', 'error')
        ->with('message', 'Order must be in processing status before being marked as picked.');
    }

    public function AdminShippedOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'picked') {
            $order->status = 'shipped';
            $order->shipped_date = Carbon::now();
            $order->save();

            return redirect()->route('admin.orders.by.status', ['status' => 'shipped'])
            ->with('alert-type', 'success')
            ->with('message', 'Order marked as shipped successfully!');
        }

        return redirect()->route('admin.orders.by.status', ['status' => 'picked'])
        ->with('alert-type', 'error')
        ->with('message', 'Order must be picked before being marked as shipped.');
    }

    public function AdminDeliveredOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'shipped') {
            $order->status = 'delivered';
            $order->delivered_date = Carbon::now();
            $order->save();

            return redirect()->route('admin.orders.by.status', ['status' => 'delivered'])
            ->with('alert-type', 'success')
            ->with('message', 'Order marked as delivered successfully!');
        }

        return redirect()->route('admin.orders.by.status', ['status' => 'shipped'])
        ->with('alert-type', 'error')
        ->with('message', 'Order must be shipped before being marked as delivered.');
    }

    public function acceptReturn(Order $order)
    {
        $order->status = 'returned';
        $order->return_date = now();
        $order->save();

        return redirect()->back()->with('success', 'Return request accepted.');
    }

    ////////////////////////////////////// User //////////////////////////////////
    public function cancelOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('user.orders')->with('alert-type', 'error')->with('message', 'Order not found!');
        }

        if ($order->user_id !== auth()->id()) {
            return redirect()->route('user.orders')->with('alert-type', 'error')->with('message', 'Unauthorized action!');
        }

        if (!in_array($order->status, ['pending', 'processing', 'picked'])) {
            return redirect()->route('user.orders')->with('alert-type', 'error')->with('message', 'Order cannot be canceled!');
        }

        $order->status = 'canceled';
        $order->cancel_date = now();
        $order->save();

        return redirect()->route('user.orders')->with('alert-type', 'success')->with('message', 'Order canceled successfully!');
    }
}

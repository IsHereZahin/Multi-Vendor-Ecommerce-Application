<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function AdminOrdersByStatus($status = null)
    {
        $validStatuses = ['pending', 'confirm', 'processing', 'picked', 'shipped', 'delivered', 'completed', 'returned', 'canceled', 'return_requests'];

        // If an invalid status is provided, redirect with an error
        if ($status && !in_array($status, $validStatuses)) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid order status.');
        }

        // Filter based on status
        $orders = Order::when($status === 'return_requests', function ($query) {
            // Orders with return_reason but no return_date (Return Requests)
            $query->whereNotNull('return_reason')
                ->whereNull('return_date');
        })->when($status === 'returned', function ($query) {
            // Orders with a return_date (Returned Orders)
            $query->whereNotNull('return_date');
        })->when($status && !in_array($status, ['return_requests', 'returned']), function ($query) use ($status) {
            // Other statuses
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

            // Update product stock for each order item
            $orderItems = $order->orderItems;
            foreach ($orderItems as $item) {
                $product = $item->product; // Get the associated product
                $product->product_qty -= $item->qty; // Decrease product stock by the ordered quantity
                $product->save();
            }

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

        // Restore the stock for each returned product
        $orderItems = $order->orderItems;
        foreach ($orderItems as $item) {
            $product = $item->product; // Get the associated product
            $product->product_qty += $item->qty; // Add the returned quantity back to stock
            $product->save();
        }

        return redirect()->back()->with('success', 'Return request accepted.');
    }

    // ----------------------------------------------------------------  Order Report ----------------------------------------------------------------
    public function AdminOrderReport(Request $request)
    {
        // Retrieve input filters from the request
        $orderDate = $request->input('order_date');
        $orderMonth = $request->input('order_month');
        $orderYear = $request->input('order_year');
        $statusOption = $request->input('status');
        $userId = $request->input('user');
        $vendorId = $request->input('vendor');

        // Convert order_date format from YYYY-MM-DD to DD Month YYYY for the filter if needed
        if ($orderDate) {
            $orderDateFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $orderDate)->format('d F Y');
        } else {
            $orderDateFormatted = null;
        }

        // Fetch users who have orders
        $users = User::whereHas('orders')->get();

        // Fetch vendors who have orders
        $vendors = User::where('role', 'vendor')
                ->whereIn('id', OrderItem::whereHas('order', function ($query) {$query->distinct();})
                ->pluck('vendor_id'))->get();

        // All order query
        $orders = Order::query();

        // Apply filters based on request parameters
        if ($orderMonth) {
            $orders->where('order_month', $orderMonth);
        }

        if ($orderYear) {
            $orders->where('order_year', $orderYear);
        }

        if ($statusOption) {
            $orders->where('status', $statusOption);
        }

        if ($userId) {
            $orders->where('user_id', $userId);
        }

        if ($vendorId) {
            // Apply vendor filter through the orderItems relationship
            $orders->whereHas('orderItems', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            });
        }

        if ($orderDateFormatted) {
            // Filter by the order_date (DD Month YYYY)
            $orders->where('order_date', $orderDateFormatted);
        }

        // Fetch the filtered orders
        $orders = $orders->get();

        // Get distinct months and years from the orders table
        $months = Order::selectRaw('order_month')->distinct()->pluck('order_month');
        $years = Order::selectRaw('order_year')->distinct()->pluck('order_year');
        $statusOptions = Order::selectRaw('status')->distinct()->pluck('status');

        // Calculate totals
        $totalOrders = $orders->count();
        $totalIncome = $orders->whereNotIn('status', ['returned', 'canceled'])->sum('amount');
        $totalUsers = $orders->pluck('user_id')->unique()->count();
        $totalReturns = $orders->whereIn('status', ['returned', 'canceled'])->count();

        // Return the view with data
        return view('backend.order.order_report',
            compact( 'orders', 'vendors', 'users', 'totalOrders', 'totalIncome', 'totalUsers', 'totalReturns', 'months', 'years', 'statusOptions')
        );
    }
}

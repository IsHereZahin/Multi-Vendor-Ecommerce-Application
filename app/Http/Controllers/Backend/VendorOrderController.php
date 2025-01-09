<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class VendorOrderController extends Controller
{
    public function vendorOrdersByStatus($status = null)
    {
        $authVendorId = auth()->id(); // Get the authenticated vendor's ID
        $validStatuses = ['pending', 'confirm', 'processing', 'picked', 'shipped', 'delivered', 'completed', 'returned', 'canceled', 'return_requests'];

        // If an invalid status is provided, redirect with an error
        if ($status && !in_array($status, $validStatuses)) {
            return redirect()->route('vendor.dashboard')->with('error', 'Invalid order status.');
        }

        // Fetch orders related to the authenticated vendor
        $orders = OrderItem::with(['order', 'product'])
            ->where('vendor_id', $authVendorId)
            ->when($status === 'return_requests', function ($query) {
                // Orders with return_reason but no return_date (Return Requests)
                $query->whereHas('order', function ($orderQuery) {
                    $orderQuery->whereNotNull('return_reason')
                        ->whereNull('return_date');
                });
            })
            ->when($status === 'returned', function ($query) {
                // Orders with a return_date (Returned Orders)
                $query->whereHas('order', function ($orderQuery) {
                    $orderQuery->whereNotNull('return_date');
                });
            })
            ->when($status && !in_array($status, ['return_requests', 'returned']), function ($query) use ($status) {
                // Filter by other statuses
                $query->whereHas('order', function ($orderQuery) use ($status) {
                    $orderQuery->where('status', $status);
                });
            })
            ->orderBy('id', 'DESC')
            ->get();

        return view('vendor.backend.order.orders_by_status', compact('orders', 'status'));
    }

    public function VendorOrderDetails($id)
    {
        $authVendorId = auth()->id(); // Get the authenticated vendor's ID

        // Fetch the order only if it belongs to the authenticated vendor
        $order = OrderItem::with(['order', 'product', 'order.state', 'order.district', 'order.division'])
            ->where('vendor_id', $authVendorId)
            ->where('order_id', $id)
            ->first();

        if (!$order) {
            return back()->with('alert-type', 'error')->with('message', 'Order not found or access denied!');
        }

        return view('vendor.backend.order.details_order', compact('order'));
    }
}

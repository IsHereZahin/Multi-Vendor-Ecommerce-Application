<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class VendorOrderController extends Controller
{
    public function VendorPendingOrder()
    {
        $order_item = OrderItem::with('order')
            ->where('vendor_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->get();

        return view('vendor.backend.orders.pending_orders', compact('order_item'));
    }
}

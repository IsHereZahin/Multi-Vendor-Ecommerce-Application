<?php

namespace App\Http\Controllers\Backend;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function AllCoupon()
    {
        $coupons = Coupon::all();
        return view('backend.coupons.index', compact('coupons'));
    }

    public function AddCoupon()
    {
        return view('backend.coupons.create');
    }

    public function StoreCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons|max:255',
            'discount' => 'required|integer|min:1|max:100',
            'expiry_date' => 'required|date|after:today',
            'status' => 'nullable|boolean',
        ]);

        Coupon::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'expiry_date' => $request->expiry_date,
            'status' => $request->status ?? true,
        ]);

        $notification = array(
            'alert-type' => 'info',
            'message'   => 'Coupon added successfully!'
        );

        return redirect()->route('all.coupon')->with($notification);
    }

    public function EditCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('backend.coupons.edit', compact('coupon'));
    }

    public function UpdateCoupon(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $id . '|max:255',
            'discount' => 'required|integer|min:1|max:100',
            'expiry_date' => 'required|date|after:today',
            'status' => 'required|boolean',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => $request->code,
            'discount' => $request->discount,
            'expiry_date' => $request->expiry_date,
            'status' => $request->status,
        ]);

        $notification = array(
            'alert-type' => 'info',
            'message'   => 'Coupon updated successfully!'
        );

        return redirect()->route('all.coupon')->with($notification);
    }

    public function DeleteCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        $notification = array(
            'alert-type' => 'info',
            'message'   => 'Coupon deleted successfully!'
        );

        return redirect()->route('all.coupon')->with($notification);
    }
}

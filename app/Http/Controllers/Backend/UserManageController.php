<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VendorApprove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class UserManageController extends Controller
{
    // Active Inactive Vendor Account
    public function InactiveVendor()
    {
        $inActiveVendor = User::where('status', 'inactive')->where('role', 'vendor')->latest()->get();
        return view('admin.vendor.inactive_vendor', compact('inActiveVendor'));
    } // End


    public function ActiveVendor()
    {
        $ActiveVendor = User::where('status', 'active')->where('role', 'vendor')->latest()->get();
        return view('admin.vendor.active_vendor', compact('ActiveVendor'));
    } // End

    public function InactiveVendorDetails($id)
    {
        $inactiveVendorDetails = User::findOrFail($id);
        return view('admin.vendor.inactive_vendor_details', compact('inactiveVendorDetails'));
    } // End

    public function ActiveVendorApprove(Request $request)
    {
        $vendor_id = $request->id;
        $vendor = User::findOrFail($vendor_id);

        // Update the vendor status
        $vendor->update([
            'status' => 'active'
        ]);

        $notification = array(
            'message' => 'Vendor Active Successfully',
            'alert-type' => 'success'
        );

        Notification::send($vendor, new VendorApprove($request->name));

        return redirect()->route('active.vendor')->with($notification);
    } // End

    public function ActiveVendorDetails($id)
    {
        $activeVendorDetails = User::findOrFail($id);
        return view('admin.vendor.active_vendor_details', compact('activeVendorDetails'));
    } // End


    public function InActiveVendorApprove(Request $request)
    {
        $verdor_id = $request->id;
        User::findOrFail($verdor_id)->update([
            'status' => 'inactive',
        ]);

        $notification = array(
            'message' => 'Vendor InActive Successfully',
            'alert-type' => 'warning'
        );

        return redirect()->route('inactive.vendor')->with($notification);
    }// End

    public function AllUsers()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.users.all_users', compact('users'));
    }
}

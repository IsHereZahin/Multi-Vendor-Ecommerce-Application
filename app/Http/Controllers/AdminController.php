<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        // Retrieve all orders
        $orders = Order::all();

        // Calculate total orders and revenue
        $totalOrders = $orders->count();
        $totalIncome = $orders->whereNotIn('status', ['returned', 'canceled'])->sum('amount');

        // Count users who have placed orders
        $totalOrderUsers = $orders->pluck('user_id')->unique()->count();

        // Count vendors who have sold items in all orders
        $totalOrderVendor = $orders->flatMap(function ($order) {
            return $order->orderItems->pluck('vendor_id');
        })->unique()->count();

        // Count total returned or canceled orders
        $totalReturns = $orders->whereIn('status', ['returned', 'canceled'])->count();

        // Today's Sale
        $today = now()->format('Y-m-d');
        $todaySale = $orders->where('order_date', $today)
            ->whereNotIn('status', ['returned', 'canceled'])
            ->sum('amount');

        // Monthly Sale
        $currentMonth = now()->format('F');
        $monthlySale = $orders->where('order_month', $currentMonth)
            ->whereNotIn('status', ['returned', 'canceled'])
            ->sum('amount');

        // Yearly Sale
        $currentYear = now()->format('Y');
        $yearlySale = $orders->where('order_year', $currentYear)
            ->whereNotIn('status', ['returned', 'canceled'])
            ->sum('amount');

        // Count pending orders
        $pendingOrders = $orders->where('status', 'pending')->count();

        // Total vendors in the system
        $totalVendors = User::where('role', 'vendor')->count();

        // Total users in the system
        $totalUsers = User::where('role', 'user')->count();

        // Count top 10 products sale in the system
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(qty) AS total_quantity'))
        ->groupBy('product_id')
        ->orderBy('total_quantity', 'desc')
            ->with('product')
            ->limit(10)
            ->get();

        return view(
            'admin.admin_dashboard',
            compact(
                'orders',
                'totalOrders',
                'totalIncome',
                'totalOrderUsers',
                'totalOrderVendor',
                'totalUsers',
                'totalReturns',
                'todaySale',
                'monthlySale',
                'yearlySale',
                'pendingOrders',
                'totalVendors',
                'topProducts'
            )
        );
    }

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $admindata = User::find($id);
        return view('admin.admin_profile', compact('id', 'admindata'));
    }

    public function AdminProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete old image if exists
            if ($data->photo && file_exists(public_path('upload/user/admin/' . $data->photo))) {
                unlink(public_path('upload/user/admin/' . $data->photo));
            }

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();

            // Generate a unique filename with username and current timestamp
            $username = Auth::user()->name; // Assuming 'name' is the username field
            $currentTime = time();
            $filename = $username . '_' . $id . '_' . $currentTime . '.' . $extension;
            $file->move(public_path('upload/user/admin'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        $notification = array(
            'alert-type' =>'success',
            'message' => 'Profile Updated Successfully!'
        );
        return redirect('/admin/profile')->with($notification);
    }

    public function AdminChangePassword()
    {
        return view('admin.admin_change_password');
    }

    public function AdminPasswordUpdate(Request $request)
    {
        // Validation
        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required','string','min:8', 'confirmed'],
        ]);

        // Match Password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't Match!!!");
        }

        // Update Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password Updated Successfully");
    }
}

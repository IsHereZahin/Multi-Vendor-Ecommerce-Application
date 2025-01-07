<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function UserDashboard()
    {
        $id = Auth::user()->id;
        $userdata = User::find($id);
        return view('user.dashboard', compact('id', 'userdata'));
    }

    public function UserOrders()
    {
        $id = Auth::user()->id;
        $orders = Order::where('user_id', $id)->latest()->get();
        return view('user.orders', compact('orders'));
    }

    public function UserTrackOrders()
    {
        return view('user.track-orders');
    }

    public function UserAccountDetails()
    {
        $userdata = auth()->user();
        return view('user.account-details', compact('userdata'));
    }

    public function UserChangePassword()
    {
        return view('user.change-password');
    }

    public function UserProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete old image if exists
            if ($data->photo && file_exists(public_path('upload/user/user/' . $data->photo))) {
                unlink(public_path('upload/user/user/' . $data->photo));
            }

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();

            // Generate a unique filename with username and current timestamp
            $username = Auth::user()->name; // Assuming 'name' is the username field
            $currentTime = time();
            $filename = $username . '_' . $id . '_' . $currentTime . '.' . $extension;
            $file->move(public_path('upload/user/user'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        $notification = array(
            'alert-type' =>'success',
            'message' => 'Profile Updated Successfully!'
        );
        return redirect()->back()->with($notification);
    }

    public function UserPasswordUpdate(Request $request)
    {
        // Validation
        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Match Password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            return back()->with('alert-type', 'error')->with('message', "Old Password Doesn't Match!!!");
        }

        // If the new password is same as the old one, don't update
        if ($request->old_password == $request->new_password) {
            return back()->with('alert-type', 'warning')->with('message', "New Password cannot be the same as the old password!");
        }

        // Update Password
        $updateStatus = User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Check if password was updated successfully
        if ($updateStatus) {
            return back()->with('alert-type', 'success')->with('message', 'Password Updated Successfully!');
        } else {
            return back()->with('alert-type', 'error')->with('message', 'Failed to update the password. Please try again.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

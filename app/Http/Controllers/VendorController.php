<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function BecomeVendor()
    {
        return view('vendor.become_vendor');
    }

    public function VendorRegister(Request $request) {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'vendor_join_year' => $request->vendor_join_year,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => 'inactive',
        ]);

          $notification = array(
            'message' => 'Vendor Registered Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.login')->with($notification);

    }// End Mehtod

    public function VendorDashboard()
    {
        return view('vendor.vendor_dashboard');
    }

    public function VendorLogin()
    {
        return view('vendor.vendor_login');
    }

    public function VendorLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    }

    public function VendorProfile()
    {
        $id = Auth::user()->id;
        $vendordata = User::find($id);
        return view('vendor.vendor_profile', compact('id', 'vendordata'));
    }

    public function VendorProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vendor_join_year = $request->vendor_join_year;
        $data->vendor_short_info = $request->vendor_short_info;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete old image if exists
            if ($data->photo && file_exists(public_path('upload/user/vendor/' . $data->photo))) {
                unlink(public_path('upload/user/vendor/' . $data->photo));
            }

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();

            // Generate a unique filename with username and current timestamp
            $username = Auth::user()->name; // Assuming 'name' is the username field
            $currentTime = time();
            $filename = $username . '_' . $id . '_' . $currentTime . '.' . $extension;
            $file->move(public_path('upload/user/vendor'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        $notification = array(
            'alert-type' =>'success',
            'message' => 'Vendor Info Updated Successfully!'
        );
        return redirect('/vendor/profile')->with($notification);
    }

    public function VendorChangePassword()
    {
        return view('vendor.vendor_change_password');
    }

    public function VendorPasswordUpdate(Request $request)
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

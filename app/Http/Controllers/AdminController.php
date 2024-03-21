<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.admin_dashboard');
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
            if ($data->photo && file_exists(public_path('adminbackend/assets/images/upload/user/' . $data->photo))) {
                unlink(public_path('adminbackend/assets/images/upload/user/' . $data->photo));
            }

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();

            // Generate a unique filename with username and current timestamp
            $username = Auth::user()->name; // Assuming 'name' is the username field
            $currentTime = time();
            $filename = $username . '_' . $id . '_' . $currentTime . '.' . $extension;
            $file->move(public_path('adminbackend/assets/images/upload/user'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        $notification = array(
            'alert-type' =>'success',
            'message' => 'Profile Updated Successfully!'
        );
        return redirect('/admin/profile')->with($notification);
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

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::all();
        return view('backend.roles.permissions.index', compact('permissions'));
    }

    public function CreatePermission()
    {
        return view('backend.roles.permissions.create');
    }

    public function StorePermission(Request $request)
    {
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission created successfully.',
            'alert-type' =>'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function EditPermission($id)
    {
        $permission = Permission::find($id);
        return view('backend.roles.permissions.edit', compact('permission'));
    }

    public function UpdatePermission(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'info' => 'Permission updated successfully.',
            'alert-type' =>'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function DeletePermission($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        $notification = array(
            'warning' => 'Permission deleted successfully.',
            'alert-type' =>'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }
}

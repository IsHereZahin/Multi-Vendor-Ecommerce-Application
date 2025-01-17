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
            'message' => 'Permission updated successfully.',
            'alert-type' => 'info'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function DeletePermission($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        $notification = array(
            'message' => 'Permission deleted successfully.',
            'alert-type' => 'warning'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    // -------------------------------------------------- Role ------------------------------------------------
    public function AllRole()
    {
        $roles = Role::all();
        return view('backend.roles.index', compact('roles'));
    }

    public function CreateRole()
    {
        return view('backend.roles.create');
    }

    public function StoreRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        $notification = array(
            'message' => 'Role created successfully.',
            'alert-type' =>'success'
        );

        return redirect()->route('all.role')->with($notification);
    }

    public function EditRole($id)
    {
        $role = Role::find($id);
        return view('backend.roles.edit', compact('role'));
    }

    public function UpdateRole(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id.'|max:255',
        ]);

        $role = Role::find($id);
        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions);

        $notification = array(
            'message' => 'Role updated successfully.',
            'alert-type' => 'info'
        );

        return redirect()->route('all.role')->with($notification);
    }

    public function DeleteRole($id)
    {
        $role = Role::find($id);
        $role->delete();

        $notification = array(
            'message' => 'Role deleted successfully.',
            'alert-type' => 'warning'
        );

        return redirect()->route('all.role')->with($notification);
    }
}

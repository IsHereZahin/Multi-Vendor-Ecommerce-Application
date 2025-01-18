<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    // ------------------------------------------------ Roles in Permission ------------------------------------------------
    public function IndexRolePermission()
    {
        $roles = Role::all();

        // Fetch permissions for each role and pass them as an associative array
        $rolePermissions = [];
        foreach ($roles as $role) {
            $rolePermissions[$role->id] = $role->permissions->pluck('name')->toArray(); // Get the permission names for the role
        }

        return view('backend.roles.attach_roles_permission.index', compact('roles', 'rolePermissions'));
    }

    public function CreateRolePermission()
    {
        $permissions = Permission::all();
        $permission_groups = User::getPermissionGroups();
        return view('backend.roles.attach_roles_permission.create', compact('permissions', 'permission_groups'));
    }

    public function StoreRolePermission(Request $request)
    {
        // first of all store role
        $request->validate([
            'role_name' => 'required|unique:roles,name|max:255',
        ]);

        // Create the role
        $role = Role::create(['name' => $request->role_name]); // This id will use in role_id for role_has_permission


        // and than we create here permission for role
        $request->validate([
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ]);

        // Get the permissions from the request
        $permissions = $request->input('permission');

        // Prepare data for bulk insert
        $data = [];
        foreach ($permissions as $permission) {
            $data[] = [
                'role_id' => $role->id,  // Use the created role ID
                'permission_id' => $permission,
            ];
        }

        // Insert permissions for the new role
        DB::table('role_has_permissions')->insert($data);

        $notification = array(
            'message' => 'Role and permissions added successfully.',
            'alert-type' => 'success',
        );

        return redirect()->route('index.role.permission')->with($notification);
    }

    // Edit Role Permission
    public function EditRolePermission($id)
    {
        $role = Role::findOrFail($id);
        $role_permissions = $role->permissions->pluck('id')->toArray(); // Get the permission IDs for the role
        $permission_groups = User::getPermissionGroups();
        return view('backend.roles.attach_roles_permission.edit', compact('role', 'permission_groups', 'role_permissions'));
    }

    // Update Role Permission
    public function UpdateRolePermission(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate([
            'role_name' => 'required|max:255|unique:roles,name,' . $role->id,
        ]);

        // Update the role
        $role->update(['name' => $request->role_name]);

        // Validate permissions
        $request->validate([
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ]);

        $permissions = $request->input('permission');
        $data = [];
        foreach ($permissions as $permission) {
            $data[] = [
                'role_id' => $role->id,
                'permission_id' => $permission,
            ];
        }

        // Clear existing permissions for the role and insert new ones
        DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
        DB::table('role_has_permissions')->insert($data);

        $notification = array(
            'message' => 'Role and permissions updated successfully.',
            'alert-type' => 'info',
        );

        return redirect()->route('index.role.permission')->with($notification);
    }

    // Delete Role Permission
    public function DeleteRolePermission($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        // Delete permissions associated with this role
        DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

        $notification = array(
            'message' => 'Role deleted successfully.',
            'alert-type' => 'warning',
        );

        return redirect()->route('index.role.permission')->with($notification);
    }
}

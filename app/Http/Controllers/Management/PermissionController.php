<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\SubModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display the permissions interface
     */
    public function index()
    {
        $roles = Role::get();
        $modules = Module::all();

        return view('management.permission.index', compact('roles', 'modules'));
    }

    public function get_permission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer',
            'module_id' => 'required|integer'
        ]);
        $submodule = SubModule::where('module_id', $request->module_id)->with('permissions')->get();
        $RoleHasPermission = DB::table('role_has_permissions')->where('role_id', $request->role_id)->get();
        return response()->json([
            'submodule' => $submodule,
            'RoleHasPermission' => $RoleHasPermission
        ]);
    }

    public function get_role_permission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer',
            'module_id' => 'required|integer'
        ]);
        $submodule = SubModule::where('module_id', $request->module_id)->with('permissions')->get();
        $role_permissions = DB::table('role_has_permissions')->where('role_id', $request->role_id)->get();

        foreach ($submodule as $item) {
            unset($item->created_at);
            unset($item->updated_at);
            $all_permissions = [];
            $extra_permissions = [];


            foreach ($item->permissions as $permission) {
                $hasPermission = $role_permissions->firstWhere('permission_id', $permission->id);
                $permission['isChecked'] = $hasPermission ? true : false;
                $permission['value'] = ($hasPermission && property_exists($hasPermission, 'value')) ? $hasPermission->value : null;

                unset($permission->created_at);
                unset($permission->updated_at);
                unset($permission->guard_name);
                unset($permission->module_id);
                unset($permission->submodule_id);

                $parts = explode('.', $permission['name']);
                $name = end($parts);

                $p_data = [
                    "permission_id" => $permission->id,
                    "value" => $permission->value,
                    "isChecked" => $permission->isChecked
                ];

                if (
                    str_ends_with($name, "list") ||
                    str_ends_with($name, "update") ||
                    str_ends_with($name, "delete") ||
                    str_ends_with($name, "create")
                ) {
                    $all_permissions[$name] = $p_data;
                } else {
                    if ($name == 'update_ask') {
                        $detailName = 'Will Apply Reason on Update';
                    } elseif ($name == 'delete_ask') {
                        $detailName = 'Will Apply Reason on Delete';
                    } elseif ($name == 'update_approve') {
                        $detailName = 'Will Apply Approval on Update';
                    } elseif ($name == 'delete_approve') {
                        $detailName = 'Will Apply Approval on Delete';
                    } elseif ($name == 'can_change_date') {
                        $detailName = 'Can Change Date';
                    } elseif ($name == 'can_demote_employee') {
                        $detailName = 'Can Demote Employee';
                    } elseif ($name == 'can_promote_employee') {
                        $detailName = 'Can Promote Employee';
                    } elseif ($name == 'can_transfer_employee') {
                        $detailName = 'Can Transfer Employee';
                    } elseif ($name == 'voucher_type') {
                        $detailName = 'Voucher Type';
                    } elseif ($name == 'payment_type') {
                        $detailName = 'Payment Type';
                    }
                    if (
                        $name == "update_ask" ||
                        $name == "update_approve" ||
                        $name == "delete_ask" ||
                        $name == "delete_approve" ||
                        $name == "can_change_date" ||
                        $name == "can_demote_employee" ||
                        $name == "can_promote_employee" ||
                        $name == "can_transfer_employee"
                    ) {
                        $options = [true, false];
                    }
                    if ($name == "voucher_type") {
                        $options = ["all", "cash_payment", "cash_receipt", "bank_payment", "bank_receipt", "journal"];
                    }
                    if ($name == "payment_type") {
                        $options = ["all", "cash", "bank", "journal"];
                    }
                    $p_data['detail'] = $detailName;
                    $p_data['options'] = $options;
                    $extra_permissions[$name] = $p_data;
                }
            }
            $item['permissions_list'] = $item['permissions'];
            unset($item->permissions);
            $item['permissions'] = $all_permissions;
            $item['extra_permissions'] = $extra_permissions;
        }

        return response()->json($submodule);
    }

    public function get_user_permissions(Request $request)
    {
        $currentUser = Auth::user();
        $permissions = Permission::get();
        $role_permissions = DB::table('role_has_permissions')->where("role_id", $currentUser->role_id)->get();
        $user_permissions = DB::table('model_has_permissions')->where("model_id", $currentUser->id)->get();


        $data = [];
        $added_permissions = [];

        foreach ($user_permissions as $item) {
            $permission = $permissions->firstWhere('id', $item->permission_id);

            if ($permission) {
                $parts = explode('.', $permission->name);
                $name = end($parts);
                if (!isset($data[$permission->permission_name])) {
                    $data[$permission->permission_name] = [];
                }
                $data[$permission->permission_name][] = $name;
                $added_permissions[] = $permission->id;
            }
        }

        foreach ($role_permissions as $item) {
            if (-1 > array_search($item->permission_id, $added_permissions)) {
                $permission = $permissions->firstWhere('id', $item->permission_id);

                if ($permission) {
                    $parts = explode('.', $permission->name);
                    $name = end($parts);
                    if (!isset($data[$permission->permission_name])) {
                        $data[$permission->permission_name] = [];
                    }
                    $data[$permission->permission_name][] = $name;
                }
            }
        }
        return response()->json($data);
    }

    public function permission_list(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer',
            'module_id' => 'required|integer'
        ]);
        $submodules = SubModule::where('module_id', $request->module_id)->with('permissions')->get();
        $permissions = Permission::where('module_id', $request->module_id)->get();
        $module = Module::find($request->module_id);
        $role = Role::find($request->role_id);
        $RoleHasPermission = DB::table('role_has_permissions')->where('role_id', $request->role_id)->get();
        return view('management.role_privilages.permission', compact('submodules', 'permissions', 'role', 'module', 'RoleHasPermission'));
    }

public function assign_permission(Request $request)
{
    $request->validate([
        'module_id' => 'required|integer',
        'role_id' => 'required|integer',
        'permission' => 'nullable|array' // Changed from 'required' to 'nullable'
    ]);

    // Get all permission IDs for this module
    $skipPermission = Permission::where('module_id', $request->module_id)->pluck('id');

    // Delete all existing permissions for this module and role
    $OldPermissionModule = DB::table('role_has_permissions')
        ->where('role_id', $request->role_id)
        ->whereIn('permission_id', $skipPermission)
        ->delete();

    // If we have new permissions to assign
    $mergedPermissions = [];

    // Get existing permissions from other modules
    $existingPermissions = DB::table('role_has_permissions')
        ->where('role_id', $request->role_id)
        ->whereNotIn('permission_id', $skipPermission)
        ->pluck('permission_id')
        ->toArray();

    // Add the existing permissions
    $mergedPermissions = $existingPermissions;

    // Add new permissions if provided
    if ($request->has('permission') && is_array($request->permission)) {
        $data = array();
        foreach ($request->permission as $key => $item) {
            $data[] = (int)$item;
        }
        $mergedPermissions = array_unique(array_merge($mergedPermissions, $data));
    }

    // Sync permissions
    $role = Role::find($request->role_id);
    $role->syncPermissions($mergedPermissions);

    return response()->json([
        'status' => 200,
        'message' => 'Permission Assigned Successfully'
    ]);
}
}

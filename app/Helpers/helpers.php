<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

function hasModuleAccess($moduleId)
{
    $user = Auth::user();
    if (!$user) {
        return false;
    }

    $permissions = Permission::where('module_id', $moduleId)->pluck('name');

    foreach ($permissions as $permission) {
        if (Gate::forUser($user)->check($permission)) {
            return true;
        }
    }

    return false;
}

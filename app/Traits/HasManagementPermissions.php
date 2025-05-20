<?php

namespace App\Traits;

trait HasManagementPermissions
{
    /**
     * Check if the user has any management-related permissions
     *
     * @return bool
     */
    public function hasManagementPermissions(): bool
    {
        return $this->canAny([
            'user.list',
            'role.list',
            'permission.list',
            'branch.list',
            'department.list',
            'designation.list'
        ]);
    }
}

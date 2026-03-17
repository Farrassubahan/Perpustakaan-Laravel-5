<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

function userCan($permission)
{
    $userId = Auth::id();

    if (!$userId) {
        return false;
    }

    $roles = DB::table('role_user')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->where('role_user.user_id', $userId)
        ->pluck('roles.name')
        ->toArray();

    foreach ($roles as $role) {

        $permissions = config("permissions.roles.$role");

        if ($permissions && in_array($permission, $permissions)) {
            return true;
        }
    }

    return false;
}

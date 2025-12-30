<?php

namespace App\Helpers;

class PermissionHelper
{
    public static function can(string $permission): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        if ($user->role === 'superadmin') return true;

        $path = storage_path('app/role_permissions.json');
        if (!file_exists($path)) return false;

        $permissions = json_decode(file_get_contents($path), true);

        return $permissions[$user->role][$permission] ?? false;
    }
}

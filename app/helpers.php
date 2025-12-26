<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('hasPermission')) {
    function hasPermission(string $permission): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $role = auth()->user()->role;

        if (!Storage::exists('role_permissions.json')) {
            return false;
        }

        $permissions = json_decode(
            Storage::get('role_permissions.json'),
            true
        );

        return isset($permissions[$role][$permission])
            && $permissions[$role][$permission] === true;
    }
}

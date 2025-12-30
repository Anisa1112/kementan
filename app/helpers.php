<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('hasPermission')) {
    function hasPermission(string $permission): bool
    {
        // Cek apakah file permission ada
        if (!Storage::exists('role_permissions.json')) {
            return false;
        }

        $permissions = json_decode(
            Storage::get('role_permissions.json'),
            true
        );

        $role = auth()->check() ? auth()->user()->role : 'user';

        // Jika role adalah superadmin, izinkan semua
        if ($role === 'superadmin') {
            return true;
        }

        return isset($permissions[$role][$permission])
            && $permissions[$role][$permission] === true;
    }
}

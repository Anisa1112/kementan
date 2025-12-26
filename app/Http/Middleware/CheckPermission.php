<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();

        if (!$user) {   
            abort(403);
        }

        if ($user->role === 'Super Admin') {
            return $next($request);
        }

        $file = storage_path('app/role_permissions.json');
        if (!file_exists($file)) {
            abort(403);
        }

        $permissions = json_decode(file_get_contents($file), true);

        if (!($permissions[$user->role][$permission] ?? false)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['role', 'permission', 'value'];

    protected $casts = [
        'value' => 'boolean',
    ];

    /**
     * Cek apakah role punya permission tertentu
     */
    public static function check($role, $permission)
    {
        $perm = self::where('role', $role)
                    ->where('permission', $permission)
                    ->first();
                    
        return $perm ? $perm->value : false;
    }

    /**
     * Set permission untuk role
     */
    public static function set($role, $permission, $value)
    {
        return self::updateOrCreate(
            ['role' => $role, 'permission' => $permission],
            ['value' => $value]
        );
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display the admin panel with role management
     */
    public function index()
    {
        // Check if user is super admin
        if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // Get statistics for each role
        $totalSuperAdmin = User::where('role', 'superadmin')->count();
        $totalAdminPusdatin = User::where('role', 'admin_pusdatin')->count();
        $totalAdminEselon = User::where('role', 'admin_eselon')->count();
        $totalUser = User::where('role', 'user')->count();

        return view('admin.index', compact(
            'totalSuperAdmin',
            'totalAdminPusdatin',
            'totalAdminEselon',
            'totalUser'
        ));
    }

    /**
     * Update permissions for roles - SIMPLE VERSION
     */
    public function updatePermissions(Request $request)
    {
        try {
            // Cek apakah ada data permissions
            if (!$request->has('permissions')) {
                Log::error('Permissions data not found in request');
                return response()->json([
                    'success' => false,
                    'message' => 'Data permissions tidak ditemukan'
                ], 400);
            }

            $permissions = $request->input('permissions');

            // Validasi apakah permissions adalah array
            if (!is_array($permissions)) {
                Log::error('Permissions is not an array');
                return response()->json([
                    'success' => false,
                    'message' => 'Format data permissions tidak valid'
                ], 400);
            }

            // Simpan langsung ke file JSON (sudah termasuk Super Admin dari frontend)
            $fileName = 'role_permissions.json';
            $jsonData = json_encode($permissions, JSON_PRETTY_PRINT);

            Storage::disk('local')->put($fileName, $jsonData);

            return response()->json([
                'success' => true,
                'message' => 'Permission berhasil disimpan!',
                'saved_at' => now()->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'error_detail' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }

    /**
     * Get permissions for a specific role
     */
    public function getRolePermissions($roleName)
    {
        try {
            $fileName = 'role_permissions.json';

            if (!Storage::disk('local')->exists($fileName)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File permissions belum ada'
                ], 404);
            }

            $jsonData = Storage::disk('local')->get($fileName);
            $allPermissions = json_decode($jsonData, true);

            $permissions = $allPermissions[$roleName] ?? [];

            return response()->json([
                'success' => true,
                'role' => $roleName,
                'permissions' => $permissions
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting role permissions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset permissions to default
     */
    public function resetPermissions()
    {
        try {
            $defaultPermissions = [
                 'superadmin' => [
                    'manage_komoditas' => true,
                    'manage_psp' => true,
                    'access_sector_pangan' => true,
                    'access_sector_horti'=> true,
                    'access_sector_perkebunan' => true,
                    'access_sector_peternakan' => true,
                    'access_psp' => true
                ],
                'admin_pusdatin' => [
                    'manage_komoditas' => true,
                    'manage_psp' => true,
                    'access_sector_pangan' => true,
                    'access_sector_horti'=> true,
                    'access_sector_perkebunan' => true,
                    'access_sector_peternakan' => true,
                    'access_psp' => true
                ],
                'admin_eselon' => [
                    'manage_komoditas' => true,
                    'manage_psp' => true,
                    'access_sector_pangan' => true,
                    'access_sector_horti'=> true,
                    'access_sector_perkebunan' => true,
                    'access_sector_peternakan' => true,
                    'access_psp' => true
                ],
                'User' => [
                    'manage_komoditas' => true,
                    'manage_psp' => true,
                    'access_sector_pangan' => true,
                    'access_sector_horti'=> true,
                    'access_sector_perkebunan' => true,
                    'access_sector_peternakan' => true,
                    'access_psp' => true
                ]
            ];

            $fileName = 'role_permissions.json';
            $jsonData = json_encode($defaultPermissions, JSON_PRETTY_PRINT);

            Storage::disk('local')->put($fileName, $jsonData);

            Log::info('Permissions reset to default by: ' . auth()->user()->name);

            return response()->json([
                'success' => true,
                'message' => 'Permission berhasil direset ke default!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error resetting permissions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal reset permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test endpoint to check if route is working
     */
    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'Route is working!',
            'user' => auth()->user()->name,
            'time' => now()->format('Y-m-d H:i:s')
        ]);
    }
}

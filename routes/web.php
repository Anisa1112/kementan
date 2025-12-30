<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrasaranaSaranaController;
use App\Models\Komoditas;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Auth ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Home / Dashboard ---
Route::get('/', function () {
    // ✅ Gunakan withJenis() untuk filter hanya data yang punya jenis
    $komoditas = Komoditas::withJenis()->latest()->get();

    // ✅ Statistik berdasarkan sektor - HANYA yang punya jenis
    $totalKomoditas = Komoditas::withJenis()->count();
    $tanamanPangan  = Komoditas::withJenis()->where('sektor', 'Tanaman Pangan')->count();
    $hortikultura   = Komoditas::withJenis()->where('sektor', 'Hortikultura')->count();
    $perkebunan     = Komoditas::withJenis()->where('sektor', 'Perkebunan')->count();
    $peternakan     = Komoditas::withJenis()->where('sektor', 'Peternakan & Kesehatan Hewan')->count();

    return view('welcome', compact(
        'komoditas',
        'totalKomoditas',
        'tanamanPangan',
        'hortikultura',
        'perkebunan',
        'peternakan'
    ));
})->name('home');

// --- Master Komoditas ---
Route::get('/komoditas', [KomoditasController::class, 'index'])->name('komoditas');

// --- Komoditas per Sektor ---
Route::get('/komoditas/sektor/{sektor}', [KomoditasController::class, 'sektor'])->name('komoditas.sektor');

    Route::post('/komoditas', [KomoditasController::class, 'store'])->name('komoditas.store');
    Route::get('/komoditas/detail/{id}', [KomoditasController::class, 'show'])->name('komoditas.detail');
    Route::put('/komoditas/{id}', [KomoditasController::class, 'update'])->name('komoditas.update');
    Route::delete('/komoditas/{id}', [KomoditasController::class, 'destroy'])->name('komoditas.destroy');

// --- Admin Dashboard ---
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        // ✅ Gunakan withJenis() di admin juga
        $totalKomoditas = Komoditas::withJenis()->count();
        $tanamanPangan  = Komoditas::withJenis()->where('sektor', 'Tanaman Pangan')->count();
        $hortikultura   = Komoditas::withJenis()->where('sektor', 'Hortikultura')->count();
        $perkebunan     = Komoditas::withJenis()->where('sektor', 'Perkebunan')->count();
        $peternakan     = Komoditas::withJenis()->where('sektor', 'Peternakan & Kesehatan Hewan')->count();

        $komoditas = Komoditas::withJenis()->latest()->paginate(10);

        return view('admin.index', compact(
            'totalKomoditas',
            'tanamanPangan',
            'hortikultura',
            'perkebunan',
            'peternakan',
            'komoditas'
        ));
    })->name('admin');
});

// --- Profile ---
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
});

// --- PSP (Prasarana & Sarana) ---
Route::get('/psp', [PrasaranaSaranaController::class, 'index'])->name('psp.index');


    // PSP Routes
    Route::post('/psp/store', [PrasaranaSaranaController::class, 'store'])->name('psp.store');
    Route::get('/psp/{id}', [PrasaranaSaranaController::class, 'show'])->name('psp.show');
    Route::put('/psp/{id}', [PrasaranaSaranaController::class, 'update'])->name('psp.update');
    Route::delete('/psp/{id}', [PrasaranaSaranaController::class, 'destroy'])->name('psp.destroy');


// routes/web.php
use App\Http\Controllers\RoleController;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['superadmin'])->group(function () {
        Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles');
        Route::post('/roles/update-permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');
    });
});

Route::middleware(['auth'])->group(function () {

    Route::get('/horti', function () {
        return view('horti.index');
    })->middleware('permission:horti')->name('horti.index');

    Route::get('/perikanan', function () {
        return view('perikanan.index');
    })->middleware('permission:perikanan')->name('perikanan.index');

    Route::get('/peternakan', function () {
        return view('peternakan.index');
    })->middleware('permission:peternakan')->name('peternakan.index');

    Route::get('/perkebunan', function () {
        return view('perkebunan.index');
    })->middleware('permission:perkebunan')->name('perkebunan.index');
});







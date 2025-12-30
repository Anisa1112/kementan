<?php

namespace App\Http\Controllers;

use App\Models\Komoditas;
use App\Models\PrasaranaSarana;
use Illuminate\Http\Request;

class BaseController extends Controller
{
        public function index()
    {
        // Data utama
        $komoditas = Komoditas::withJenis()
            ->latest()
            ->get();
        
        $psp = PrasaranaSarana::orderBy('created_at', 'desc')->paginate(10);
        
        // Statistik
        $totalKomoditas = Komoditas::withJenis()->count();
        $tanamanPangan  = Komoditas::withJenis()->where('sektor', 'Tanaman Pangan')->count();
        $hortikultura   = Komoditas::withJenis()->where('sektor', 'Hortikultura')->count();
        $perkebunan     = Komoditas::withJenis()->where('sektor', 'Perkebunan')->count();
        $peternakan     = Komoditas::withJenis()
            ->where('sektor', 'Peternakan & Kesehatan Hewan')
            ->count();
        $pspTotal = PrasaranaSarana::count();


        return view('welcome', compact(
            'komoditas',
            'totalKomoditas',
            'tanamanPangan',
            'hortikultura',
            'perkebunan',
            'peternakan',
            'psp',
            'pspTotal',
        ));
    }
}

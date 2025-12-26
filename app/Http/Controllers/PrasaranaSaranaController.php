<?php

namespace App\Http\Controllers;

use App\Models\PrasaranaSarana;
use Illuminate\Http\Request;

class PrasaranaSaranaController extends Controller
{
    public function index()
    {
        $psp = PrasaranaSarana::orderBy('created_at','desc')->paginate(10);
        return view('psp.index', compact('psp'));
    }

  public function store(Request $request)
{
    \Log::info('PSP Store Request:', $request->all());
    
    try {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string',
            'status' => 'required|string',
        ]);
        
        // Generate kode
        $lastCode = \DB::table('prasarana_sarana')->max('kode');
        $num = $lastCode ? (intval(substr($lastCode, 3)) + 1) : 1;
        $kode = 'PSP' . str_pad($num, 3, '0', STR_PAD_LEFT);
        
        // Insert TANPA deskripsi
        $id = \DB::table('prasarana_sarana')->insertGetId([
            'kode' => $kode,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'subsektor' => $request->subsektor ?? 'Umum',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        \Log::info('PSP Created:', ['id' => $id, 'kode' => $kode]);
        
        return redirect()->route('komoditas', ['tab' => 'psp'])
                         ->with('success', 'Data PSP berhasil ditambahkan! Kode: ' . $kode);
        
    } catch (\Exception $e) {
        \Log::error('PSP Store Error:', ['message' => $e->getMessage()]);
        return redirect()->route('komoditas', ['tab' => 'psp'])
                         ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
}

public function update(Request $request, $id)
{
    $psp = PrasaranaSarana::findOrFail($id);

    $request->validate([
        'nama' => 'required|string|max:255',
        'jenis' => 'required|string',
        'status' => 'required|string',
    ]);

    // Update TANPA deskripsi
    \DB::table('prasarana_sarana')
        ->where('id', $id)
        ->update([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'subsektor' => $request->subsektor ?? 'Umum',
            'updated_at' => now(),
        ]);

    return redirect()->route('komoditas.index', ['tab' => 'psp'])
                     ->with('success', 'Data PSP berhasil diperbarui');
}
    public function destroy($id)
    {
        $psp = PrasaranaSarana::findOrFail($id);
        $psp->delete();

        return back()->with('success', 'Data PSP berhasil dihapus');
    }
}

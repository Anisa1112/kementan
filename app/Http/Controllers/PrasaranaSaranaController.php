<?php

namespace App\Http\Controllers;

use App\Models\PrasaranaSarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrasaranaSaranaController extends Controller
{
    /**
     * Menampilkan daftar PSP
     */
    public function index()
    {
        $psp = PrasaranaSarana::orderBy('created_at', 'desc')->paginate(10);
        return view('psp.index', compact('psp'));
    }

    /**
     * Menyimpan data PSP baru
     * sektor DIKUNCI = PSP
     */
    public function store(Request $request)
    {
        

        try {
            $validated = $request->validate([
                'jenis'    => 'required|string|max:100',
                'kategori' => 'required|string|max:150',
                'item'     => 'required|string|max:150',
                'status'   => 'required|in:Aktif,Nonaktif',
            ]);

            // Generate kode PSP otomatis
            $lastCode = PrasaranaSarana::max('kode');
            $num = $lastCode ? ((int) substr($lastCode, 3) + 1) : 1;
            $kode = 'PSP' . str_pad($num, 3, '0', STR_PAD_LEFT);

            $psp = PrasaranaSarana::create([
                'kode'     => $kode,
                'sektor'   => 'PSP', // 🔒 dikunci
                'jenis'    => $validated['jenis'],
                'kategori' => $validated['kategori'],
                'item'     => $validated['item'],
                'status'   => $validated['status'],
            ]);
            
            $psp->save();

            return redirect()
                ->route('komoditas.index', ['tab' => 'psp'])
                ->with('success', 'Data PSP berhasil ditambahkan! Kode: ' . $kode);

        } catch (\Exception $e) {
            Log::error('PSP Store Error:', [
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data PSP');
        }
    }

    /**
     * Memperbarui data PSP
     * sektor tetap PSP (tidak bisa diubah)
     */
    public function update(Request $request, $id)
    {
        $psp = PrasaranaSarana::findOrFail($id);

        $validated = $request->validate([
            'jenis'    => 'required|string|max:100',
            'kategori' => 'required|string|max:150',
            'item'     => 'required|string|max:150',
            'status'   => 'required|in:Aktif,Nonaktif',
        ]);

        $psp->update([
            'jenis'    => $validated['jenis'],
            'kategori' => $validated['kategori'],
            'item'     => $validated['item'],
            'status'   => $validated['status'],
            // sektor tidak disentuh
        ]);

        return redirect()
            ->route('komoditas.index', ['tab' => 'psp'])
            ->with('success', 'Data PSP berhasil diperbarui');
    }

    /**
     * Menghapus data PSP
     */
    public function destroy($id)
    {
        $psp = PrasaranaSarana::findOrFail($id);
        $psp->delete();

        return back()->with('success', 'Data PSP berhasil dihapus');
    }
}

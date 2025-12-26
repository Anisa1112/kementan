<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Komoditas;
use App\Models\PrasaranaSarana;

class KomoditasController extends Controller
{
    /* =========================
     * DASHBOARD (WELCOME)
     * ========================= */
    public function dashboard(Request $request)
    {
        $query = Komoditas::withJenis(); // ✅ Hanya yang punya jenis (tetap)

        // Filter SEKTOR (diubah dari subsektor)
        if ($request->filled('sektor')) {
            $query->where('sektor', $request->sektor);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode', 'like', '%' . $request->search . '%')
                  ->orWhere('sektor', 'like', '%' . $request->search . '%')
                  ->orWhere('subsektor', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('item', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_latin', 'like', '%' . $request->search . '%');
            });
        }

        $komoditas = $query->orderBy('created_at', 'desc')->get();

        return view('welcome', [
            'komoditas'        => $komoditas,
            'totalKomoditas'   => Komoditas::withJenis()->count(),
            'tanamanPangan'    => Komoditas::withJenis()->where('sektor', 'Tanaman Pangan')->count(),
            'hortikultura'     => Komoditas::withJenis()->where('sektor', 'Hortikultura')->count(),
            'perkebunan'       => Komoditas::withJenis()->where('sektor', 'Perkebunan')->count(),
            'peternakan'       => Komoditas::withJenis()->where('sektor', 'Peternakan & Kesehatan Hewan')->count(),
            'prasaranaSarana'  => Komoditas::withJenis()->where('sektor', 'Prasarana & Sarana')->count(),
        ]);
    }

    /* =========================
     * MASTER KOMODITAS
     * ========================= */
    public function index(Request $request)
    {
        $query = Komoditas::withJenis(); // ✅ Hanya yang punya jenis (tetap)

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter SEKTOR (diubah dari subsektor ke sektor)
        if ($request->filled('sektor')) {
            $query->where('sektor', $request->sektor);
        }

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode', 'like', '%' . $request->search . '%')
                  ->orWhere('sektor', 'like', '%' . $request->search . '%')
                  ->orWhere('subsektor', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('item', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_latin', 'like', '%' . $request->search . '%');
            });
        }

        $komoditas = $query
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $psp = PrasaranaSarana::orderBy('created_at', 'desc')->paginate(20);

        return view('komoditas.index', compact('komoditas', 'psp'));
    }

    /* =========================
     * STORE
     * ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'sektor'     => 'required|string|max:255',
            'subsektor'  => 'nullable|string|max:255',
            'kategori'   => 'nullable|string|max:255',
            'item'       => 'nullable|string|max:255',
            'jenis'      => 'required|string|max:255',
            'nama_latin' => 'nullable|string|max:255',
            'status'     => 'required|in:Aktif,Tidak Aktif',
        ]);

        try {
            $prefix = $this->makePrefix(
                $request->sektor,
                $request->subsektor,
                $request->kategori
            );

            $last = Komoditas::where('kode', 'like', $prefix . '-%')
                ->orderBy('kode', 'desc')
                ->first();

            $number = 1;
            if ($last) {
                $parts = explode('-', $last->kode);
                $number = (int) end($parts) + 1;
            }

            $kode = $prefix . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);

            Komoditas::create([
                'kode'       => $kode,
                'sektor'     => $request->sektor,
                'subsektor'  => $request->subsektor,
                'kategori'   => $request->kategori,
                'item'       => $request->item,
                'jenis'      => $request->jenis,
                'nama_latin' => $request->nama_latin,
                'status'     => $request->status,
            ]);

            return redirect()->route('komoditas')
                ->with('success', 'Data komoditas berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /* =========================
     * UPDATE
     * ========================= */
    public function update(Request $request, $id)
    {
        $komoditas = Komoditas::findOrFail($id);

        $request->validate([
            'sektor'     => 'required|string|max:255',
            'subsektor'  => 'nullable|string|max:255',
            'kategori'   => 'nullable|string|max:255',
            'item'       => 'nullable|string|max:255',
            'jenis'      => 'required|string|max:255',
            'nama_latin' => 'nullable|string|max:255',
            'status'     => 'required|in:Aktif,Tidak Aktif',
        ]);

        try {
            $komoditas->update([
                'sektor'     => $request->sektor,
                'subsektor'  => $request->subsektor,
                'kategori'   => $request->kategori,
                'item'       => $request->item,
                'jenis'      => $request->jenis,
                'nama_latin' => $request->nama_latin,
                'status'     => $request->status,
            ]);

            return redirect()->route('komoditas')
                ->with('success', 'Data komoditas berhasil diperbarui!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /* =========================
     * DESTROY
     * ========================= */
    public function destroy($id)
    {
        try {
            Komoditas::findOrFail($id)->delete();

            return redirect()->route('komoditas')
                ->with('success', 'Data komoditas berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /* =========================
     * PER SEKTOR
     * ========================= */
    public function sektor($slug)
    {
        $sektorName = $this->mapSlugToSektor($slug);

        $komoditas = Komoditas::withJenis() // ✅ Hanya yang punya jenis (tetap)
            ->where('sektor', $sektorName)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('komoditas.sektor', compact('komoditas', 'sektorName', 'slug'));
    }

    /* =========================
     * HELPER
     * ========================= */
   private function makePrefix($sektor, $subsektor = null, $kategori = null)
{
    $map = [
        'Tanaman Pangan' => 'TPN',
        'Hortikultura'   => 'HRT',
        'Perkebunan'     => 'PKB',
        'Peternakan & Kesehatan Hewan' => 'PTN',
    ];

    $result = $map[$sektor] ?? strtoupper(substr($sektor, 0, 3));

    if ($subsektor) {
        $words = explode(' ', $subsektor);
        
        if (count($words) >= 2) {
            // Ambil 2 huruf pertama dari kata pertama + 1 huruf pertama kata kedua
            // Tanaman Obat → TA + O = TAO
            // Tanaman Hias → TA + H = TAH
            // Pakan Ternak → PA + T = PAT
            // Obat Hewan → OB + H = OBH
            $firstWord = strtoupper(substr($words[0], 0, 2));
            $secondWord = strtoupper(substr($words[1], 0, 1));
            $result .= '-' . $firstWord . $secondWord;
        } else {
            // Jika hanya 1 kata, ambil 3 huruf pertama seperti biasa
            // Padi → PAD
            // Palawija → PAL
            // Sayuran → SAY
            $result .= '-' . strtoupper(substr($subsektor, 0, 3));
        }
    }

    if ($kategori) {
        $words = explode(' ', $kategori);
        
        if (count($words) >= 2) {
            // Kategori dengan 2+ kata: ambil huruf pertama setiap kata
            // Rumput Pakan → RP
            // Ruminasia Besar → RB
            // Ruminasia Kecil → RK
            $kategoriCode = '';
            foreach (array_slice($words, 0, 2) as $word) {
                $kategoriCode .= strtoupper(substr($word, 0, 1));
            }
            $result .= '-' . $kategoriCode;
        } else {
            // Jika 1 kata, ambil 2 huruf pertama
            // Unggas → UG
            $result .= '-' . strtoupper(substr($kategori, 0, 2));
        }
    }

    return $result;
}

private function mapSlugToSektor($slug)
{
    return [
        'tanaman-pangan' => 'Tanaman Pangan',
        'hortikultura'   => 'Hortikultura',
        'perkebunan'     => 'Perkebunan',
        'peternakan'     => 'Peternakan & Kesehatan Hewan',
    ][$slug] ?? $slug;
}
}
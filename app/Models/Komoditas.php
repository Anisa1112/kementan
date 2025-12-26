<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'komoditas';

    /**
     * Field yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'kode',
        'sektor',
        'subsektor',
        'kategori',
        'item',
        'jenis',
        'nama_latin',
        'status',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* =========================
     * SCOPES
     * ========================= */

    /**
     * Scope untuk hanya menampilkan data yang punya jenis
     * 
     * Usage: Komoditas::withJenis()->get()
     */
    public function scopeWithJenis($query)
    {
        return $query->whereNotNull('jenis')
                     ->where('jenis', '!=', '');
    }

    /**
     * Scope untuk data lengkap (ada item DAN jenis)
     * 
     * Usage: Komoditas::lengkap()->get()
     */
    public function scopeLengkap($query)
    {
        return $query->whereNotNull('jenis')
                     ->where('jenis', '!=', '')
                     ->whereNotNull('item')
                     ->where('item', '!=', '');
    }

    /**
     * Scope untuk filter berdasarkan sektor
     * 
     * Usage: Komoditas::bySektor('Tanaman Pangan')->get()
     */
    public function scopeBySektor($query, $sektor)
    {
        return $query->where('sektor', $sektor);
    }

    /**
     * Scope untuk filter berdasarkan subsektor
     * 
     * Usage: Komoditas::bySubsektor('Padi')->get()
     */
    public function scopeBySubsektor($query, $subsektor)
    {
        return $query->where('subsektor', $subsektor);
    }

    /**
     * Scope untuk filter berdasarkan kategori
     * 
     * Usage: Komoditas::byKategori('Padi Sawah')->get()
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk filter status aktif
     * 
     * Usage: Komoditas::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Scope untuk filter status tidak aktif
     * 
     * Usage: Komoditas::inactive()->get()
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'Tidak Aktif');
    }

    /**
     * Scope untuk pencarian
     * 
     * Usage: Komoditas::search('padi')->get()
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('kode', 'like', "%{$search}%")
              ->orWhere('sektor', 'like', "%{$search}%")
              ->orWhere('subsektor', 'like', "%{$search}%")
              ->orWhere('kategori', 'like', "%{$search}%")
              ->orWhere('item', 'like', "%{$search}%")
              ->orWhere('jenis', 'like', "%{$search}%")
              ->orWhere('nama_latin', 'like', "%{$search}%");
        });
    }

    /* =========================
     * ACCESSORS
     * ========================= */

    /**
     * Accessor untuk nama lengkap komoditas
     * 
     * Usage: $komoditas->nama_lengkap
     */
    public function getNamaLengkapAttribute()
    {
        $parts = array_filter([
            $this->sektor,
            $this->subsektor,
            $this->kategori,
            $this->item,
            $this->jenis,
        ]);

        return implode(' - ', $parts);
    }

    /**
     * Accessor untuk cek apakah data lengkap
     * 
     * Usage: $komoditas->is_lengkap
     */
    public function getIsLengkapAttribute()
    {
        return !empty($this->jenis) && !empty($this->item);
    }

    /**
     * Accessor untuk cek apakah aktif
     * 
     * Usage: $komoditas->is_active
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'Aktif';
    }

    /* =========================
     * METHODS
     * ========================= */

    /**
     * Aktifkan komoditas
     */
    public function activate()
    {
        $this->update(['status' => 'Aktif']);
    }

    /**
     * Nonaktifkan komoditas
     */
    public function deactivate()
    {
        $this->update(['status' => 'Tidak Aktif']);
    }
}
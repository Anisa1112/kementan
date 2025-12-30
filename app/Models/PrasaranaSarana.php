<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrasaranaSarana extends Model
{
    use HasFactory;

    protected $table = 'prasarana_sarana';

    protected $fillable = [
        'kode',
        'sektor',
        'jenis',
        'kategori',
        'item',
        'status'
    ];

}

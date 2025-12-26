<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    
        Schema::create('komoditas', function (Blueprint $table) {
            $table->id();
            // $table->string('sektor')->nullable();
            // $table->string('subsektor')->nullable();
            // $table->string('kategori')->nullable();
            // $table->string('item')->nullable();
            $table->string('kode')->unique();
            $table->string('nama_latin')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
}


    public function down(): void
    {
        Schema::dropIfExists('komoditas');
    }
};

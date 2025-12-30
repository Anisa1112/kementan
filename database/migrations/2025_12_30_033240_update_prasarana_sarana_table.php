<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up()
        {
           Schema::create('prasarana_sarana', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 50)->unique();
            $table->string('sektor', 100);      // contoh: PSP
            $table->string('jenis', 100);       // contoh: Bantuan / Subsidi
            $table->string('kategori', 150);    // contoh: Alat dan Mesin / Pupuk
            $table->string('item', 150);        // contoh: Traktor Roda 2

            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->timestamps();
        });
        }

    public function down()
    {
        Schema::dropIfExists('prasarana_sarana');
    }
};


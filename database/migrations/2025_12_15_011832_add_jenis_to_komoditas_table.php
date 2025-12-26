<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::table('komoditas', function (Blueprint $table) {
        // item boleh kosong
        $table->string('item')->nullable()->change();

        // jenis wajib diisi
        $table->string('jenis')->after('item'); // tanpa nullable()
    });

    }
};

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
   // $table->dropColumn(['nama_indonesia', 'jenis', 'parent_id']);
    $table->string('sektor')->nullable();
    $table->string('subsektor')->nullable();
    $table->string('kategori')->nullable();
    $table->string('item')->nullable();
    
});


        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

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
        Schema::create('prasarana_sarana', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255)->unique();
            $table->string('nama', 255);
            $table->string('jenis', 255);
            $table->string('subsektor', 255);
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prasarana_sarana');
    }
};

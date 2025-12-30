<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up()
        {
            Schema::table('prasarana_sarana', function (Blueprint $table) {
                $table->string('kode', 50)->change();
                $table->string('sektor', 100)->after('kode');
                $table->string('kategori', 150)->after('jenis');
                $table->string('item', 150)->after('kategori');
                $table->dropColumn(['nama', 'subsektor']);
            });
        }


    public function down()
    {
        Schema::table('prasarana_sarana', function (Blueprint $table) {

            // Kembalikan kolom lama
            $table->string('nama', 255)->after('kode');
            $table->string('subsektor', 255)->after('jenis');

            // Hapus kolom baru
            $table->dropColumn(['sektor', 'kategori', 'item']);

            // Kembalikan panjang kode
            $table->string('kode', 255)->change();
        });
    }

};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratBalasanPemohon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_balasan_pemohon', function (Blueprint $table) {
            $table->id();
            $table->integer('id_surat');
            $table->string('email');
            $table->string('nama_pemohon');
            $table->string('nim');
            $table->integer('id_jurusan');
            $table->integer('id_divisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_balasan_pemohon');
    }
}

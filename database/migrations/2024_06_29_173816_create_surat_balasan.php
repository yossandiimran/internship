<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratBalasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_balasan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pemohon');
            $table->string('asal_sekolah_pemohon');
            $table->string('nomor_surat_pengantar')->nullable();
            $table->string('file_surat_pengantar')->nullable();
            $table->date('tanggal_surat_pengantar')->nullable();
            $table->string('nomor_surat_balasan')->nullable();
            $table->date('tanggal_surat_balasan')->nullable();
            $table->string('file_surat_balasan')->nullable();
            $table->string('nomor_surat_mou')->nullable();
            $table->date('tanggal_surat_mou')->nullable();
            $table->string('file_surat_mou')->nullable();
            $table->string('pembimbing')->nullable();
            $table->string('ttd_pembimbing')->nullable();
            $table->string('status_permohonan')->nullable();
            $table->integer('status_surat')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('surat_balasan');
    }
}

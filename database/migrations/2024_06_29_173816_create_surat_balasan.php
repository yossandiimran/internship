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
            $table->string('nomor_surat_balasan');
            $table->string('asal_sekolah_pemohon');
            $table->date('tanggal_dibuat');
            $table->string('nomor_surat_mou');
            $table->date('tanggal_surat_mou');
            $table->string('status_pemohon');
            $table->string('pembimbing');
            $table->string('ttd_pembimbing');
            $table->integer('status_surat');
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

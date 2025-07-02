<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_penilaian');
            $table->integer('user');
            $table->integer('kedisiplinan');
            $table->double('tanggung_jawab');
            $table->double('kerapihan');
            $table->double('komunikasi');
            $table->double('pemahaman_pekerjaan');
            $table->double('manahemen_waktu');
            $table->double('kerja_sama');
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
        Schema::dropIfExists('penilaian');
    }
}

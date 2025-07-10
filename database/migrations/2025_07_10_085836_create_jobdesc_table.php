<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobdescTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobdesc', function (Blueprint $table) {
            $table->id();
            $table->integer('assign_to');
            $table->string('pekerjaan');
            $table->string('gambar_awal');
            $table->string('gambar_akhir');
            $table->integer('status');
            $table->timestamp('waktu_mulai');
            $table->timestamp('waktu_akhir');
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
        Schema::dropIfExists('jobdesc');
    }
}

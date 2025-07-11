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
            $table->string('assign_to');
            $table->string('pekerjaan');
            $table->string('gambar_awal')->nullable();
            $table->string('gambar_akhir')->nullable();
            $table->integer('status');
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_akhir')->nullable();
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

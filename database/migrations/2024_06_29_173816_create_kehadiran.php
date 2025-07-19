<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehadiran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('kehadiran')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamp('jam_masuk')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->timestamp('jam_keluar')->nullable();
            $table->string('foto_keluar')->nullable();
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
        Schema::dropIfExists('kehadiran');
    }
}

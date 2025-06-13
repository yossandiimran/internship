<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_timesheet', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->timestamp('jobdesc')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamp('jam_mulai')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->timestamp('jam_selesai')->nullable();
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
        Schema::dropIfExists('create_timesheet');
    }
}

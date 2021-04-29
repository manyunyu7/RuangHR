<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bonus');
            $table->string('deskripsi_bonus');
            $table->bigInteger('jumlah');
            $table->unsignedBigInteger('id_pemberi');
            $table->unsignedBigInteger('id_penerima');
            $table->foreign('id_pemberi')->references('id')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_penerima')->references('id')->on('pegawai')->onDelete('cascade');
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
        Schema::dropIfExists('bonus');
    }
}

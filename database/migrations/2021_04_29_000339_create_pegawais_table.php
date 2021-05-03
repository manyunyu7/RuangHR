<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depan');
            $table->string('nama_belakang')->nullable();
            $table->string('email');
            $table->string('no_hp');
            $table->string('gender');
            $table->text('alamat');
            $table->string('photo_path')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_lahir');
            $table->unsignedBigInteger('id_pekerjaan')->nullable();
            $table->foreign('id_pekerjaan')->references('id')->on('pekerjaan')->onDelete('cascade');
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
        Schema::dropIfExists('pegawai');
    }
}

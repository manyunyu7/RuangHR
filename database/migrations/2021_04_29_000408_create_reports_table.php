<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pelapor');
            $table->foreign('id_pelapor')->references('id')->on('pegawai')->onDelete('cascade');
            $table->unsignedBigInteger('id_terlapor');
            $table->foreign('id_terlapor')->references('id')->on('pegawai')->onDelete('cascade');
            $table->text('isi_laporan');
            $table->text('bukti_foto')->nullable();
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
        Schema::dropIfExists('report');
    }
}

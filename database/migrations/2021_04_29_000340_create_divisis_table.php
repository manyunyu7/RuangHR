<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_divisi');
            $table->unsignedBigInteger('lead_divisi')->nullable();
            $table->unsignedBigInteger('co_lead_divisi')->nullable();
            $table->foreign('lead_divisi')->references('id')->on('pegawai')->onDelete('cascade');
            $table->string('kontak_divisi');
            $table->string('alamat_divisi');
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
        Schema::dropIfExists('divisi');
    }
}

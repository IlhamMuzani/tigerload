<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depositpemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_deposit')->nullable();
            $table->string('kode_qrcode')->nullable();
            $table->string('qrcode_deposit')->nullable();
            $table->unsignedBigInteger('perintah_kerja_id')->nullable();
            $table->foreign('perintah_kerja_id')->references('id')->on('perintah_kerjas')->onDelete('set null');
            $table->string('harga')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_transfer')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('deleted_at')->nullable();

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
        Schema::dropIfExists('depositpemesanans');
    }
};
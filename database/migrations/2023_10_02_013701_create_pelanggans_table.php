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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pelanggan')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('nama_alias')->nullable();
            $table->string('qrcode_pelanggan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('gender')->nullable();
            $table->string('umur')->nullable();
            $table->string('gambar_ktp')->nullable();
            $table->string('telp')->nullable();
            $table->string('email')->nullable();
            $table->string('ig')->nullable();
            $table->string('fb')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
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
        Schema::dropIfExists('pembelians');
    }
};
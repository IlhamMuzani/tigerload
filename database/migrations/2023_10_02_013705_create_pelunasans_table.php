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
        Schema::create('pelunasans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pelunasan')->nullable();
            $table->string('qrcode_pelunasan')->nullable();
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('set null');
            $table->string('potongan')->nullable();
            $table->string('kategori')->nullable();
            $table->string('nomor')->nullable();
            $table->string('tanggal_transfer')->nullable();
            $table->string('nominal')->nullable();
            $table->string('totalpenjualan')->nullable();
            $table->string('dp')->nullable();
            $table->string('totalpembayaran')->nullable();
            $table->string('selisih')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_pelunasan')->nullable();
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
        Schema::dropIfExists('pelunasans');
    }
};
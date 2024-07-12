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
        Schema::create('faktur_pajaks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pajak')->nullable();
            $table->string('qrcode_pajak')->nullable();
            $table->string('kategori')->nullable();
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('set null');
            $table->unsignedBigInteger('pembelian_id')->nullable();
            $table->foreign('pembelian_id')->references('id')->on('pembelians')->onDelete('set null');
            $table->string('gambar_pajak')->nullable();
            $table->string('nomor_pajak')->nullable();
            $table->string('tanggal_pajak')->nullable();
            $table->string('tanggal')->nullable();
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
        Schema::dropIfExists('faktur_pajaks');
    }
};
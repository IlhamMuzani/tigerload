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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->nullable();
            $table->string('kode_penjualan')->nullable();
            $table->string('qrcode_penjualan')->nullable();
            $table->unsignedBigInteger('spk_id')->nullable();
            $table->foreign('spk_id')->references('id')->on('spks')->onDelete('set null');
            $table->unsignedBigInteger('depositpemesanan_id')->nullable();
            $table->foreign('depositpemesanan_id')->references('id')->on('depositpemesanans')->onDelete('set null');
            $table->string('harga')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_pajak')->nullable();
            $table->string('status_pelunasan')->nullable();
            $table->string('status_komisi')->nullable();
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
        Schema::dropIfExists('penjualans');
    }
};
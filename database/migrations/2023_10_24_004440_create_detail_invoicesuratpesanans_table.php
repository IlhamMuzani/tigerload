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
        Schema::create('detail_invoicesuratpesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_suratpesanan_id')->nullable();
            $table->foreign('invoice_suratpesanan_id')->references('id')->on('invoice_suratpesanans');
            $table->unsignedBigInteger('spk_id')->nullable();
            $table->foreign('spk_id')->references('id')->on('spks');
            $table->string('kode_pesanan')->nullable();
            $table->string('tanggal_pesanan')->nullable();
            $table->string('merek')->nullable();
            $table->string('tipemerek')->nullable();
            $table->string('kode_karoseri')->nullable();
            $table->string('nama_karoseri')->nullable();
            $table->string('harga')->nullable();
            $table->string('status')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
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
        Schema::dropIfExists('detail_invoicesuratpesanans');
    }
};
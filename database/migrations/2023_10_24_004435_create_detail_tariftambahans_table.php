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
        Schema::create('detail_tariftambahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_suratpesanan_id')->nullable();
            $table->foreign('invoice_suratpesanan_id')->references('id')->on('invoice_suratpesanans');
            $table->string('kode_tambahan')->nullable();
            $table->string('keterangan_tambahan')->nullable();
            $table->string('nominal_tambahan')->nullable();
            $table->string('qty_tambahan')->nullable();
            $table->string('satuan_tambahan')->nullable();
            $table->string('tanggal_awal')->nullable();
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
        Schema::dropIfExists('detail_tariftambahans');
    }
};
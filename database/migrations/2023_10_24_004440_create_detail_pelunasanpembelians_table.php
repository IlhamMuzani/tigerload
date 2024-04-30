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
        Schema::create('detail_pelunasanpembelians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_pelunasanpembelian_id')->nullable();
            $table->foreign('faktur_pelunasanpembelian_id')->references('id')->on('faktur_pelunasanpembelians');
            $table->unsignedBigInteger('pembelian_id')->nullable();
            $table->foreign('pembelian_id')->references('id')->on('pembelians');
            $table->string('kode_pembelian')->nullable();
            $table->string('tanggal_pembelian')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('detail_pelunasanpembelians');
    }
};
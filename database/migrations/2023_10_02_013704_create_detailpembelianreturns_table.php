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
        Schema::create('detailpembelianreturns', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang')->nullable();
            $table->unsignedBigInteger('returnpembelian_id')->nullable();
            $table->foreign('returnpembelian_id')->references('id')->on('returnpembelians');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->string('satuan')->nullable();
            $table->string('spesifikasi')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('harga')->nullable();
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
        Schema::dropIfExists('detailpembelianreturns');
    }
};
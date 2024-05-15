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
        Schema::create('spesifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreign('typekaroseri_id')->references('id')->on('typekaroseris')->onDelete('set null');
            $table->unsignedBigInteger('typekaroseri_id')->nullable();
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('set null');
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('set null');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->string('kode_barang')->nullable();
            $table->string('nama')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('harga')->nullable();
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
        Schema::dropIfExists('spesifikasis');
    }
};
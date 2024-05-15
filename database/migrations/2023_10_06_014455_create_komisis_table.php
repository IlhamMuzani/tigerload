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
        Schema::create('komisis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_komisi')->nullable();
            $table->string('kode_faktur')->nullable();
            $table->string('kategori')->nullable();
            $table->string('harga')->nullable();
            $table->string('fee')->nullable();
            $table->string('qrcode_komisi')->nullable();
            $table->unsignedBigInteger('spk_id')->nullable();
            $table->foreign('spk_id')->references('id')->on('spks')->onDelete('set null');
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('set null');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->unsignedBigInteger('marketing_id')->nullable();
            $table->foreign('marketing_id')->references('id')->on('marketings')->onDelete('set null');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
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
        Schema::dropIfExists('komisis');
    }
};
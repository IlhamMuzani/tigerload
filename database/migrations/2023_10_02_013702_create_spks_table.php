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
        Schema::create('spks', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('gambar_npwp')->nullable();
            $table->string('kode_spk')->nullable();
            $table->string('qrcode_spk')->nullable();
            $table->unsignedBigInteger('typekaroseri_id')->nullable();
            $table->foreign('typekaroseri_id')->references('id')->on('typekaroseris')->onDelete('set null');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->unsignedBigInteger('marketing_id')->nullable();
            $table->foreign('marketing_id')->references('id')->on('marketings')->onDelete('set null');
            $table->string('aksesoris')->nullable();
            $table->string('harga')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_komisi')->nullable();
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
        Schema::dropIfExists('spks');
    }
};
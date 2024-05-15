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
        Schema::create('detail_suratpenawarans', function (Blueprint $table) {
            $table->id();
            $table->foreign('surat_penawaran_id')->references('id')->on('surat_penawarans')->onDelete('set null');
            $table->unsignedBigInteger('surat_penawaran_id')->nullable();
            $table->string('kode_karoseri')->nullable();
            $table->string('qrcode_kendaraan')->nullable();
            $table->string('no_rangka')->nullable();
            $table->string('no_mesin')->nullable();
            $table->string('tahun')->nullable();
            $table->string('warna')->nullable();
            $table->unsignedBigInteger('merek_id')->nullable();
            $table->foreign('merek_id')->references('id')->on('mereks')->onDelete('set null');
            $table->string('gambar_gesekannorangka')->nullable();
            $table->string('gambar_gesekannomesin')->nullable();
            $table->string('gambar_rancangbangun')->nullable();
            $table->string('gambar_serut')->nullable();
            $table->string('gambar_dokumen')->nullable();
            $table->string('gambar_faktur')->nullable();
            $table->string('gambar_depan')->nullable();
            $table->string('gambar_belakang')->nullable();
            $table->string('gambar_kanan')->nullable();
            $table->string('gambar_kiri')->nullable();
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
        Schema::dropIfExists('detail_suratpenawarans');
    }
};
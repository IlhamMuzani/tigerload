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
        Schema::create('dokumen_projects', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('perintah_kerja_id')->references('id')->on('perintah_kerjas')->onDelete('set null');
            $table->unsignedBigInteger('perintah_kerja_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('typekaroseri_id')->references('id')->on('typekaroseris')->onDelete('set null');
            $table->unsignedBigInteger('typekaroseri_id')->nullable();
            $table->string('kode_dokumen')->nullable();
            $table->string('qrcode_dokumen')->nullable();
            $table->string('keterangan')->nullable();
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
            $table->string('gambardepan_serongkanan')->nullable();
            $table->string('gambardepan_serongkiri')->nullable();
            $table->string('gambarbelakang_serongkanan')->nullable();
            $table->string('gambarbelakang_serongkekiri')->nullable();
            $table->string('gambarberita_acara')->nullable();
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
        Schema::dropIfExists('dokumen_projects');
    }
};
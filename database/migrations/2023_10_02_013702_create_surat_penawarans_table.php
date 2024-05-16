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
        Schema::create('surat_penawarans', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('gambar_npwp')->nullable();
            $table->string('kode_spk')->nullable();
            $table->string('qrcode_penawaran')->nullable();
            $table->unsignedBigInteger('typekaroseri_id')->nullable();
            $table->foreign('typekaroseri_id')->references('id')->on('typekaroseris')->onDelete('set null');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->string('nama_pelanggan')->nullable();
            $table->string('kode_pelanggan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->unsignedBigInteger('marketing_id')->nullable();
            $table->foreign('marketing_id')->references('id')->on('marketings')->onDelete('set null');
            $table->unsignedBigInteger('merek_id')->nullable();
            $table->foreign('merek_id')->references('id')->on('mereks')->onDelete('set null');
            $table->string('nama_merek')->nullable();
            $table->string('tipe')->nullable();
            $table->string('kode_type')->nullable();
            $table->string('nama_karoseri')->nullable();
            $table->string('panjang')->nullable();
            $table->string('lebar')->nullable();
            $table->string('tinggi')->nullable();
            $table->string('spesifikasi')->nullable();
            $table->string('aksesoris')->nullable();
            $table->string('jumlah_unit')->nullable();
            $table->string('harga')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_spk')->nullable();
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
        Schema::dropIfExists('surat_penawarans');
    }
};
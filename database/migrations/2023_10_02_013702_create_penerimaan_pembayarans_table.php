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
        Schema::create('penerimaan_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penerimaan')->nullable();
            $table->string('qrcode_penerimaan')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('surat_penawaran_id')->nullable();
            $table->foreign('surat_penawaran_id')->references('id')->on('surat_penawarans')->onDelete('set null');
            $table->unsignedBigInteger('typekaroseri_id')->nullable();
            $table->foreign('typekaroseri_id')->references('id')->on('typekaroseris')->onDelete('set null');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->string('kategoris')->nullable();
            // $table->string('harga')->nullable();
            $table->string('tanggal_pembayaran')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('penerimaan_pembayarans');
    }
};
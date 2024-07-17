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
        Schema::create('perintah_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perintah')->nullable();
            $table->string('kode_qrcode')->nullable();
            $table->string('qrcode_perintah')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('spk_id')->nullable();
            $table->foreign('spk_id')->references('id')->on('spks')->onDelete('set null');
            $table->unsignedBigInteger('typekaroseri_id')->nullable();
            $table->foreign('typekaroseri_id')->references('id')->on('typekaroseris')->onDelete('set null');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->string('keterangan')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_deposit')->nullable();
            $table->string('status_penjualan')->nullable();
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
        Schema::dropIfExists('perintah_kerjas');
    }
};
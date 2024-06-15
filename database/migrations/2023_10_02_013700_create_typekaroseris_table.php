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
        Schema::create('typekaroseris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karoseri')->nullable();
            $table->string('kode_type')->nullable();
            $table->string('qrcode_karoseri')->nullable();
            $table->string('type_kendaraan')->nullable();
            $table->string('panjang')->nullable();
            $table->string('lebar')->nullable();
            $table->string('tinggi')->nullable();
            $table->unsignedBigInteger('merek_id')->nullable();
            $table->foreign('merek_id')->references('id')->on('mereks')->onDelete('set null');
            $table->string('nama_merek')->nullable();
            $table->string('tipe')->nullable();
            $table->string('aksesoris')->nullable();
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
        Schema::dropIfExists('typekaroseris');
    }
};
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
            // $table->string('cros_member')->nullable();
            // $table->string('fream_samping')->nullable();
            // $table->string('diafragma')->nullable();
            // $table->string('lantai')->nullable();
            // $table->string('dinding')->nullable();
            // $table->string('pilar_depan')->nullable();
            // $table->string('pilar_belakang')->nullable();
            // $table->string('pengaman')->nullable();
            // $table->string('dinding')->nullable();
            // $table->string('warna_dalam')->nullable();
            // $table->string('warna_luar')->nullable();
            $table->string('aksesoris')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
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
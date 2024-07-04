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
        Schema::create('detail_perhitunganbahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengambilan')->nullable();
            $table->unsignedBigInteger('pengambilanbahan_id')->nullable();
            $table->foreign('pengambilanbahan_id')->references('id')->on('pengambilanbahans');
            $table->string('tanggal')->nullable();
            $table->string('harga')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_perhitunganbahans');
    }
};
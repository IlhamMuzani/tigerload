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
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('set null');
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->foreign('typekaroseri_id')->references('id')->on('typekaroseris')->onDelete('set null');
            $table->unsignedBigInteger('typekaroseri_id')->nullable();
            $table->string('kode_types')->nullable();
            $table->string('nama_karoseri')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('harga')->nullable();
            $table->string('diskon')->nullable();
            $table->string('total')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('detail_penjualans');
    }
};
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
        Schema::create('mereks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_merek')->unique();
            $table->string('nama_merek')->nullable();
            $table->unsignedBigInteger('modelken_id')->nullable();
            $table->foreign('modelken_id')->references('id')->on('modelkens')->onDelete('set null');
            $table->unsignedBigInteger('tipe_id')->nullable();
            $table->foreign('tipe_id')->references('id')->on('tipes')->onDelete('set null');
            $table->string('qrcode_merek')->nullable();
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
        Schema::dropIfExists('mereks');
    }
};
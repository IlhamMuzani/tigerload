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
        Schema::create('oraderans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelian')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->string('qrcode_pembelian')->nullable();
            $table->string('nama_supplier')->nullable();
            $table->string('alamat')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('syarat')->nullable();
            $table->string('waktu')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_pelunasan')->nullable();
            $table->string('status_notif')->nullable();
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
        Schema::dropIfExists('oraderans');
    }
};
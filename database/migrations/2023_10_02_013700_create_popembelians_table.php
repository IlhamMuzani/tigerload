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
        Schema::create('popembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_po_pembelian')->nullable();
            $table->string('qrcode_popembelian')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('popembelians');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('barang_id');
        $table->integer('jumlah_sewa');
        $table->integer('durasi_sewa');
        $table->bigInteger('total_harga');
        $table->string('status');
        $table->timestamps();

        // Relasi ke tabel barangs
        $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
    });
}


};

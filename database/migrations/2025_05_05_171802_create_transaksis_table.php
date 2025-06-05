<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penyewa');
            $table->string('nama_barang');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah_sewa');
            $table->integer('durasi_sewa');
            $table->bigInteger('total_harga');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE transaksis ADD CONSTRAINT valid_status_values CHECK (status IN ('pending', 'success', 'failed', 'canceled'))");
    }

    public function down()
    {
        DB::statement("ALTER TABLE transaksis DROP CHECK IF EXISTS valid_status_values");
        Schema::dropIfExists('transaksis');
    }
};
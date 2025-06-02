<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Tambahkan setelah kolom id atau kolom lain yang sesuai
            // Pastikan tipe data dan atributnya sesuai dengan bagaimana Anda membuat order_id di TransactionController
            // $orderId = 'INV-' . time() . '-' . rand(1000, 9999); <-- ini string
            $table->string('order_id')->unique()->after('id')->nullable()->comment('Order ID dari Midtrans');
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
};
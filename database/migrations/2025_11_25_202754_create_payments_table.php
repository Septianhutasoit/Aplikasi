<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // user yang bayar
            $table->string('order_id')->nullable(); // nomor invoice / order
            $table->decimal('amount', 12, 2);

            // jenis metode bayar
            $table->enum('payment_method', ['qris', 'cod', 'transfer'])->default('qris');

            // gateway / provider pembayaran (midtrans, manual, dll)
            $table->string('payment_gateway')->default('midtrans');

            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('barcode')->nullable()->unique(); // untuk QRIS / COD
            $table->string('receipt')->nullable(); // upload bukti transfer
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

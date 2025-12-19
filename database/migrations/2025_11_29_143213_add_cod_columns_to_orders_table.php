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
        Schema::table('orders', function (Blueprint $table) {
            // Tambah kolom baru
            $table->string('payment_method')->default('QRIS')->after('payment_status');
            $table->string('cod_time')->nullable()->after('payment_method');
            $table->text('cod_note')->nullable()->after('cod_time');

            // CATATAN: Karena Anda menggunakan enum 'payment_status' ['pending', 'paid'] di tabel lama,
            // COD akan kita simpan sebagai 'pending' dulu agar tidak error, 
            // atau kita perlu ubah struktur kolom payment_status (agak rumit jika data harus dijaga).
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'cod_time', 'cod_note']);
        });
    }
};

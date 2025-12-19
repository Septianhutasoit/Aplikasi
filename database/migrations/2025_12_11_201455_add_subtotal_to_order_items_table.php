<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // cuma tambah kalau belum ada, biar aman
            if (!Schema::hasColumn('order_items', 'subtotal')) {
                $table->integer('subtotal')->nullable()->after('price');
                // kalau 'price' kamu decimal, pakai:
                // $table->decimal('subtotal', 15, 2)->nullable()->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }
};

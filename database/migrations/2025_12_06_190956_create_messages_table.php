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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel conversations (pesan ini milik topik mana)
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            // Isi pesan chat
            $table->text('body');
            // Penanda: Kalau 1 (true) berarti dari Admin, kalau 0 (false) berarti dari User
            $table->boolean('is_admin_reply')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};

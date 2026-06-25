<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Jalankan SETELAH players table sudah ada
    // Fix: nama tabel harus 'rooms', bukan 'host'
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('host_player_id')
                  ->nullable()
                  ->after('code')
                  ->constrained('players')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['host_player_id']);
            $table->dropColumn('host_player_id');
        });
    }
};
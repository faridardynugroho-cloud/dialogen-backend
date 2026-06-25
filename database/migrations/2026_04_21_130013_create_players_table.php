<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->string('uuid')->nullable();
            $table->unique(['uuid', 'room_id']);
            $table->boolean('is_host')->default(false);
            $table->integer('score')->default(0);
            $table->string('color_avatar', 7)->default('#FFB4B4');
            $table->integer('lobby_position')->default(0);
            $table->boolean('is_online')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};

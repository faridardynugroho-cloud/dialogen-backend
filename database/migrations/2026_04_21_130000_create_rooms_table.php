<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique();
            $table->enum('status', ['waiting', 'playing', 'finished'])->default('waiting');
            $table->string('category')->default('Bahasa Jawa');
            $table->string('time_limit')->default('2');
            $table->integer('max_players')->default(4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
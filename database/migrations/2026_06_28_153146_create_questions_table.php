<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->string('language', 30);

            $table->text('question');

            $table->json('options');

            $table->unsignedTinyInteger('correct_option');

            $table->json('keywords')->nullable();

            $table->string('meaning_hash', 64)->nullable();

            $table->unsignedInteger('usage_count')->default(0);

            $table->timestamps();

            $table->index(['language', 'meaning_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
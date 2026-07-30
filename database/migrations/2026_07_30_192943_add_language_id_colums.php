<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nullable dulu — supaya bisa deploy tanpa downtime,
        // lalu di-backfill, baru nanti di-nonNull-kan di migration terpisah.

        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('language_id')->nullable()->after('language')
                ->constrained('languages')->nullOnDelete();
        });

        Schema::table('question_pools', function (Blueprint $table) {
            $table->foreignId('language_id')->nullable()->after('language')
                ->constrained('languages')->nullOnDelete();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('language_id')->nullable()->after('category')
                ->constrained('languages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('language_id');
        });

        Schema::table('question_pools', function (Blueprint $table) {
            $table->dropConstrainedForeignId('language_id');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropConstrainedForeignId('language_id');
        });
    }
};
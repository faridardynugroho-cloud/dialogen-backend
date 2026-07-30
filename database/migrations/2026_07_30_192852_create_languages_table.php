<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();

            // Slug pendek, dipakai internal (misal buat nama file prompt)
            $table->string('code', 30)->unique(); // jawa, sunda, minangkabau, bali, bugis

            // Nama tampilan, ini yang selama ini nongol sebagai 'Bahasa Jawa' dkk
            $table->string('name', 50)->unique();

            // Menggantikan mapping hardcoded di QuestionGeneratorService::loadStyleInstruction
            $table->string('style_file', 100)->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
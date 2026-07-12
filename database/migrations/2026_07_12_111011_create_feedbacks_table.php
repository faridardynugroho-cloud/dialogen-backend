<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['bug', 'saran', 'lainnya'])->default('bug');
            $table->string('title');
            $table->text('message');
            $table->string('email')->nullable();

            // Device / app info — dikirim otomatis dari aplikasi Flutter via query string
            $table->string('app_version')->nullable();
            $table->string('app_build')->nullable();
            $table->string('platform')->nullable(); // android / ios / unknown

            // Status tracking untuk admin
            $table->enum('status', ['baru', 'diproses', 'selesai', 'diabaikan'])->default('baru');
            $table->text('admin_notes')->nullable();

            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};

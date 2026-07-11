<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_pools', function (Blueprint $table) {
            $table->id();

            $table->string('language',30)->unique();

            $table->unsignedInteger('total_questions')->default(0);

            $table->unsignedInteger('fresh_questions')->default(0);

            $table->boolean('is_generating')->default(false);

            $table->timestamp('last_generated')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_pools');
    }
};
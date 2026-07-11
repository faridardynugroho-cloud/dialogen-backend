<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_questions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('room_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained()
                ->cascadeOnDelete();

            // urutan soal
            $table->unsignedTinyInteger('question_order');

            $table->timestamps();

            // supaya satu urutan tidak dobel
            $table->unique([
                'room_id',
                'question_order'
            ]);

            // supaya satu soal tidak dobel dalam satu room
            $table->unique([
                'room_id',
                'question_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_questions');
    }
};
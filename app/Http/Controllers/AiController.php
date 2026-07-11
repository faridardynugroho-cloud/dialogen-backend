<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateQuestionsJob;
use App\Services\QuestionGeneratorService;
use App\Services\QuestionPoolService;
use App\Services\QuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    public function __construct(
        protected QuestionPoolService    $poolService,
        protected QuestionGeneratorService $generator,
        protected QuestionService        $questionService,
    ) {}

   public function generateQuestions(Request $request)
{
    $request->validate([
        'category' => 'required|string',
    ]);

    $language = $request->category;

    try {
        // Stok menipis — isi ulang di background
        if ($this->poolService->needGenerate($language)) {
            GenerateQuestionsJob::dispatch(
                language: $language,
                target: 100
            );
        }

        $questions = $this->questionService->getQuestions($language);

        return response()->json([
            'questions' => $questions,
            'category'  => $request->category,
            'total'     => $questions->count(),
        ]);

    } catch (\Throwable $e) {
        Log::error($e);
        return response()->json(['message' => 'Gagal mengambil soal.'], 500);
    }
}
}
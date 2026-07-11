<?php

namespace App\Jobs;

use App\Services\QuestionGeneratorService;
use App\Services\QuestionPoolService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $language;
    protected int $target;

    public function __construct(
        string $language,
        int $target = 100
    ) {
        $this->language = $language;
        $this->target = $target;
    }

    public function handle(
        QuestionGeneratorService $generator,
        QuestionPoolService $poolService
    ): void {
        $batchSize = 5;

        try {
            $totalBatch = (int) ceil($this->target / $batchSize);

            for ($i = 0; $i < $totalBatch; $i++) {
                try {
                    $questions = $generator->generate($this->language, $batchSize);

                    $inserted = count($questions);

                    $poolService->increaseQuestions($this->language, $inserted);

                    Log::info("Batch {$i} selesai: {$inserted} soal berhasil disimpan.", [
                        'language' => $this->language,
                        'batch'    => $i,
                    ]);

                } catch (\Exception $e) {
                    // Batch ini gagal, tapi lanjut ke batch berikutnya
                    Log::warning("Batch {$i} gagal: {$e->getMessage()}", [
                        'language' => $this->language,
                        'batch'    => $i,
                    ]);
                }
            }

        } finally {
            // Selalu dijalankan, baik sukses maupun gagal total
            $poolService->markFinished($this->language);
        }
    }
}
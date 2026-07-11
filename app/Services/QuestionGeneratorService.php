<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\Log;

class QuestionGeneratorService
{
    public function __construct(
        protected OpenAIService $openAI
    ) {}

    private function loadPrompt(string $file): string
    {
        return file_get_contents(
            resource_path("prompts/$file")
        );
    }

     private function loadStyleInstruction(string $language): string
    {
        $map = [
            'Bahasa Jawa'        => 'jawa.txt',
            'Bahasa Sunda'       => 'sunda.txt',
            'Bahasa Minangkabau' => 'minangkabau.txt',
            'Bahasa Bali'        => 'bali.txt',
            'Bahasa Bugis'       => 'bugis.txt',
        ];

        $file = $map[$language] ?? null;

        if (!$file) {
            return "Gunakan {$language} sehari-hari yang alami.";
        }

        $path = resource_path("prompts/styles/{$file}");

        if (!file_exists($path)) {
            Log::warning("Style file tidak ditemukan untuk {$language}: {$file}");
            return "Gunakan {$language} sehari-hari yang alami.";
        }

        return file_get_contents($path);
    }

    private function buildPrompt(
        string $language,
        int $count,
        string $recentQuestions,
        string $styleInstruction = ''
    ): string {

        $prompt = $this->loadPrompt('question_prompt.txt');

        return str_replace(
            ['{{language}}', '{{count}}', '{{recent_questions}}', '{{style_instruction}}'],
            [$language, $count, $recentQuestions, $styleInstruction],
            $prompt
        );
    }

    

    public function generate(
        string $language,
        int $count
    ): array {

        $start = microtime(true);

        Log::info("Generate start");

        $systemPrompt = $this->loadPrompt('system_prompt.txt');

        Log::info("System prompt loaded", [
            'ms' => round((microtime(true) - $start) * 1000)
        ]);

       $styleInstruction = $this->loadStyleInstruction($language);

        $recentQuestions = Question::where('language', $language)
            ->latest()
            ->limit(20)
            ->pluck('question')
            ->implode("\n- ");

        Log::info("Recent loaded", [
            'ms' => round((microtime(true) - $start) * 1000)
        ]);

        $userPrompt = $this->buildPrompt(
            $language,
            $count,
            $recentQuestions,
            $styleInstruction
        );

        Log::info("Prompt built", [
            'ms' => round((microtime(true) - $start) * 1000),
            'length' => strlen($userPrompt),
        ]);

        Log::info('System length', [
            'len' => strlen($systemPrompt),
        ]);

        Log::info('User length', [
            'len' => strlen($userPrompt),
        ]);

        $response = $this->openAI->chat(
            $systemPrompt,
            $userPrompt
        );

        Log::info("OpenAI returned", [
            'ms' => round((microtime(true) - $start) * 1000)
        ]);

        $this->validateResponse($response);

        return $this->saveQuestions(
            $language,
            $response['questions']
        );
    }

    private function validateResponse(array $response): void
    {
        if (!isset($response['questions'])) {
            throw new \Exception('AI response invalid.');
        }
    }

    private function shuffleAnswers(
        string $correct,
        array $wrongAnswers
    ): array {
        $options = array_merge([$correct], $wrongAnswers);

        shuffle($options);

        return [
            'options' => $options,
            'correct_option' => array_search($correct, $options),
        ];
    }

    private function saveQuestions(
        string $language,
        array $questions
    ): array {

        $savedQuestions = [];

        foreach ($questions as $question) {

            $this->validateQuestion($question);

            $shuffle = $this->shuffleAnswers(
                $question['correct_answer'],
                $question['wrong_answers']
            );

            if (
                Question::where('language', $language)
                ->where('question', $question['question'])
                ->exists()
            ) {
                continue;
            }

            $saved = Question::create([
                'language' => $language,
                'question' => $question['question'],
                'options' => $shuffle['options'],
                'correct_option' => $shuffle['correct_option'],
                'keywords' => $question['keywords'],
                'usage_count' => 0,
            ]);

            $savedQuestions[] = $saved;
        }

        return $savedQuestions;
    }

    private function validateQuestion(array $question): void
    {
        $required = [
            'question',
            'correct_answer',
            'wrong_answers',
            'keywords',
        ];

        foreach ($required as $field) {
            if (!array_key_exists($field, $question)) {
                throw new \Exception("Field {$field} tidak ditemukan.");
            }
        }

        if (!is_array($question['wrong_answers'])) {
            throw new \Exception('wrong_answers harus array.');
        }

        if (count($question['wrong_answers']) !== 3) {
            throw new \Exception('wrong_answers harus berisi tepat 3 jawaban.');
        }

        $answers = array_merge(
            [$question['correct_answer']],
            $question['wrong_answers']
        );

        if (count($answers) !== count(array_unique($answers))) {
            throw new \Exception('Terdapat jawaban yang sama.');
        }

        $requiredKeywords = [
            'subject',
            'verb',
            'object',
            'place',
            'time',
        ];

        foreach ($requiredKeywords as $key) {
            if (!array_key_exists($key, $question['keywords'])) {
                throw new \Exception("Keyword {$key} tidak ditemukan.");
            }
        }
    }
}

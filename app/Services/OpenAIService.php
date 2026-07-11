<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    public function chat(
        string $systemPrompt,
        string $userPrompt
    ): array {

        Log::info("=== OPENAI BEGIN ===");

        $start = microtime(true);

        $response = OpenAI::responses()->create([
            'model' => 'gpt-5-mini',
            'input' => [
                [
                    'role'    => 'system',
                    'content' => [
                        [
                            'type' => 'input_text',
                            'text' => $systemPrompt . "\n\nAlways respond with valid JSON.",
                        ]
                    ],
                ],
                [
                    'role'    => 'user',
                    'content' => [
                        [
                            'type' => 'input_text',
                            'text' => $userPrompt,
                        ]
                    ],
                ],
            ],
            'text' => [
                'format' => [
                    'type' => 'json_object'
                ]
            ]

        ]);

        Log::info("=== OPENAI FINISH ===", [
            'ms' => (microtime(true) - $start) * 1000
        ]);
        Log::info("Prompt size", [
            'system' => strlen($systemPrompt),
            'user' => strlen($userPrompt),
        ]);
        Log::info("=== PARSING RESPONSE ===");

        $content = null;

        foreach ($response->output as $block) {
            if ($block->type === 'message') {
                foreach ($block->content as $contentBlock) {
                    if ($contentBlock->type === 'output_text') {
                        $content = $contentBlock->text;
                        break 2;
                    }
                }
            }
        }

        if (!$content) {
            throw new \Exception('AI response tidak mengandung teks.');
        }

        $decoded = json_decode(trim($content), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('AI response bukan JSON valid: ' . $content);
        }

        return $decoded;
    }
}

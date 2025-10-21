<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->baseUrl = env('OPENAI_API_URL', 'https://api.openai.com/v1');
        $this->model = env('OPENAI_MODEL', 'gpt-4o-mini');
    }

    /**
     * Send a text prompt to OpenAI and return the response
     */
    public function ask(string $prompt)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->post("{$this->baseUrl}/chat/completions", [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ]);

            if ($response->failed()) {
                Log::error('OpenAI API Error', $response->json());
                return 'Sorry, there was an error contacting the AI service.';
            }

            $data = $response->json();
            return $data['choices'][0]['message']['content'] ?? 'No response received.';
        } catch (\Exception $e) {
            Log::error('OpenAIService Exception: ' . $e->getMessage());
            return 'An error occurred while processing your request.';
        }
    }
}

<?php

namespace App\Services\AI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected Client $client;
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model');
        $this->baseUrl = config('services.gemini.base_url');
        
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false, // Pour éviter les problèmes SSL en dev
        ]);
    }

    /**
     * Générer du contenu avec Gemini
     *
     * @param string $prompt Le prompt à envoyer
     * @param array $options Options supplémentaires
     * @return array|null La réponse de l'API
     */
    public function generateContent(string $prompt, array $options = []): ?array
    {
        try {
            $url = "{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}";

            $requestBody = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => array_merge([
                    'temperature' => 0.3, // Plus bas = plus déterministe
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ], $options['generationConfig'] ?? []),
            ];

            $response = $this->client->post($url, [
                'json' => $requestBody,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                return [
                    'success' => true,
                    'text' => $body['candidates'][0]['content']['parts'][0]['text'],
                    'raw_response' => $body,
                ];
            }

            Log::warning('Gemini API: Unexpected response format', ['response' => $body]);
            return null;

        } catch (GuzzleException $e) {
            Log::error('Gemini API Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Unexpected error in Gemini service: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Analyser le contenu de manière structurée
     *
     * @param string $prompt
     * @return array|null
     */
    public function analyzeStructured(string $prompt): ?array
    {
        $response = $this->generateContent($prompt);
        
        if (!$response || !$response['success']) {
            return null;
        }

        return $this->parseStructuredResponse($response['text']);
    }

    /**
     * Parser une réponse JSON depuis le texte de Gemini
     *
     * @param string $text
     * @return array|null
     */
    protected function parseStructuredResponse(string $text): ?array
    {
        // Gemini peut retourner du JSON entouré de markdown
        // Ex: ```json\n{...}\n```
        
        // Essayer d'extraire le JSON des code blocks markdown
        if (preg_match('/```(?:json)?\s*(\{.*?\})\s*```/s', $text, $matches)) {
            $jsonText = $matches[1];
        } else {
            // Sinon, chercher directement le JSON
            if (preg_match('/\{.*\}/s', $text, $matches)) {
                $jsonText = $matches[0];
            } else {
                $jsonText = $text;
            }
        }

        try {
            $decoded = json_decode($jsonText, true, 512, JSON_THROW_ON_ERROR);
            return $decoded;
        } catch (\JsonException $e) {
            Log::warning('Failed to parse Gemini response as JSON', [
                'text' => $text,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Vérifier si le service est configuré
     *
     * @return bool
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && !empty($this->model);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http; // Add this line for HTTP client
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AiSummaryController extends Controller
{
    public function getSummary($bookId)
    {
        $book = Book::find($bookId);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $prompt = "Réponds exclusivement en français. Fournis un résumé professionnel du livre intitulé '{$book->title}' par {$book->author}. Le résumé doit être concis et mettre en avant l'intrigue principale et les thèmes majeurs. Ajoute ensuite une section séparée avec des encouragements convaincants à l'achat, en insistant sur ses aspects uniques et les bénéfices pour le lecteur. Le résultat doit être un objet JSON avec deux clés: 'summary' pour le résumé du livre et 'encouragement' pour les encouragements à l'achat.";
        $systemMessage = "Tu es un assistant qui répond exclusivement en français et renvoie strictement un JSON valide, sans texte additionnel ni balises de code. Le JSON doit contenir uniquement les clés 'summary' et 'encouragement'.";

        $maxAttempts = 3;
        $delayMs = 600; // petite temporisation entre tentatives
        $result = null;
        $lastResponseBody = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                    'HTTP-Referer' => env('APP_URL'),
                    'X-Title' => env('APP_NAME'),
                ])->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'mistralai/mistral-small-3.1-24b-instruct',
                    'temperature' => 0.2,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemMessage],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                ]);

                $response->throw();

                $aiResponseContent = $response->json()['choices'][0]['message']['content'] ?? '{}';
                $lastResponseBody = $aiResponseContent;
                Log::info("AI attempt {$attempt} content: " . $aiResponseContent);

                // Parsing robuste
                $parsedResponse = null;
                // 1) bloc ```json
                preg_match('/```json\n([\s\S]*?)\n```/', $aiResponseContent, $mJson);
                $jsonString = $mJson[1] ?? null;
                if ($jsonString) {
                    $parsedResponse = json_decode($jsonString, true);
                }
                // 2) bloc ``` ... ```
                if (!$parsedResponse) {
                    preg_match('/```\s*([\s\S]*?)```/', $aiResponseContent, $mAny);
                    $anyString = $mAny[1] ?? null;
                    if ($anyString) {
                        $parsedResponse = json_decode($anyString, true);
                    }
                }
                // 3) JSON direct
                if (!$parsedResponse) {
                    $parsedResponse = json_decode($aiResponseContent, true);
                }
                // 4) extraction par accolades
                if (!$parsedResponse) {
                    $start = strpos($aiResponseContent, '{');
                    $end = strrpos($aiResponseContent, '}');
                    if ($start !== false && $end !== false && $end > $start) {
                        $candidate = substr($aiResponseContent, $start, $end - $start + 1);
                        $parsedResponse = json_decode($candidate, true);
                    }
                }
                if (!is_array($parsedResponse)) {
                    $parsedResponse = [];
                }

                $summary = $parsedResponse['summary'] ?? null;
                $encouragement = $parsedResponse['encouragement'] ?? null;

                $hasSummary = is_string($summary) ? trim($summary) !== '' : (is_array($summary) ? count($summary) > 0 : (is_object($summary) ? count((array)$summary) > 0 : false));
                $hasEncouragement = is_string($encouragement) ? trim($encouragement) !== '' : (is_array($encouragement) ? count($encouragement) > 0 : (is_object($encouragement) ? count((array)$encouragement) > 0 : false));

                if ($hasSummary && $hasEncouragement) {
                    $result = ['summary' => $summary, 'encouragement' => $encouragement];
                    // Mettre en cache la réponse valide
                    Cache::put('ai_summary_' . $bookId, $result, Carbon::now()->addHours(12));
                    break;
                }

            } catch (\Exception $e) {
                Log::warning("AI attempt {$attempt} failed for book {$bookId}: " . $e->getMessage());
                $lastResponseBody = isset($response) && method_exists($response, 'body') ? $response->body() : $lastResponseBody;
            }

            // temporisation avant la prochaine tentative
            usleep($delayMs * 1000);
        }

        if ($result) {
            return response()->json($result);
        }

        // Si échec: essayer le cache existant
        $cached = Cache::get('ai_summary_' . $bookId);
        if ($cached && isset($cached['summary']) && isset($cached['encouragement'])) {
            return response()->json($cached);
        }

        // Dernier recours: contenu de secours en français (jamais vide)
        $fallbackSummary = "Découvrez '{$book->title}' de {$book->author}. Le résumé intelligent est momentanément indisponible. Revenez plus tard pour un aperçu détaillé, ou parcourez les informations ci-dessous.";
        $fallbackEncouragement = [
            'message' => "Ajoutez ce livre à votre bibliothèque et laissez-vous inspirer par son univers unique.",
            'bullets' => [
                "Auteur: {$book->author}",
                "Titre: {$book->title}",
                "Parfait pour les lecteurs en quête de nouvelles découvertes",
            ],
            'call_to_action' => "Procédez à l'achat pour commencer votre lecture dès aujourd'hui.",
        ];

        return response()->json(['summary' => $fallbackSummary, 'encouragement' => $fallbackEncouragement]);
    }
}
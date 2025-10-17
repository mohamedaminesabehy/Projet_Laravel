<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.api_key');
        $this->model = config('services.openrouter.model');
        $this->baseUrl = config('services.openrouter.base_url');
    }

    /**
     * Génère un contenu persuasif d'encouragement à l'achat pour un livre
     */
    public function generatePurchaseEncouragement($book): array
    {
        try {
            $prompt = $this->buildPrompt($book);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un expert en marketing et persuasion pour la vente de livres. Tu dois créer du contenu persuasif et engageant pour encourager l\'achat d\'un livre spécifique.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 800,
                'temperature' => 0.7,
                'top_p' => 0.9,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                return $this->parseAIResponse($content);
            }

            Log::error('OpenRouter API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return $this->getFallbackContent($book);

        } catch (\Exception $e) {
            Log::error('OpenRouter Service Exception', [
                'message' => $e->getMessage(),
                'book_id' => $book->id ?? null
            ]);

            return $this->getFallbackContent($book);
        }
    }

    /**
     * Construit le prompt pour l'IA
     */
    private function buildPrompt($book): string
    {
        return "Crée un contenu persuasif d'encouragement à l'achat pour ce livre :

**Titre :** {$book->title}
**Auteur :** {$book->author}
**Prix :** {$book->price}€
**Catégorie :** {$book->category->name}
**Description :** {$book->description}

Génère une réponse au format JSON avec ces éléments :
{
    \"headline\": \"Un titre accrocheur et persuasif (max 60 caractères)\",
    \"persuasive_text\": \"Un texte persuasif de 2-6 phrases qui met en avant les bénéfices du livre avec des statistiques réalistes et convaincantes\",
    \"urgency_message\": \"Un message créant un sentiment d'urgence avec des données spécifiques (ex: 'Seulement 15 exemplaires restants', 'Promotion limitée à 48h')\",
    \"social_proof\": \"Une statistique crédible sur la popularité ou les ventes (ex: '95% des lecteurs recommandent', 'Plus de 10,000 exemplaires vendus')\",
    \"call_to_action\": \"Un appel à l'action puissant et direct\",
    \"benefits\": [\"4 bénéfices clés du livre sous forme de liste\"],
    \"sales_stats\": \"Statistique de vente réaliste (ex: 'Bestseller dans sa catégorie', '2,500+ exemplaires vendus ce mois')\",
    \"reader_satisfaction\": \"Taux de satisfaction des lecteurs (ex: '4.8/5 étoiles', '92% de satisfaction')\",
    \"time_savings\": \"Gain de temps ou valeur apportée (ex: 'Économisez 20h de recherche', 'Maîtrisez en 3 semaines')\",
    \"expert_endorsement\": \"Recommandation d'expert fictive mais crédible (ex: 'Recommandé par les professionnels du secteur')\",
    \"similar_books\": [
        {
            \"title\": \"Titre du livre similaire 1\",
            \"author\": \"Auteur du livre similaire 1\",
            \"reason\": \"Raison de la recommandation (genre, thème, style similaire)\"
        },
        {
            \"title\": \"Titre du livre similaire 2\",
            \"author\": \"Auteur du livre similaire 2\",
            \"reason\": \"Raison de la recommandation (genre, thème, style similaire)\"
        },
        {
            \"title\": \"Titre du livre similaire 3\",
            \"author\": \"Auteur du livre similaire 3\",
            \"reason\": \"Raison de la recommandation (genre, thème, style similaire)\"
        }
    ]
}

IMPORTANT pour les recommandations de livres similaires :
- Analyse le genre, le thème et le style d'écriture du livre actuel
- Propose 3 titres de livres similaires réalistes et pertinents
- Chaque recommandation doit avoir un titre, un auteur et une raison claire
- Les raisons doivent être basées sur des critères comme : même genre, thématique similaire, style d'écriture comparable, public cible identique
- Évite les titres trop génériques, sois spécifique et crédible
- Assure-toi que les recommandations sont cohérentes avec la catégorie et le contenu du livre

Le contenu doit être en français, professionnel mais engageant, et adapté au livre spécifique. Utilise des statistiques réalistes et convaincantes, évite les chiffres exagérés.";
    }

    /**
     * Parse la réponse de l'IA et extrait le JSON
     */
    private function parseAIResponse(string $content): array
    {
        // Tenter d'extraire le JSON de la réponse
        $jsonStart = strpos($content, '{');
        $jsonEnd = strrpos($content, '}');
        
        if ($jsonStart !== false && $jsonEnd !== false) {
            $jsonString = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
            $decoded = json_decode($jsonString, true);
            
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $this->validateAndCleanResponse($decoded);
            }
        }

        // Si l'extraction JSON échoue, créer une structure basique
        return [
            'headline' => 'Découvrez ce livre exceptionnel !',
            'persuasive_text' => $content,
            'urgency_message' => 'Offre limitée - Achetez maintenant !',
            'social_proof' => '95% des lecteurs recommandent ce livre',
            'call_to_action' => 'Ajoutez au panier maintenant',
            'benefits' => ['Contenu de qualité', 'Lecture enrichissante', 'Excellent rapport qualité-prix'],
            'sales_stats' => 'Bestseller dans sa catégorie',
            'reader_satisfaction' => '4.7/5 étoiles',
            'time_savings' => 'Maîtrisez le sujet en quelques heures',
            'expert_endorsement' => 'Recommandé par les experts',
            'similar_books' => [
                [
                    'title' => 'Livre similaire recommandé',
                    'author' => 'Auteur reconnu',
                    'reason' => 'Même thématique et style d\'écriture'
                ]
            ]
        ];
    }

    /**
     * Valide et nettoie la réponse de l'IA
     */
    private function validateAndCleanResponse(array $response): array
    {
        $defaults = [
            'headline' => 'Découvrez ce livre exceptionnel !',
            'persuasive_text' => 'Un livre qui transformera votre perspective et enrichira vos connaissances.',
            'urgency_message' => 'Stock limité - Commandez dès maintenant !',
            'social_proof' => '9 lecteurs sur 10 recommandent ce livre',
            'call_to_action' => 'Ajoutez au panier',
            'benefits' => ['Contenu de qualité', 'Lecture enrichissante', 'Excellent rapport qualité-prix'],
            'sales_stats' => 'Bestseller dans sa catégorie',
            'reader_satisfaction' => '4.6/5 étoiles',
            'time_savings' => 'Apprenez efficacement en quelques heures',
            'expert_endorsement' => 'Recommandé par les professionnels',
            'similar_books' => [
                [
                    'title' => 'Livre recommandé similaire',
                    'author' => 'Auteur de référence',
                    'reason' => 'Thématique et approche similaires'
                ]
            ]
        ];

        foreach ($defaults as $key => $default) {
            if (!isset($response[$key]) || empty($response[$key])) {
                $response[$key] = $default;
            }
        }

        // Limiter la longueur du headline
        if (strlen($response['headline']) > 60) {
            $response['headline'] = substr($response['headline'], 0, 57) . '...';
        }

        // S'assurer que benefits est un array
        if (!is_array($response['benefits'])) {
            $response['benefits'] = $defaults['benefits'];
        }

        // S'assurer que similar_books est un array avec la bonne structure
        if (!isset($response['similar_books']) || !is_array($response['similar_books'])) {
            $response['similar_books'] = $defaults['similar_books'];
        } else {
            // Valider chaque livre recommandé
            $validatedBooks = [];
            foreach ($response['similar_books'] as $book) {
                if (is_array($book) && isset($book['title']) && isset($book['author']) && isset($book['reason'])) {
                    $validatedBooks[] = [
                        'title' => $book['title'],
                        'author' => $book['author'],
                        'reason' => $book['reason']
                    ];
                }
            }
            
            // Si aucun livre valide, utiliser les defaults
            if (empty($validatedBooks)) {
                $response['similar_books'] = $defaults['similar_books'];
            } else {
                $response['similar_books'] = array_slice($validatedBooks, 0, 3); // Limiter à 3 recommandations
            }
        }

        return $response;
    }

    /**
     * Contenu de fallback en cas d'erreur
     */
    private function getFallbackContent($book): array
    {
        return [
            'headline' => "Découvrez \"{$book->title}\" !",
            'persuasive_text' => "Un livre captivant de {$book->author} qui vous transportera dans un univers unique. Une lecture incontournable pour tous les passionnés de {$book->category->name}.",
            'urgency_message' => 'Offre spéciale - Stock limité !',
            'social_proof' => 'Déjà plus de 1000 exemplaires vendus',
            'call_to_action' => 'Commandez maintenant',
            'benefits' => [
                'Contenu de qualité exceptionnelle',
                'Auteur reconnu et apprécié',
                'Prix attractif pour un livre de cette qualité',
                'Lecture enrichissante garantie'
            ],
            'sales_stats' => 'Top 10 des ventes dans la catégorie ' . $book->category->name,
            'reader_satisfaction' => '4.5/5 étoiles - 89% de satisfaction',
            'time_savings' => 'Maîtrisez les concepts clés en quelques heures de lecture',
            'expert_endorsement' => 'Recommandé par les spécialistes de ' . $book->category->name,
            'similar_books' => [
                [
                    'title' => 'Les Fondamentaux de ' . $book->category->name,
                    'author' => 'Expert du domaine',
                    'reason' => 'Même catégorie et approche complémentaire'
                ],
                [
                    'title' => 'Guide Avancé : ' . $book->category->name,
                    'author' => 'Spécialiste reconnu',
                    'reason' => 'Approfondissement du même sujet'
                ],
                [
                    'title' => 'Pratique et Théorie en ' . $book->category->name,
                    'author' => 'Auteur de référence',
                    'reason' => 'Style d\'écriture et thématique similaires'
                ]
            ]
        ];
    }
}
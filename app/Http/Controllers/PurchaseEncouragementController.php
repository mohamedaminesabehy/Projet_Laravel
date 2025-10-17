<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\AI\OpenRouterService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PurchaseEncouragementController extends Controller
{
    protected $openRouterService;

    public function __construct(OpenRouterService $openRouterService)
    {
        $this->openRouterService = $openRouterService;
    }

    /**
     * Génère du contenu d'encouragement à l'achat pour un livre spécifique
     */
    public function generateEncouragement(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'book_id' => 'required|integer|exists:books,id'
            ]);

            $book = Book::with('category')->findOrFail($request->book_id);
            
            $encouragementContent = $this->openRouterService->generatePurchaseEncouragement($book);

            return response()->json([
                'success' => true,
                'data' => $encouragementContent
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Livre non trouvé'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Purchase Encouragement Error', [
                'message' => $e->getMessage(),
                'book_id' => $request->book_id ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la génération du contenu'
            ], 500);
        }
    }
}
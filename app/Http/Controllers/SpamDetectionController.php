<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Services\SpamDetectionService;

class SpamDetectionController extends Controller
{
    protected $spamDetectionService;

    public function __construct(SpamDetectionService $spamDetectionService)
    {
        $this->spamDetectionService = $spamDetectionService;
    }

    /**
     * Afficher le dashboard de détection spam (Admin)
     */
    public function dashboard()
    {
        // Récupérer tous les messages bloqués
        $blockedMessages = Message::where('is_blocked', true)
            ->with('sender', 'receiver')
            ->orderBy('blocked_at', 'desc')
            ->paginate(15);

        // Statistiques globales
        $stats = $this->spamDetectionService->getSpamStats();

        // Statistiques par jour (7 derniers jours)
        $dailyStats = Message::where('is_blocked', true)
            ->where('blocked_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(blocked_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.spam-detection.dashboard', compact('blockedMessages', 'stats', 'dailyStats'));
    }

    /**
     * Analyser un message avec l'IA (appelé avant envoi)
     */
    public function analyzeMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:1',
        ]);

        $analysis = $this->spamDetectionService->analyzeMessage($request->message);

        return response()->json($analysis);
    }

    /**
     * Débloquer un message (Admin)
     */
    public function unblockMessage($id)
    {
        $message = Message::findOrFail($id);
        
        $message->update([
            'is_blocked' => false,
            'blocked_at' => null,
            'spam_score' => 0,
            'spam_reasons' => null,
        ]);

        return redirect()->back()->with('success', 'Message débloqué avec succès');
    }

    /**
     * Supprimer définitivement un message spam (Admin)
     */
    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Message supprimé définitivement');
    }
}

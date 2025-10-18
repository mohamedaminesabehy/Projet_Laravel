<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Services\TrustScoreAutoUpdateService;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $trustScoreAutoUpdate;
    protected $spamDetectionService;

    public function __construct(
        TrustScoreAutoUpdateService $trustScoreAutoUpdate,
        SpamDetectionService $spamDetectionService
    ) {
        $this->trustScoreAutoUpdate = $trustScoreAutoUpdate;
        $this->spamDetectionService = $spamDetectionService;
    }
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        // Exclure les messages bloqués de l'affichage normal
        $messages = Message::with(['sender', 'receiver'])
            ->where('is_blocked', false)
            ->where(function($q) {
                $q->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('date_envoi', 'asc')
            ->get();

        return view('pages.messages', compact('messages', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'contenu' => 'required|string',
            'message_id' => 'nullable|exists:messages,id'
        ]);

        if ($request->message_id) {
            $message = Message::findOrFail($request->message_id);
            
            // Vérifier que l'utilisateur est bien l'expéditeur
            if ($message->sender_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Action non autorisée.');
            }
            
            $message->update([
                'contenu' => $request->contenu,
            ]);
            return redirect()->back()->with('success', 'Message mis à jour avec succès !');
        } else {
            // 🤖 DÉTECTION SPAM PAR IA - Analyser le message avant envoi
            $spamAnalysis = $this->spamDetectionService->analyzeMessage($request->contenu);
            
            // Si spam détecté (score >= 70%), ENREGISTRER comme bloqué
            if ($spamAnalysis['is_spam']) {
                // Enregistrer le message spam dans la BDD pour traçabilité admin
                Message::create([
                    'sender_id' => Auth::id(),
                    'receiver_id' => $request->receiver_id,
                    'contenu' => $request->contenu,
                    'lu' => false,
                    'date_envoi' => now(),
                    'spam_score' => $spamAnalysis['spam_score'],
                    'spam_reasons' => json_encode($spamAnalysis['reasons']),
                    'is_blocked' => true,
                    'blocked_at' => now(),
                ]);
                
                // Notification à l'utilisateur
                return redirect()->back()->with('error', 
                    '⚠️ Votre message a été bloqué par notre système de détection IA. ' .
                    'Score de spam : ' . $spamAnalysis['spam_score'] . '%. ' .
                    'Un administrateur sera notifié. Raisons : ' . implode(', ', array_slice($spamAnalysis['reasons'], 0, 2))
                );
            }
            
            // Message OK, enregistrer normalement avec le score spam
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'contenu' => $request->contenu,
                'lu' => false,
                'date_envoi' => now(),
                'spam_score' => $spamAnalysis['spam_score'],
                'spam_reasons' => json_encode($spamAnalysis['reasons']),
                'is_blocked' => false,
                'blocked_at' => null,
            ]);
            
            // 🔥 AUTO-UPDATE: Mettre à jour le score de confiance après envoi de message
            $this->trustScoreAutoUpdate->handleMessageSent(Auth::user());
            
            return redirect()->back()->with('success', 'Message envoyé avec succès !');
        }
    }

    public function update(Request $request, Message $message)
    {
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Action non autorisée.'], 403);
        }

        $request->validate([
            'contenu' => 'required|string'
        ]);

        $message->update([
            'contenu' => $request->contenu,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message mis à jour avec succès !',
            'data' => $message
        ]);
    }

    public function destroy(Message $message)
    {
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Action non autorisée.'], 403);
        }
        $message->delete();
        return response()->json(['success' => true, 'message' => 'Message supprimé avec succès !']);
    }
}
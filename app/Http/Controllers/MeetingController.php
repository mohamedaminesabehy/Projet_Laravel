<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Message;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    /**
     * Afficher la liste des rendez-vous de l'utilisateur connecté
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status', 'all');
        
        $query = Meeting::with(['user1', 'user2', 'book1', 'book2', 'proposedBy'])
            ->forUser($user->id);
        
        // Filtrer par statut si nécessaire
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $meetings = $query->orderBy('meeting_date', 'desc')
            ->orderBy('meeting_time', 'desc')
            ->paginate(10);

        return view('pages.meetings.index', compact('meetings'));
    }

    /**
     * Afficher les détails d'un rendez-vous
     */
    public function show($id)
    {
        $meeting = Meeting::with(['user1', 'user2', 'book1', 'book2', 'proposedBy', 'message'])
            ->findOrFail($id);

        // Vérifier que l'utilisateur fait partie du rendez-vous
        if (!$meeting->involvesUser(Auth::id())) {
            abort(403, 'Vous n\'avez pas accès à ce rendez-vous.');
        }

        return view('pages.meetings.show', compact('meeting'));
    }

    /**
     * Afficher le formulaire de création d'un rendez-vous
     */
    public function create(Request $request)
    {
        $messageId = $request->input('message_id');
        $message = Message::with(['sender', 'receiver'])->findOrFail($messageId);

        // Vérifier que l'utilisateur fait partie de la conversation
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Vous n\'avez pas accès à cette conversation.');
        }

        // Récupérer les livres des deux utilisateurs
        $myBooks = Book::where('user_id', Auth::id())->get();
        $otherUserId = $message->sender_id === Auth::id() ? $message->receiver_id : $message->sender_id;
        $otherUserBooks = Book::where('user_id', $otherUserId)->get();

        return view('pages.meetings.create', compact('message', 'myBooks', 'otherUserBooks'));
    }

    /**
     * Afficher le formulaire d'édition d'un rendez-vous
     */
    public function edit($id)
    {
        $meeting = Meeting::with(['user1', 'user2', 'book1', 'book2', 'message'])->findOrFail($id);

        // Vérifier que l'utilisateur fait partie du rendez-vous
        if (!$meeting->involvesUser(Auth::id())) {
            abort(403, 'Vous n\'avez pas accès à ce rendez-vous.');
        }

        // Vérifier que le rendez-vous peut être modifié (uniquement proposé ou confirmé)
        if (!in_array($meeting->status, ['proposed', 'confirmed'])) {
            return redirect()->route('meetings.show', $id)
                ->with('error', 'Ce rendez-vous ne peut plus être modifié.');
        }

        // Récupérer les livres des deux utilisateurs
        $myBooks = Book::where('user_id', Auth::id())->get();
        $otherUserId = $meeting->user1_id === Auth::id() ? $meeting->user2_id : $meeting->user1_id;
        $otherUserBooks = Book::where('user_id', $otherUserId)->get();

        return view('pages.meetings.edit', compact('meeting', 'myBooks', 'otherUserBooks'));
    }

    /**
     * Créer un nouveau rendez-vous
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message_id' => 'required|exists:messages,id',
            'user2_id' => 'required|exists:users,id',
            'book1_id' => 'nullable|exists:book,id',
            'book2_id' => 'nullable|exists:book,id',
            'meeting_date' => 'required|date|after_or_equal:today',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_place' => 'required|string|max:255',
            'meeting_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $meeting = Meeting::create([
            'message_id' => $validated['message_id'],
            'user1_id' => Auth::id(),
            'user2_id' => $validated['user2_id'],
            'book1_id' => $validated['book1_id'] ?? null,
            'book2_id' => $validated['book2_id'] ?? null,
            'meeting_date' => $validated['meeting_date'],
            'meeting_time' => $validated['meeting_time'],
            'meeting_place' => $validated['meeting_place'],
            'meeting_address' => $validated['meeting_address'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'proposed',
            'proposed_by' => Auth::id(),
            'proposed_at' => now(),
        ]);

        return redirect()->route('meetings.show', $meeting->id)
            ->with('success', 'Rendez-vous proposé avec succès !');
    }

    /**
     * Mettre à jour un rendez-vous existant
     */
    public function update(Request $request, $id)
    {
        $meeting = Meeting::findOrFail($id);

        // Vérifier que l'utilisateur fait partie du rendez-vous
        if (!$meeting->involvesUser(Auth::id())) {
            return redirect()->route('meetings.index')
                ->with('error', 'Accès non autorisé.');
        }

        // Vérifier que le rendez-vous peut être modifié
        if (!in_array($meeting->status, ['proposed', 'confirmed'])) {
            return redirect()->route('meetings.show', $id)
                ->with('error', 'Ce rendez-vous ne peut plus être modifié.');
        }

        $validated = $request->validate([
            'book1_id' => 'nullable|exists:book,id',
            'book2_id' => 'nullable|exists:book,id',
            'meeting_date' => 'required|date|after_or_equal:today',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_place' => 'required|string|max:255',
            'meeting_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $meeting->update([
            'book1_id' => $validated['book1_id'] ?? null,
            'book2_id' => $validated['book2_id'] ?? null,
            'meeting_date' => $validated['meeting_date'],
            'meeting_time' => $validated['meeting_time'],
            'meeting_place' => $validated['meeting_place'],
            'meeting_address' => $validated['meeting_address'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('meetings.show', $meeting->id)
            ->with('success', 'Rendez-vous modifié avec succès !');
    }

    /**
     * Confirmer un rendez-vous (AJAX)
     */
    public function confirm($id)
    {
        $meeting = Meeting::findOrFail($id);

        // Vérifier que l'utilisateur fait partie du rendez-vous
        if (!$meeting->involvesUser(Auth::id())) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        // Vérifier que l'utilisateur n'est pas celui qui a proposé
        if ($meeting->proposed_by === Auth::id()) {
            return response()->json(['error' => 'Vous ne pouvez pas confirmer votre propre proposition.'], 403);
        }

        // Vérifier que le rendez-vous peut être confirmé
        if (!$meeting->canBeConfirmed()) {
            return response()->json(['error' => 'Ce rendez-vous ne peut pas être confirmé.'], 400);
        }

        $meeting->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous confirmé avec succès !',
            'meeting' => $meeting->fresh(),
        ]);
    }

    /**
     * Annuler un rendez-vous (AJAX)
     */
    public function cancel(Request $request, $id)
    {
        $meeting = Meeting::findOrFail($id);

        // Vérifier que l'utilisateur fait partie du rendez-vous
        if (!$meeting->involvesUser(Auth::id())) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        // Vérifier que le rendez-vous peut être annulé
        if (!$meeting->canBeCancelled()) {
            return response()->json(['error' => 'Ce rendez-vous ne peut pas être annulé.'], 400);
        }

        $validated = $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $meeting->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $validated['cancellation_reason'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous annulé.',
            'meeting' => $meeting->fresh(),
        ]);
    }

    /**
     * Marquer un rendez-vous comme terminé (AJAX)
     */
    public function complete($id)
    {
        $meeting = Meeting::findOrFail($id);

        // Vérifier que l'utilisateur fait partie du rendez-vous
        if (!$meeting->involvesUser(Auth::id())) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        // Vérifier que le rendez-vous peut être marqué comme terminé
        if (!$meeting->canBeCompleted()) {
            return response()->json([
                'error' => 'Ce rendez-vous ne peut pas être marqué comme terminé. Statut actuel : ' . $meeting->status,
                'status' => $meeting->status
            ], 400);
        }

        $meeting->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous marqué comme terminé !',
            'meeting' => $meeting->fresh(),
        ]);
    }

    /**
     * Supprimer un rendez-vous (uniquement si proposé et par celui qui l'a proposé)
     */
    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);

        // Seul celui qui a proposé peut supprimer, et seulement si le statut est "proposed"
        if ($meeting->proposed_by !== Auth::id() || $meeting->status !== 'proposed') {
            return response()->json(['error' => 'Vous ne pouvez pas supprimer ce rendez-vous.'], 403);
        }

        $meeting->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous supprimé.',
        ]);
    }
}

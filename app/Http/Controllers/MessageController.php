<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        $messages = Message::with(['sender', 'receiver'])
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
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'contenu' => $request->contenu,
                'lu' => false,
                'date_envoi' => now(),
            ]);
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
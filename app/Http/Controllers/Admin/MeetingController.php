<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Services\TrustScoreAutoUpdateService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    protected $trustScoreAutoUpdate;

    public function __construct(TrustScoreAutoUpdateService $trustScoreAutoUpdate)
    {
        $this->trustScoreAutoUpdate = $trustScoreAutoUpdate;
    }
    /**
     * Afficher la liste de tous les rendez-vous (Admin)
     */
    public function index(Request $request)
    {
        $query = Meeting::with(['user1', 'user2', 'book1', 'book2', 'proposedBy']);

        // Filtrer par statut si spécifié
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrer par date
        if ($request->filled('date_from')) {
            $query->where('meeting_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('meeting_date', '<=', $request->date_to);
        }

        // Recherche par nom d'utilisateur
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user1', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('user2', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $meetings = $query->orderBy('meeting_date', 'desc')
                         ->orderBy('meeting_time', 'desc')
                         ->paginate(15);

        // Statistiques pour le dashboard
        $stats = [
            'total' => Meeting::count(),
            'proposed' => Meeting::where('status', 'proposed')->count(),
            'confirmed' => Meeting::where('status', 'confirmed')->count(),
            'completed' => Meeting::where('status', 'completed')->count(),
            'cancelled' => Meeting::where('status', 'cancelled')->count(),
            'upcoming' => Meeting::upcoming()->count(),
        ];

        return view('admin.meetings.meetings-list', compact('meetings', 'stats'));
    }

    /**
     * Afficher les détails d'un rendez-vous (Admin)
     */
    public function show($id)
    {
        $meeting = Meeting::with([
            'user1', 
            'user2', 
            'book1', 
            'book2', 
            'proposedBy', 
            'message.sender', 
            'message.receiver'
        ])->findOrFail($id);

        return view('admin.meetings.meeting-details', compact('meeting'));
    }

    /**
     * Annuler un rendez-vous (Admin) - AJAX
     */
    public function cancel(Request $request, $id)
    {
        $meeting = Meeting::findOrFail($id);

        if (!$meeting->canBeCancelled()) {
            return response()->json(['error' => 'Ce rendez-vous ne peut pas être annulé.'], 400);
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $meeting->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => 'Admin: ' . $validated['cancellation_reason'],
        ]);

        // 🔥 AUTO-UPDATE: Mettre à jour les scores après annulation par admin
        $this->trustScoreAutoUpdate->handleMeetingCancelled($meeting->user1, $meeting->user2);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous annulé par l\'administrateur.',
            'meeting' => $meeting->fresh(),
        ]);
    }

    /**
     * Supprimer un rendez-vous (Admin)
     */
    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);
        $meeting->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous supprimé.',
        ]);
    }

    /**
     * Tableau de bord des statistiques
     */
    public function dashboard()
    {
        $stats = [
            'total' => Meeting::count(),
            'proposed' => Meeting::proposed()->count(),
            'confirmed' => Meeting::confirmed()->count(),
            'completed' => Meeting::completed()->count(),
            'cancelled' => Meeting::cancelled()->count(),
            'upcoming' => Meeting::upcoming()->count(),
            'past' => Meeting::past()->count(),
        ];

        // Rendez-vous par mois (6 derniers mois)
        $monthlyMeetings = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyMeetings[] = [
                'month' => $date->format('M Y'),
                'count' => Meeting::whereYear('meeting_date', $date->year)
                                 ->whereMonth('meeting_date', $date->month)
                                 ->count(),
            ];
        }

        // Rendez-vous récents
        $recentMeetings = Meeting::with(['user1', 'user2', 'book1', 'book2'])
                                ->orderBy('created_at', 'desc')
                                ->limit(10)
                                ->get();

        // Rendez-vous à venir
        $upcomingMeetings = Meeting::with(['user1', 'user2'])
                                  ->upcoming()
                                  ->orderBy('meeting_date', 'asc')
                                  ->limit(10)
                                  ->get();

        return view('admin.meetings.meetings-dashboard', compact(
            'stats', 
            'monthlyMeetings', 
            'recentMeetings', 
            'upcomingMeetings'
        ));
    }

    /**
     * Exporter les rendez-vous en CSV
     */
    public function export(Request $request)
    {
        $query = Meeting::with(['user1', 'user2', 'book1', 'book2']);

        // Appliquer les mêmes filtres que dans index()
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->where('meeting_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('meeting_date', '<=', $request->date_to);
        }

        $meetings = $query->get();

        $filename = 'meetings_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($meetings) {
            $file = fopen('php://output', 'w');
            
            // En-têtes du CSV
            fputcsv($file, [
                'ID',
                'Date',
                'Heure',
                'Lieu',
                'Utilisateur 1',
                'Utilisateur 2',
                'Livre 1',
                'Livre 2',
                'Statut',
                'Proposé par',
                'Proposé le',
            ]);

            // Données
            foreach ($meetings as $meeting) {
                fputcsv($file, [
                    $meeting->id,
                    $meeting->meeting_date->format('d/m/Y'),
                    $meeting->meeting_time->format('H:i'),
                    $meeting->meeting_place,
                    $meeting->user1->name,
                    $meeting->user2->name,
                    $meeting->book1?->title ?? 'N/A',
                    $meeting->book2?->title ?? 'N/A',
                    $meeting->status_text,
                    $meeting->proposedBy->name,
                    $meeting->proposed_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Exporter les rendez-vous en PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Meeting::with(['user1', 'user2', 'book1', 'book2', 'proposedBy']);

        // Appliquer les mêmes filtres que dans index()
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->where('meeting_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('meeting_date', '<=', $request->date_to);
        }

        $meetings = $query->orderBy('meeting_date', 'desc')->get();

        // Statistiques
        $stats = [
            'total' => $meetings->count(),
            'proposed' => $meetings->where('status', 'proposed')->count(),
            'confirmed' => $meetings->where('status', 'confirmed')->count(),
            'completed' => $meetings->where('status', 'completed')->count(),
            'cancelled' => $meetings->where('status', 'cancelled')->count(),
        ];

        $pdf = \PDF::loadView('admin.meetings.pdf-export', compact('meetings', 'stats'));
        
        $filename = 'rendez-vous_' . now()->format('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }
}

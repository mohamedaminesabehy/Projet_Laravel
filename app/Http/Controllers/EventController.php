<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * List public events.
     */
    public function index(Request $request)
{
    $query = Event::query()
        ->where('is_active', 1)
        ->orderBy('start_date', 'desc');

    // Search filter
    if ($request->filled('search')) {
        $search = trim($request->input('search'));
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    // ✅ Load participants only for logged-in users
    if (Auth::check()) {
        $query->with(['participants' => function ($q) {
            $q->wherePivotNull('left_at')
              ->wherePivot('status', 'joined')
              ->select('users.id'); // load only user IDs
        }]);
    } else {
        // Not logged in → just load participant counts
        $query->withCount('participants');
    }

    $events = $query->paginate(9)->appends($request->query());

    return view('pages.events.index', compact('events'));
}


    /**
     * Show one event.
     */
    public function show(Event $event)
    {
        abort_unless($event->is_active, 404);

        if (Auth::check()) {
            $event->load(['participants' => function ($q) {
                $q->wherePivotNull('left_at')
                  ->wherePivot('status', 'joined')
                  ->select('users.id');
            }]);
        }

        return view('pages.events.show', compact('event'));
    }

    /**
     * Join an event.
     */
    public function join(Event $event)
    {
        if (! $event->is_active) {
            return back()->with('error', 'This event is no longer available.');
        }

        $user = Auth::user();
        if (! $user) {
            return redirect()->route('signin')->with('error', 'You must log in to join.');
        }

        Participation::updateOrCreate(
            ['event_id' => $event->id, 'user_id' => $user->id],
            ['joined_at' => now(), 'left_at' => null, 'status' => 'joined', 'source' => 'web']
        );

        return back()->with('success', 'You have successfully joined the event!');
    }


    /**
     * Leave an event.
     */
    public function leave(Event $event)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('signin')->with('error', 'You must log in first.');
        }

        $p = Participation::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->first();

        if (! $p) {
            return back()->with('error', 'You are not participating in this event.');
        }

        $p->update(['left_at' => now(), 'status' => 'left']);

        return back()->with('success', 'You have left the event.');
    }
}

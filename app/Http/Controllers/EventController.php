<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;



class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query()
            ->where('is_active', 1)
            ->orderBy('start_date', 'desc');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->paginate(9)->appends($request->query());

        return view('pages.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        abort_unless($event->is_active, 404);

        return view('pages.events.show', compact('event'));
    }


    public function join(Request $request, Event $event)
{
    // Only allow joining active events
    if (!$event->is_active) {
        return redirect()
            ->route('events.index')
            ->with('error', 'This event is no longer available.');
    }

    // Get the current user (use the Auth facade)
    $user = Auth::user();

    // Your login route is named 'signin' in this project
    if (!$user) {
        return redirect()
            ->route('signin')
            ->with('error', 'You must log in to join this event.');
    }

    // Persist the participation (requires event_user pivot + relation)
    $event->participants()->syncWithoutDetaching([$user->id]);

    return back()->with('success', 'You have successfully joined the event!');
}

}

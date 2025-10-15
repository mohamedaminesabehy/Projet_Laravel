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
        ->orderBy('start_date', 'desc')
        ->with('participants:id'); // <- important

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
    $event->load('participants:id'); // for the button check
    return view('pages.events.show', compact('event'));
}


    public function join(Event $event)
{
    if (!$event->is_active) {
        return redirect()->route('events.index')->with('error', 'This event is no longer available.');
    }

    $user = Auth::user();
    if (!$user) {
        return redirect()->route('signin')->with('error', 'You must log in to join this event.');
    }

    // attach if not already
    $event->participants()->syncWithoutDetaching([$user->id]);

    return back()->with('success', 'You have successfully joined the event!');
}

public function leave(Event $event)
{
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('signin')->with('error', 'You must log in first.');
    }

    $event->participants()->detach($user->id);

    return back()->with('success', 'You have left the event.');
}

}

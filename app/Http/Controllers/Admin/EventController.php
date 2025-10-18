<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
{
    $query = \App\Models\Event::query();

    // Search across title, description, location
    if ($request->filled('search')) {
        $search = trim($request->input('search', ''));
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    // Status filter (ignore "all")
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('is_active', $request->status === 'active' ? 1 : 0);
    }

    // Date range by start_date
    if ($request->filled('date_from')) {
        $query->whereDate('start_date', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('start_date', '<=', $request->date_to);
    }

    // With pagination; keep query params
    $events = $query
        ->orderBy('start_date', 'desc')
        ->paginate(10)
        ->appends($request->query());

    // Render the full page (no AJAX)
    return view('admin.events', compact('events'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->ajax()) {
            return view('admin.events_create')->render();
        }
        return view('admin.events_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'location'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        \App\Models\Event::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Événement créé avec succès.',
            ]);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Événement créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        if (request()->ajax()) {
            return response()->json(['event' => $event]);
        }
        return view('admin.events_show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        if (request()->ajax()) {
            return response()->json(['event' => $event]);
        }
        return view('admin.events_edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $event = Event::findOrFail($id);
        $data = $request->except('image');

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        $event->update($data);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Événement mis à jour avec succès.']);
        }

        return redirect()->route('admin.events.index')->with('success', 'Événement mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        // Supprimer l'image associée si elle existe
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Événement supprimé avec succès.']);
        }

        return redirect()->route('admin.events.index')->with('success', 'Événement supprimé avec succès');
    }

    public function participants(\App\Models\Event $event)
{
    $participants = $event->participants()
        ->select('users.id','users.first_name','users.last_name','users.email')
        ->orderBy('participations.joined_at','desc')
        ->get();

    if (request()->ajax()) {
        return view('admin.events._participants_modal', compact('event','participants'))->render();
    }

    // (optional) fallback full page:
    return view('admin.events.participants', compact('event','participants'));
}


public function downloadPdf(Event $event)
{
    $participants = $event->participants()
        ->select('users.*')
        ->withPivot(['joined_at','status','checked_in_at','left_at','source','notes'])
        ->orderBy('participations.joined_at', 'desc')
        ->get();

    // If you installed barryvdh/laravel-dompdf:
    // composer require barryvdh/laravel-dompdf
    // php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
    $pdf = \PDF::loadView('admin.events.participants-pdf', [
        'event'        => $event,
        'participants' => $participants,
    ])->setPaper('a4', 'portrait');

    return $pdf->download('participants-event-'.$event->id.'.pdf');
}


}

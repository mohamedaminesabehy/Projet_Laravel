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
    public function index(Request $request)
    {
        $query = Event::query();
        
        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        // Filtrage par statut
        if ($request->has('status') && $request->status != 'all') {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }
        
        // Filtrage par date
        if ($request->has('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->where('start_date', '<=', $request->date_to);
        }
        
        $events = $query->orderBy('start_date', 'desc')->paginate(10);
        
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        Event::create($data);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Événement créé avec succès.']);
        }

        return redirect()->route('admin.events.index')->with('success', 'Événement créé avec succès');
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
}

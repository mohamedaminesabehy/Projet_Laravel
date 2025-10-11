<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        $query = Category::with('user');
        
        // Recherche
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filtrage par statut
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        $validSorts = ['name', 'created_at', 'updated_at'];
        if (in_array($sortBy, $validSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $categories = $query->paginate(10)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $icons = $this->getAvailableIcons();
        $colors = $this->getAvailableColors();
        
        return view('admin.categories.create', compact('icons', 'colors'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:10',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/', // Seulement lettres et espaces
                Rule::unique('categories', 'name')
            ],
            'description' => 'nullable|string|max:255',
            'icon' => 'required|string|max:50',
            'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'is_active' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $category = Category::create($validated);

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        // Redirection vers l'index des catégories
        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        // Vérifier que l'utilisateur peut modifier cette catégorie
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas modifier cette catégorie.');
        }

        $icons = $this->getAvailableIcons();
        $colors = $this->getAvailableColors();

        return view('admin.categories.edit', compact('category', 'icons', 'colors'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Vérifier que l'utilisateur peut modifier cette catégorie
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas modifier cette catégorie.');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:10',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/',
                Rule::unique('categories', 'name')->ignore($category->id)
            ],
            'description' => 'nullable|string|max:255',
            'icon' => 'required|string|max:50',
            'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', $category->is_active);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        // Vérifier que l'utilisateur peut supprimer cette catégorie
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas supprimer cette catégorie.');
        }

        // Vérifier s'il y a des livres associés
        if ($category->books()->count() > 0) {
            return redirect()
                ->route('admin.categories.show', $category)
                ->with('error', 'Impossible de supprimer cette catégorie car elle contient des livres.');
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "La catégorie '{$categoryName}' a été supprimée avec succès !");
    }

    /**
     * Get category details for AJAX modal
     */
    public function getDetails(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        // Récupérer les statistiques
        $stats = [
            'books_count' => $category->books()->count(),
            'active_books_count' => $category->books()->where('is_available', true)->count(),
            'reviews_count' => 0, // À implémenter quand le système d'avis sera créé
            'latest_books' => $category->books()->latest()->take(5)->get(['id', 'title', 'author', 'cover_image', 'created_at'])
        ];

        $html = view('admin.categories.partials.details', compact('category', 'stats'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'category' => $category
        ]);
    }

    /**
     * Get category edit form for AJAX modal
     */
    public function getEditForm(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        $html = view('admin.categories.partials.edit-form', compact('category'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'category' => $category
        ]);
    }

    /**
     * Toggle the active status of a category.
     */
    public function toggleStatus(Category $category)
    {
        // Vérifier que l'utilisateur peut modifier cette catégorie
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas modifier cette catégorie.');
        }

        $category->update([
            'is_active' => !$category->is_active
        ]);

        $status = $category->is_active ? 'activée' : 'désactivée';
        
        return redirect()
            ->back()
            ->with('success', "La catégorie '{$category->name}' a été {$status} !");
    }

    /**
     * Get available icons for categories.
     */
    private function getAvailableIcons()
    {
        return [
            'fas fa-heart' => 'Cœur (Romance)',
            'fas fa-rocket' => 'Fusée (Science-Fiction)',
            'fas fa-mask' => 'Masque (Thriller)',
            'fas fa-dragon' => 'Dragon (Fantasy)',
            'fas fa-user-tie' => 'Personne (Biographie)',
            'fas fa-landmark' => 'Monument (Histoire)',
            'fas fa-child' => 'Enfant (Jeunesse)',
            'fas fa-brain' => 'Cerveau (Philosophie)',
            'fas fa-utensils' => 'Couverts (Cuisine)',
            'fas fa-globe' => 'Globe (Voyage)',
            'fas fa-book' => 'Livre (Général)',
            'fas fa-graduation-cap' => 'Diplôme (Éducation)',
            'fas fa-microscope' => 'Microscope (Science)',
            'fas fa-palette' => 'Palette (Art)',
            'fas fa-music' => 'Musique',
            'fas fa-camera' => 'Photographie',
            'fas fa-calculator' => 'Mathématiques',
            'fas fa-leaf' => 'Nature',
            'fas fa-dumbbell' => 'Sport',
            'fas fa-stethoscope' => 'Médecine',
        ];
    }

    /**
     * Get available colors for categories.
     */
    private function getAvailableColors()
    {
        return [
            '#FF5E84' => 'Rose',
            '#4E7CFF' => 'Bleu',
            '#9747FF' => 'Violet',
            '#00C48C' => 'Vert',
            '#FFC700' => 'Jaune',
            '#FF6B35' => 'Orange',
            '#FF9F1C' => 'Orange clair',
            '#2EC4B6' => 'Turquoise',
            '#E71D36' => 'Rouge',
            '#011627' => 'Noir',
            '#D16655' => 'Rouge corail',
            '#2E4A5B' => 'Bleu foncé',
            '#BD7579' => 'Rose poudré',
            '#F8EBE5' => 'Beige',
        ];
    }
}
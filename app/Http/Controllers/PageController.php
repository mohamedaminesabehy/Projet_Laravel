<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookInsight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function home()
    {
        // Récupérer les meilleurs livres avec insights AI (basé sur le nombre de reviews)
        $topBooksWithInsights = Book::with(['insight', 'reviews'])
            ->whereHas('insight') // Seulement les livres qui ont un insight
            ->withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->take(6)
            ->get();

        return view('pages.index', compact('topBooksWithInsights'));
    }

    public function show(string $page)
    {
        $viewName = 'pages.' . $page;
        if (View::exists($viewName)) {
            return view($viewName);
        }

        if ($page === '404') {
            return response()->view('pages.404', [], 404);
        }

        abort(404);
    }
} 
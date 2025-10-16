<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookInsight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
 

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function shop()
    {
        $books = Book::all();
        return view('pages.shop', compact('books'));
    }

    public function bookDetails($id)
    {
        $book = Book::findOrFail($id);
        return view('pages.shop-details', compact('book'));
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
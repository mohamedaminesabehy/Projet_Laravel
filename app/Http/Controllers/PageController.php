<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.index');
    }

    public function show(string $page)
    {
        $viewName = 'pages.' . $page;
        if (View::exists($viewName)) {
            if ($page === 'profile') {
                $user = Auth::user();
                return view($viewName, compact('user'));
            }
            return view($viewName);
        }

        if ($page === '404') {
            return response()->view('pages.404', [], 404);
        }

        abort(404);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Common admin methods or properties can be added here

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function authors()
    {
        return view('admin.author');
    }

    public function books()
    {
        return view('admin.books');
    }

    public function categories()
    {
        // Création d'un tableau de catégories de démonstration
        $categories = [
            [
                'id' => 1,
                'name' => 'Romance',
                'color' => '#FF5E84',
                'icon' => 'fas fa-heart',
                'books_count' => 42,
                'status' => 'active',
                'created_at' => '2023-05-15'
            ],
            [
                'id' => 2,
                'name' => 'Science Fiction',
                'color' => '#4E7CFF',
                'icon' => 'fas fa-rocket',
                'books_count' => 28,
                'status' => 'active',
                'created_at' => '2023-06-20'
            ],
            [
                'id' => 3,
                'name' => 'Thriller',
                'color' => '#9747FF',
                'icon' => 'fas fa-mask',
                'books_count' => 35,
                'status' => 'active',
                'created_at' => '2023-04-10'
            ],
            [
                'id' => 4,
                'name' => 'Fantasy',
                'color' => '#00C48C',
                'icon' => 'fas fa-dragon',
                'books_count' => 56,
                'status' => 'active',
                'created_at' => '2023-03-25'
            ],
            [
                'id' => 5,
                'name' => 'Biography',
                'color' => '#FFC700',
                'icon' => 'fas fa-user-tie',
                'books_count' => 19,
                'status' => 'inactive',
                'created_at' => '2023-07-05'
            ],
        ];
        
        return view('admin.category-list', compact('categories'));
    }

    public function addAuthor()
    {
        return view('admin.admin-add-author');
    }

    public function addBook()
    {
        return view('admin.admin-add-book');
    }

    public function addCategory()
    {
        return view('admin.admin-add-category');
    }

    public function orders()
    {
        return view('admin.orders');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function exchanges()
    {
        // Vous pourrez ajouter ici la logique pour récupérer les données d'échanges réelles
        return view('admin.exchanges');
    }
}
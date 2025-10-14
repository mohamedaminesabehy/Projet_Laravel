<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartHistory;
use Illuminate\Support\Carbon;

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

    public function orders(Request $request)
    {
        $query = CartHistory::with(['user', 'book']);

        // Recherche
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->orWhere('id', (int)$search);
                }
                $q->orWhereHas('user', function ($uq) use ($search) {
                    $uq->where(function ($uq2) use ($search) {
                        $uq2->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]) 
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                })
                ->orWhereHas('book', function ($bq) use ($search) {
                    $bq->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Statut
        if ($request->filled('status')) {
            $query->where('payment_status', $request->input('status'));
        }

        // Méthode de paiement (approximation: PayPal => completed)
        if ($request->filled('payment')) {
            $payment = $request->input('payment');
            if ($payment === 'paypal') {
                $query->where('payment_status', 'completed');
            } else {
                // Aucun autre moyen de paiement n'est stocké actuellement
                // Retourner un ensemble vide pour les autres options
                $query->whereRaw('1 = 0');
            }
        }

        // Date spécifique
        if ($request->filled('date')) {
            $query->whereDate('transaction_date', $request->input('date'));
        }

        // Période
        if ($request->filled('period')) {
            $period = $request->input('period');
            switch ($period) {
                case 'today':
                    $query->whereDate('transaction_date', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('transaction_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('transaction_date', Carbon::now()->month)
                          ->whereYear('transaction_date', Carbon::now()->year);
                    break;
                case 'year':
                    $query->whereYear('transaction_date', Carbon::now()->year);
                    break;
            }
        }

        $orders = $query->orderBy('transaction_date', 'desc')->get();
        return view('admin.orders', compact('orders'));
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
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Book;
use App\Models\CategoryFavorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminCategoryStatisticsController extends Controller
{
    /**
     * Display the category statistics dashboard
     */
    public function index(Request $request)
    {
        // Get date range from request or default to all time
        $startDate = $request->input('start_date', Carbon::now()->subYear());
        $endDate = $request->input('end_date', Carbon::now());

        // Convert to Carbon instances if strings
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // General KPIs
        $totalCategories = Category::count();
        $activeCategories = Category::where('is_active', true)->count();
        $totalBooks = Book::count();
        $totalFavorites = CategoryFavorite::count();

        // Average books per category
        $avgBooksPerCategory = $totalCategories > 0 
            ? round($totalBooks / $totalCategories, 2) 
            : 0;

        // Top 15 Categories by Book Count
        $topCategoriesByBooks = Category::select(
                'categories.id',
                'categories.name',
                'categories.color',
                DB::raw('COUNT(books.id) as books_count')
            )
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('books_count')
            ->limit(15)
            ->get();

        // Top 15 Categories by Favorites
        $topCategoriesByFavorites = Category::select(
                'categories.id',
                'categories.name',
                'categories.color',
                DB::raw('COUNT(category_favorites.id) as favorites_count')
            )
            ->leftJoin('category_favorites', 'categories.id', '=', 'category_favorites.category_id')
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('favorites_count')
            ->limit(15)
            ->get();

        // Categories distribution by status
        $statusDistribution = [
            'active' => Category::where('is_active', true)->count(),
            'inactive' => Category::where('is_active', false)->count(),
        ];

        // Categories created over time (last 12 months)
        $monthlyCreation = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Category::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            
            $monthlyCreation[] = [
                'label' => $date->format('M Y'),
                'value' => $count
            ];
        }

        // Empty categories (no books)
        $emptyCategories = Category::doesntHave('books')
            ->select('id', 'name', 'color', 'is_active', 'created_at')
            ->get();

        // Categories with most recent activity
        $recentlyUpdatedCategories = Category::withCount('books')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        // Category usage statistics
        $categoryStats = Category::select(
                'categories.*',
                DB::raw('COUNT(DISTINCT books.id) as books_count'),
                DB::raw('COUNT(DISTINCT category_favorites.id) as favorites_count'),
                DB::raw('COUNT(DISTINCT category_favorites.user_id) as unique_users')
            )
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->leftJoin('category_favorites', 'categories.id', '=', 'category_favorites.category_id')
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description', 
                      'categories.color', 'categories.icon', 'categories.is_active', 'categories.user_id',
                      'categories.created_at', 'categories.updated_at')
            ->orderByDesc('books_count')
            ->get();

        // Current month vs last month comparison
        $currentMonthCategories = Category::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $lastMonthCategories = Category::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        
        $monthlyGrowth = $lastMonthCategories > 0 
            ? (($currentMonthCategories - $lastMonthCategories) / $lastMonthCategories) * 100 
            : 100;

        return view('admin.categories.statistics', compact(
            'totalCategories',
            'activeCategories',
            'totalBooks',
            'totalFavorites',
            'avgBooksPerCategory',
            'topCategoriesByBooks',
            'topCategoriesByFavorites',
            'statusDistribution',
            'monthlyCreation',
            'emptyCategories',
            'recentlyUpdatedCategories',
            'categoryStats',
            'currentMonthCategories',
            'lastMonthCategories',
            'monthlyGrowth',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Get chart data for AJAX requests
     */
    public function getChartData(Request $request)
    {
        $type = $request->input('type', 'books');

        $data = [];

        switch ($type) {
            case 'books':
                // Top categories by book count
                $categories = Category::select(
                        'categories.name',
                        'categories.color',
                        DB::raw('COUNT(books.id) as count')
                    )
                    ->leftJoin('books', 'categories.id', '=', 'books.category_id')
                    ->groupBy('categories.id', 'categories.name', 'categories.color')
                    ->orderByDesc('count')
                    ->limit(15)
                    ->get();

                $data = [
                    'labels' => $categories->pluck('name'),
                    'values' => $categories->pluck('count'),
                    'colors' => $categories->pluck('color'),
                ];
                break;

            case 'favorites':
                // Top categories by favorites
                $categories = Category::select(
                        'categories.name',
                        'categories.color',
                        DB::raw('COUNT(category_favorites.id) as count')
                    )
                    ->leftJoin('category_favorites', 'categories.id', '=', 'category_favorites.category_id')
                    ->groupBy('categories.id', 'categories.name', 'categories.color')
                    ->orderByDesc('count')
                    ->limit(15)
                    ->get();

                $data = [
                    'labels' => $categories->pluck('name'),
                    'values' => $categories->pluck('count'),
                    'colors' => $categories->pluck('color'),
                ];
                break;

            case 'status':
                // Distribution by status
                $active = Category::where('is_active', true)->count();
                $inactive = Category::where('is_active', false)->count();

                $data = [
                    'labels' => ['Active', 'Inactive'],
                    'values' => [$active, $inactive],
                    'colors' => ['#10b981', '#ef4444'],
                ];
                break;

            case 'monthly':
                // Monthly creation for last 12 months
                $months = [];
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $count = Category::whereMonth('created_at', $date->month)
                        ->whereYear('created_at', $date->year)
                        ->count();
                    
                    $months[] = [
                        'label' => $date->format('M Y'),
                        'value' => $count
                    ];
                }

                $data = [
                    'labels' => collect($months)->pluck('label'),
                    'values' => collect($months)->pluck('value'),
                ];
                break;

            case 'comparison':
                // Books vs Favorites comparison
                $categories = Category::select(
                        'categories.name',
                        DB::raw('COUNT(DISTINCT books.id) as books_count'),
                        DB::raw('COUNT(DISTINCT category_favorites.id) as favorites_count')
                    )
                    ->leftJoin('books', 'categories.id', '=', 'books.category_id')
                    ->leftJoin('category_favorites', 'categories.id', '=', 'category_favorites.category_id')
                    ->groupBy('categories.id', 'categories.name')
                    ->orderByDesc('books_count')
                    ->limit(10)
                    ->get();

                $data = [
                    'labels' => $categories->pluck('name'),
                    'books' => $categories->pluck('books_count'),
                    'favorites' => $categories->pluck('favorites_count'),
                ];
                break;
        }

        return response()->json($data);
    }

    /**
     * Export statistics report
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'csv');

        $categories = Category::select(
                'categories.*',
                DB::raw('COUNT(DISTINCT books.id) as books_count'),
                DB::raw('COUNT(DISTINCT category_favorites.id) as favorites_count')
            )
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->leftJoin('category_favorites', 'categories.id', '=', 'category_favorites.category_id')
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description',
                      'categories.color', 'categories.icon', 'categories.is_active', 'categories.user_id',
                      'categories.created_at', 'categories.updated_at')
            ->orderBy('name')
            ->get();

        if ($format === 'csv') {
            $filename = 'category_statistics_' . now()->format('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function() use ($categories) {
                $file = fopen('php://output', 'w');
                
                // Header
                fputcsv($file, ['Category Statistics Report']);
                fputcsv($file, ['Generated on: ' . now()->format('Y-m-d H:i:s')]);
                fputcsv($file, []);
                
                // Summary
                fputcsv($file, ['Total Categories', Category::count()]);
                fputcsv($file, ['Active Categories', Category::where('is_active', true)->count()]);
                fputcsv($file, ['Total Books', Book::count()]);
                fputcsv($file, []);
                
                // Category Details
                fputcsv($file, ['Category Name', 'Status', 'Books Count', 'Favorites Count', 'Color', 'Created At']);
                foreach ($categories as $category) {
                    fputcsv($file, [
                        $category->name,
                        $category->is_active ? 'Active' : 'Inactive',
                        $category->books_count,
                        $category->favorites_count,
                        $category->color,
                        $category->created_at->format('Y-m-d')
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } else {
            // JSON format
            return response()->json([
                'total_categories' => Category::count(),
                'active_categories' => Category::where('is_active', true)->count(),
                'total_books' => Book::count(),
                'categories' => $categories->toArray(),
            ]);
        }
    }
}

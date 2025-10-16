<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReviewStatisticsController extends Controller
{
    /**
     * Display the main statistics dashboard
     */
    public function index(Request $request)
    {
        // Get date range from request or default to ALL TIME (depuis le premier avis)
        $firstReview = Review::orderBy('created_at', 'asc')->first();
        $defaultStartDate = $firstReview ? $firstReview->created_at : Carbon::now()->subDays(365);
        
        $startDate = $request->input('start_date', $defaultStartDate);
        $endDate = $request->input('end_date', Carbon::now());

        // Convert to Carbon instances if strings
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // General KPIs
        $totalReviews = Review::whereBetween('created_at', [$startDate, $endDate])->count();
        $approvedReviews = Review::where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $pendingReviews = Review::where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $averageRating = Review::where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->avg('rating');

        // Approval rate
        $approvalRate = $totalReviews > 0 ? ($approvedReviews / $totalReviews) * 100 : 0;

        // Reviews by rating distribution
        $ratingDistribution = Review::whereBetween('created_at', [$startDate, $endDate])
            ->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        // Daily reviews trend (last 30 days)
        $dailyTrend = Review::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count'),
                DB::raw('avg(rating) as avg_rating')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top rated books
        $topRatedBooks = Book::select(
                'books.id',
                'books.title',
                'books.author',
                'books.isbn',
                'books.category_id',
                'books.created_at',
                'books.updated_at',
                DB::raw('AVG(reviews.rating) as avg_rating'),
                DB::raw('COUNT(reviews.id) as reviews_count')
            )
            ->join('reviews', 'books.id', '=', 'reviews.book_id')
            ->where('reviews.status', 'approved')
            ->whereBetween('reviews.created_at', [$startDate, $endDate])
            ->groupBy('books.id', 'books.title', 'books.author', 'books.isbn', 'books.category_id', 'books.created_at', 'books.updated_at')
            ->having('reviews_count', '>=', 3) // At least 3 reviews
            ->orderBy('avg_rating', 'desc')
            ->limit(10)
            ->get();

        // Most reviewed books
        $mostReviewedBooks = Book::select(
                'books.id',
                'books.title',
                'books.author',
                'books.isbn',
                'books.category_id',
                'books.created_at',
                'books.updated_at',
                DB::raw('COUNT(reviews.id) as reviews_count'),
                DB::raw('AVG(reviews.rating) as avg_rating')
            )
            ->join('reviews', 'books.id', '=', 'reviews.book_id')
            ->where('reviews.status', 'approved')
            ->whereBetween('reviews.created_at', [$startDate, $endDate])
            ->groupBy('books.id', 'books.title', 'books.author', 'books.isbn', 'books.category_id', 'books.created_at', 'books.updated_at')
            ->orderBy('reviews_count', 'desc')
            ->limit(10)
            ->get();

        // Most active reviewers
        $topReviewers = User::select(
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
                'users.updated_at',
                DB::raw('COUNT(reviews.id) as reviews_count'),
                DB::raw('AVG(reviews.rating) as avg_rating')
            )
            ->join('reviews', 'users.id', '=', 'reviews.user_id')
            ->whereBetween('reviews.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at', 'users.updated_at')
            ->orderBy('reviews_count', 'desc')
            ->limit(10)
            ->get();

        // Monthly comparison
        $currentMonthReviews = Review::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $lastMonthReviews = Review::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        $monthlyGrowth = $lastMonthReviews > 0 
            ? (($currentMonthReviews - $lastMonthReviews) / $lastMonthReviews) * 100 
            : 100;

        // Reviews by status
        $statusDistribution = Review::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('admin.statistics.reviews', compact(
            'totalReviews',
            'approvedReviews',
            'pendingReviews',
            'averageRating',
            'approvalRate',
            'ratingDistribution',
            'dailyTrend',
            'topRatedBooks',
            'mostReviewedBooks',
            'topReviewers',
            'currentMonthReviews',
            'lastMonthReviews',
            'monthlyGrowth',
            'statusDistribution',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Get analytics data for charts (AJAX)
     */
    public function getAnalyticsData(Request $request)
    {
        $type = $request->input('type', 'daily');
        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->subDays(30)));
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()));

        $data = [];

        switch ($type) {
            case 'daily':
                $data = Review::whereBetween('created_at', [$startDate, $endDate])
                    ->select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('count(*) as total'),
                        DB::raw('avg(rating) as avg_rating')
                    )
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;

            case 'monthly':
                $data = Review::whereBetween('created_at', [$startDate, $endDate])
                    ->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                        DB::raw('count(*) as total'),
                        DB::raw('avg(rating) as avg_rating')
                    )
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
                break;

            case 'rating':
                $data = Review::whereBetween('created_at', [$startDate, $endDate])
                    ->select('rating', DB::raw('count(*) as count'))
                    ->groupBy('rating')
                    ->orderBy('rating')
                    ->get();
                break;
        }

        return response()->json($data);
    }

    /**
     * Export statistics report
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'pdf');
        
        // Get date range from request or default to ALL TIME (depuis le premier avis)
        $firstReview = Review::orderBy('created_at', 'asc')->first();
        $defaultStartDate = $firstReview ? $firstReview->created_at : Carbon::now()->subDays(365);
        
        $startDate = $request->input('start_date', $defaultStartDate);
        $endDate = $request->input('end_date', Carbon::now());

        // Convert to Carbon instances if strings and set proper time boundaries
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();
        
        $filename = $request->input('filename', 'review_statistics_' . Carbon::now()->format('Y-m-d'));
        
        $includeCharts = $request->boolean('include_charts', true);
        $includeSummary = $request->boolean('include_summary', true);
        $includeDetails = $request->boolean('include_details', true);

        // Prepare comprehensive data
        $data = $this->prepareExportData($startDate, $endDate, $includeDetails);

        switch ($format) {
            case 'pdf':
                return $this->exportToPdf($data, $filename, $includeCharts, $includeSummary);
            
            case 'excel':
                return $this->exportToExcel($data, $filename, $includeCharts, $includeSummary);
            
            case 'csv':
                return $this->exportToCsv($data, $filename);
            
            default:
                return response()->json($data);
        }
    }

    /**
     * Prepare data for export
     */
    private function prepareExportData($startDate, $endDate, $includeDetails = true)
    {
        $data = [
            'period' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
                'formatted' => $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y')
            ],
            'summary' => [
                'total_reviews' => Review::whereBetween('created_at', [$startDate, $endDate])->count(),
                'approved_reviews' => Review::where('status', 'approved')->whereBetween('created_at', [$startDate, $endDate])->count(),
                'pending_reviews' => Review::where('status', 'pending')->whereBetween('created_at', [$startDate, $endDate])->count(),
                'rejected_reviews' => Review::where('status', 'rejected')->whereBetween('created_at', [$startDate, $endDate])->count(),
                'average_rating' => round(Review::where('status', 'approved')->whereBetween('created_at', [$startDate, $endDate])->avg('rating'), 2),
                'approval_rate' => 0,
            ],
            'rating_distribution' => Review::whereBetween('created_at', [$startDate, $endDate])
                ->select('rating', DB::raw('count(*) as count'))
                ->groupBy('rating')
                ->orderBy('rating', 'desc')
                ->get()
                ->toArray(),
            'top_books' => Book::select(
                    'books.title',
                    'books.author',
                    DB::raw('AVG(reviews.rating) as avg_rating'),
                    DB::raw('COUNT(reviews.id) as reviews_count')
                )
                ->join('reviews', 'books.id', '=', 'reviews.book_id')
                ->where('reviews.status', 'approved')
                ->whereBetween('reviews.created_at', [$startDate, $endDate])
                ->groupBy('books.id', 'books.title', 'books.author')
                ->orderBy('avg_rating', 'desc')
                ->limit(10)
                ->get()
                ->toArray(),
            'generated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        // Calculate approval rate
        if ($data['summary']['total_reviews'] > 0) {
            $data['summary']['approval_rate'] = round(($data['summary']['approved_reviews'] / $data['summary']['total_reviews']) * 100, 1);
        }

        // Include detailed reviews if requested
        if ($includeDetails) {
            $data['reviews'] = Review::with(['user', 'book'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();
        }

        return $data;
    }

    /**
     * Export to PDF format
     */
    private function exportToPdf($data, $filename, $includeCharts, $includeSummary)
    {
        // Create a print-friendly HTML that will auto-trigger browser's print-to-PDF
        $html = view('admin.statistics.exports.pdf', compact('data', 'includeCharts', 'includeSummary'))->render();
        
        // Add proper PDF filename
        $pdfFilename = $filename . '_' . date('YmdHis');
        
        $headers = [
            'Content-Type' => 'text/html; charset=utf-8',
            'Content-Disposition' => 'inline; filename="' . $pdfFilename . '.html"',
            'X-Suggested-Filename' => $pdfFilename . '.pdf',
        ];

        return response($html, 200, $headers);
    }

    /**
     * Export to Excel format with formatting
     */
    private function exportToExcel($data, $filename, $includeCharts, $includeSummary)
    {
        // Create properly formatted Excel-compatible HTML
        $html = view('admin.statistics.exports.excel', compact('data', 'includeCharts', 'includeSummary'))->render();
        
        // Ensure proper Excel filename
        $excelFilename = $filename . '_' . date('YmdHis') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $excelFilename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        // Add BOM for UTF-8 Excel compatibility
        $bom = "\xEF\xBB\xBF";
        return response($bom . $html, 200, $headers);
    }

    /**
     * Export to CSV format
     */
    private function exportToCsv($data, $filename)
    {
        $csvFilename = $filename . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$csvFilename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header section
            fputcsv($file, ['BOOKSHARE - REVIEW STATISTICS REPORT']);
            fputcsv($file, ['Generated:', $data['generated_at']]);
            fputcsv($file, ['Period:', $data['period']['formatted']]);
            fputcsv($file, []);
            
            // Summary Statistics
            fputcsv($file, ['SUMMARY STATISTICS']);
            fputcsv($file, ['Metric', 'Value']);
            fputcsv($file, ['Total Reviews', $data['summary']['total_reviews']]);
            fputcsv($file, ['Approved Reviews', $data['summary']['approved_reviews']]);
            fputcsv($file, ['Pending Reviews', $data['summary']['pending_reviews']]);
            fputcsv($file, ['Rejected Reviews', $data['summary']['rejected_reviews']]);
            fputcsv($file, ['Average Rating', number_format($data['summary']['average_rating'], 2) . ' / 5.00']);
            fputcsv($file, ['Approval Rate', $data['summary']['approval_rate'] . '%']);
            fputcsv($file, []);
            
            // Rating Distribution
            fputcsv($file, ['RATING DISTRIBUTION']);
            fputcsv($file, ['Rating (Stars)', 'Count', 'Percentage']);
            $totalRatings = array_sum(array_column($data['rating_distribution'], 'count'));
            foreach ($data['rating_distribution'] as $rating) {
                $percentage = $totalRatings > 0 ? round(($rating['count'] / $totalRatings) * 100, 1) : 0;
                fputcsv($file, [
                    $rating['rating'] . ' Stars',
                    $rating['count'],
                    $percentage . '%'
                ]);
            }
            fputcsv($file, []);
            
            // Top Rated Books
            fputcsv($file, ['TOP RATED BOOKS']);
            fputcsv($file, ['#', 'Book Title', 'Author', 'Average Rating', 'Total Reviews']);
            foreach ($data['top_books'] as $index => $book) {
                fputcsv($file, [
                    $index + 1,
                    $book['title'],
                    $book['author'],
                    number_format($book['avg_rating'], 2),
                    $book['reviews_count']
                ]);
            }
            fputcsv($file, []);
            
            // Detailed Reviews (if included)
            if (isset($data['reviews']) && !empty($data['reviews'])) {
                fputcsv($file, ['DETAILED REVIEWS']);
                fputcsv($file, ['Review ID', 'Book Title', 'Reviewer', 'Rating', 'Comment', 'Status', 'Created At']);
                
                foreach ($data['reviews'] as $review) {
                    fputcsv($file, [
                        $review['id'],
                        $review['book']['title'] ?? 'N/A',
                        $review['user']['name'] ?? 'N/A',
                        $review['rating'] . ' / 5',
                        substr($review['comment'], 0, 100) . (strlen($review['comment']) > 100 ? '...' : ''),
                        ucfirst($review['status'] ?? 'pending'),
                        Carbon::parse($review['created_at'])->format('Y-m-d H:i')
                    ]);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Compare periods
     */
    public function comparePeriods(Request $request)
    {
        $period1Start = Carbon::parse($request->input('period1_start'));
        $period1End = Carbon::parse($request->input('period1_end'));
        $period2Start = Carbon::parse($request->input('period2_start'));
        $period2End = Carbon::parse($request->input('period2_end'));

        $period1Data = [
            'total' => Review::whereBetween('created_at', [$period1Start, $period1End])->count(),
            'avg_rating' => Review::whereBetween('created_at', [$period1Start, $period1End])->avg('rating'),
            'approved' => Review::whereBetween('created_at', [$period1Start, $period1End])->where('status', 'approved')->count(),
        ];

        $period2Data = [
            'total' => Review::whereBetween('created_at', [$period2Start, $period2End])->count(),
            'avg_rating' => Review::whereBetween('created_at', [$period2Start, $period2End])->avg('rating'),
            'approved' => Review::whereBetween('created_at', [$period2Start, $period2End])->where('status', 'approved')->count(),
        ];

        return response()->json([
            'period1' => $period1Data,
            'period2' => $period2Data,
            'comparison' => [
                'total_change' => $period1Data['total'] - $period2Data['total'],
                'avg_rating_change' => $period1Data['avg_rating'] - $period2Data['avg_rating'],
                'approved_change' => $period1Data['approved'] - $period2Data['approved'],
            ]
        ]);
    }
}

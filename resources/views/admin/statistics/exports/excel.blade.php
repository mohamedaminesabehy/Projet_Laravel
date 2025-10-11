<!DOCTYPE html>
<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Review Statistics Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th {
            background-color: #667eea;
            color: white;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .header-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #667eea;
            padding: 10px 0;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
            padding: 5px 0;
        }
        .section-title {
            background-color: #764ba2;
            color: white;
            font-weight: bold;
            padding: 8px;
            margin-top: 20px;
        }
        .kpi-value {
            font-size: 16px;
            font-weight: bold;
            color: #667eea;
        }
        .total-row {
            background-color: #e3f2fd;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Title and Meta -->
    <table>
        <tr>
            <td colspan="6" class="title">BOOKSHARE - REVIEW STATISTICS REPORT</td>
        </tr>
        <tr>
            <td colspan="6" class="subtitle">Generated: {{ $data['generated_at'] }}</td>
        </tr>
        <tr>
            <td colspan="6" class="subtitle">Period: {{ $data['period']['formatted'] }}</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
    </table>

    @if($includeSummary)
    <!-- Summary Statistics -->
    <table>
        <tr>
            <td colspan="6" class="section-title">SUMMARY STATISTICS</td>
        </tr>
        <tr class="header-row">
            <th>Metric</th>
            <th colspan="5">Value</th>
        </tr>
        <tr>
            <td>Total Reviews</td>
            <td colspan="5" class="kpi-value">{{ number_format($data['summary']['total_reviews']) }}</td>
        </tr>
        <tr>
            <td>Approved Reviews</td>
            <td colspan="5" class="kpi-value" style="color: #28a745;">{{ number_format($data['summary']['approved_reviews']) }}</td>
        </tr>
        <tr>
            <td>Pending Reviews</td>
            <td colspan="5" class="kpi-value" style="color: #ffc107;">{{ number_format($data['summary']['pending_reviews']) }}</td>
        </tr>
        <tr>
            <td>Rejected Reviews</td>
            <td colspan="5" class="kpi-value" style="color: #dc3545;">{{ number_format($data['summary']['rejected_reviews']) }}</td>
        </tr>
        <tr>
            <td>Average Rating</td>
            <td colspan="5" class="kpi-value">{{ number_format($data['summary']['average_rating'], 2) }} / 5.00</td>
        </tr>
        <tr>
            <td>Approval Rate</td>
            <td colspan="5" class="kpi-value">{{ $data['summary']['approval_rate'] }}%</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
    </table>
    @endif

    <!-- Rating Distribution -->
    <table>
        <tr>
            <td colspan="6" class="section-title">RATING DISTRIBUTION</td>
        </tr>
        <tr>
            <th>Rating (Stars)</th>
            <th>Count</th>
            <th>Percentage</th>
            <th colspan="3">Visual Representation</th>
        </tr>
        @php
            $totalRatings = array_sum(array_column($data['rating_distribution'], 'count'));
        @endphp
        @foreach($data['rating_distribution'] as $rating)
        <tr>
            <td>{{ $rating['rating'] }} ⭐</td>
            <td>{{ $rating['count'] }}</td>
            <td>{{ $totalRatings > 0 ? round(($rating['count'] / $totalRatings) * 100, 1) : 0 }}%</td>
            <td colspan="3" style="background: linear-gradient(90deg, #667eea {{ $totalRatings > 0 ? ($rating['count'] / $totalRatings) * 100 : 0 }}%, white {{ $totalRatings > 0 ? ($rating['count'] / $totalRatings) * 100 : 0 }}%);">
                {{ str_repeat('█', min(50, $totalRatings > 0 ? intval(($rating['count'] / $totalRatings) * 50) : 0)) }}
            </td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td>TOTAL</td>
            <td>{{ $totalRatings }}</td>
            <td>100%</td>
            <td colspan="3"></td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
    </table>

    <!-- Top Rated Books -->
    <table>
        <tr>
            <td colspan="6" class="section-title">TOP RATED BOOKS</td>
        </tr>
        <tr>
            <th>#</th>
            <th>Book Title</th>
            <th>Author</th>
            <th>Average Rating</th>
            <th>Total Reviews</th>
            <th>Rating Stars</th>
        </tr>
        @foreach($data['top_books'] as $index => $book)
        <tr>
            <td style="font-weight: bold; text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $book['title'] }}</td>
            <td>{{ $book['author'] }}</td>
            <td style="text-align: center; font-weight: bold; color: #ffc107;">{{ number_format($book['avg_rating'], 2) }}</td>
            <td style="text-align: center;">{{ $book['reviews_count'] }}</td>
            <td>{{ str_repeat('⭐', intval(round($book['avg_rating']))) }}</td>
        </tr>
        @endforeach
        <tr><td colspan="6">&nbsp;</td></tr>
    </table>

    <!-- Detailed Reviews (if included) -->
    @if(isset($data['reviews']) && !empty($data['reviews']))
    <table>
        <tr>
            <td colspan="7" class="section-title">DETAILED REVIEWS</td>
        </tr>
        <tr>
            <th>Review ID</th>
            <th>Book Title</th>
            <th>Reviewer</th>
            <th>Rating</th>
            <th>Comment Preview</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
        @foreach($data['reviews'] as $review)
        <tr>
            <td>{{ $review['id'] }}</td>
            <td>{{ $review['book']['title'] ?? 'N/A' }}</td>
            <td>{{ $review['user']['name'] ?? 'N/A' }}</td>
            <td style="text-align: center;">{{ $review['rating'] }} / 5</td>
            <td>{{ Str::limit($review['comment'], 50) }}</td>
            <td style="text-align: center;">
                @if($review['status'] === 'approved')
                    <span style="color: #28a745; font-weight: bold;">✓ Approved</span>
                @elseif($review['status'] === 'pending')
                    <span style="color: #ffc107; font-weight: bold;">⏳ Pending</span>
                @else
                    <span style="color: #dc3545; font-weight: bold;">✗ Rejected</span>
                @endif
            </td>
            <td>{{ \Carbon\Carbon::parse($review['created_at'])->format('Y-m-d H:i') }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    <!-- Footer -->
    <br><br>
    <table>
        <tr>
            <td colspan="6" style="text-align: center; color: #999; font-size: 11px; border: none;">
                <strong>BookShare Review Management System</strong><br>
                © {{ date('Y') }} BookShare. All rights reserved.<br>
                This is an automatically generated report.
            </td>
        </tr>
    </table>
</body>
</html>

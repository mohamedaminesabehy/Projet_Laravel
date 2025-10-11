<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Statistics Report - BookShare</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 3px solid #667eea;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 10px;
        }
        .header .subtitle {
            color: #666;
            font-size: 18px;
        }
        .meta-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .meta-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .section {
            margin-bottom: 40px;
        }
        .section-title {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .kpi-card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .kpi-card .label {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .kpi-card .value {
            color: #333;
            font-size: 28px;
            font-weight: bold;
        }
        .kpi-card .subtext {
            color: #999;
            font-size: 12px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .rating-stars {
            color: #ffc107;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-approved {
            background: #28a745;
            color: white;
        }
        .badge-pending {
            background: #ffc107;
            color: #333;
        }
        .badge-rejected {
            background: #dc3545;
            color: white;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
        .chart-placeholder {
            background: #f0f0f0;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 20px 0;
            color: #666;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📊 BOOKSHARE</h1>
            <div class="subtitle">Review Statistics Report</div>
        </div>

        <!-- Meta Information -->
        <div class="meta-info">
            <p><strong>Report Period:</strong> {{ $data['period']['formatted'] }}</p>
            <p><strong>Generated:</strong> {{ $data['generated_at'] }}</p>
            <p><strong>Report Type:</strong> Comprehensive Review Analytics</p>
        </div>

        @if($includeSummary)
        <!-- Summary Statistics -->
        <div class="section">
            <h2 class="section-title">📈 Summary Statistics</h2>
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Total Reviews</div>
                    <div class="value">{{ number_format($data['summary']['total_reviews']) }}</div>
                    <div class="subtext">All statuses included</div>
                </div>
                <div class="kpi-card" style="border-left-color: #28a745;">
                    <div class="label">Approved Reviews</div>
                    <div class="value">{{ number_format($data['summary']['approved_reviews']) }}</div>
                    <div class="subtext">{{ $data['summary']['approval_rate'] }}% approval rate</div>
                </div>
                <div class="kpi-card" style="border-left-color: #ffc107;">
                    <div class="label">Average Rating</div>
                    <div class="value">{{ number_format($data['summary']['average_rating'], 1) }}</div>
                    <div class="subtext rating-stars">★★★★★</div>
                </div>
            </div>

            <div class="kpi-grid">
                <div class="kpi-card" style="border-left-color: #ffc107;">
                    <div class="label">Pending Reviews</div>
                    <div class="value">{{ number_format($data['summary']['pending_reviews']) }}</div>
                    <div class="subtext">Awaiting moderation</div>
                </div>
                <div class="kpi-card" style="border-left-color: #dc3545;">
                    <div class="label">Rejected Reviews</div>
                    <div class="value">{{ number_format($data['summary']['rejected_reviews']) }}</div>
                    <div class="subtext">Not approved</div>
                </div>
                <div class="kpi-card" style="border-left-color: #17a2b8;">
                    <div class="label">Approval Rate</div>
                    <div class="value">{{ $data['summary']['approval_rate'] }}%</div>
                    <div class="subtext">Approved / Total</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Rating Distribution -->
        <div class="section">
            <h2 class="section-title">⭐ Rating Distribution</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rating</th>
                        <th>Count</th>
                        <th>Percentage</th>
                        <th>Visual</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalRatings = array_sum(array_column($data['rating_distribution'], 'count'));
                    @endphp
                    @foreach($data['rating_distribution'] as $rating)
                    <tr>
                        <td class="rating-stars">
                            @for($i = 0; $i < $rating['rating']; $i++)
                                ★
                            @endfor
                        </td>
                        <td>{{ $rating['count'] }}</td>
                        <td>{{ $totalRatings > 0 ? round(($rating['count'] / $totalRatings) * 100, 1) : 0 }}%</td>
                        <td>
                            <div style="background: linear-gradient(90deg, #667eea 0%, #667eea {{ $totalRatings > 0 ? ($rating['count'] / $totalRatings) * 100 : 0 }}%, #e0e0e0 {{ $totalRatings > 0 ? ($rating['count'] / $totalRatings) * 100 : 0 }}%); height: 20px; border-radius: 10px; width: 200px;"></div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Top Rated Books -->
        <div class="section">
            <h2 class="section-title">🏆 Top Rated Books</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Avg Rating</th>
                        <th>Reviews</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['top_books'] as $index => $book)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td>{{ $book['title'] }}</td>
                        <td>{{ $book['author'] }}</td>
                        <td class="rating-stars">{{ number_format($book['avg_rating'], 1) }} ★</td>
                        <td>{{ $book['reviews_count'] }} reviews</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>BookShare</strong> - Review Management System</p>
            <p>This is an automatically generated report. For inquiries, contact admin@bookshare.com</p>
            <p>© {{ date('Y') }} BookShare. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Auto-trigger print dialog when page loads
        window.onload = function() {
            // Show instructions
            setTimeout(function() {
                alert('📄 INSTRUCTIONS POUR SAUVEGARDER EN PDF:\n\n' +
                      '1. La boîte de dialogue d\'impression va s\'ouvrir\n' +
                      '2. Sélectionnez "Microsoft Print to PDF" ou "Enregistrer au format PDF"\n' +
                      '3. Choisissez votre dossier de destination\n' +
                      '4. Cliquez sur "Enregistrer"\n\n' +
                      'Cliquez sur OK pour continuer...');
                
                // Trigger print dialog
                window.print();
            }, 500);
        }
        
        // If user cancels, offer to download as HTML
        window.onafterprint = function() {
            setTimeout(function() {
                if(confirm('Voulez-vous télécharger une copie HTML du rapport ?')) {
                    var blob = new Blob([document.documentElement.outerHTML], {type: 'text/html'});
                    var url = URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'review_statistics_{{ date("Y-m-d_His") }}.html';
                    a.click();
                }
            }, 1000);
        }
    </script>
</body>
</html>

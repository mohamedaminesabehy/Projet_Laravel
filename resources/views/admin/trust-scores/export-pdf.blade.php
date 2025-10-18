<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Scores de Confiance - {{ date('d/m/Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1 {
            color: #c9848f;
            text-align: center;
            margin-bottom: 10px;
        }
        .stats {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .stats-grid {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #c9848f;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #c9848f;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .print-button {
            text-align: center;
            margin: 20px 0;
        }
        .btn-print {
            background-color: #c9848f;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-print:hover {
            background-color: #b67680;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>📊 Rapport des Scores de Confiance IA</h1>
    <p style="text-align: center; color: #666;">Généré le {{ date('d/m/Y à H:i') }}</p>

    <div class="stats">
        <h3 style="margin: 0 0 10px 0;">Statistiques Globales</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Utilisateurs Total</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['verified'] }}</div>
                <div class="stat-label">Vérifiés (≥80)</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['suspicious'] }}</div>
                <div class="stat-label">Suspects (<40)</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ number_format($stats['average'], 1) }}</div>
                <div class="stat-label">Score Moyen</div>
            </div>
        </div>
    </div>

    <div class="print-button">
        <button class="btn-print" onclick="window.print()">🖨️ Imprimer / Sauvegarder en PDF</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Utilisateur</th>
                <th>Email</th>
                <th>Score</th>
                <th>Niveau</th>
                <th>Statut</th>
                <th>Échanges</th>
                <th>Annulations</th>
                <th>Messages</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $trustScore)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $trustScore->user->first_name }} {{ $trustScore->user->last_name }}</td>
                <td>{{ $trustScore->user->email }}</td>
                <td><strong>{{ $trustScore->trust_score }}</strong></td>
                <td>{{ $trustScore->trust_level }}</td>
                <td>
                    @if($trustScore->is_verified)
                        <span class="badge badge-success">✓ Vérifié</span>
                    @elseif($trustScore->trust_score < 40)
                        <span class="badge badge-danger">⚠ Suspect</span>
                    @else
                        <span class="badge badge-warning">Standard</span>
                    @endif
                </td>
                <td>{{ $trustScore->successful_exchanges }}</td>
                <td>{{ $trustScore->cancelled_meetings }}</td>
                <td>{{ $trustScore->messages_sent + $trustScore->messages_received }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Système IA de Scores de Confiance</strong></p>
        <p>Formule : Score = 50 + (Échanges×5) - (Annulations×10) + (Messages>20?10:0) + (Âge>30j?10:5)</p>
        <p>© {{ date('Y') }} - Plateforme d'Échange de Livres</p>
    </div>

    <script>
        // Ouvrir automatiquement la boîte de dialogue d'impression après 500ms
        setTimeout(function() {
            window.print();
        }, 500);
    </script>
</body>
</html>

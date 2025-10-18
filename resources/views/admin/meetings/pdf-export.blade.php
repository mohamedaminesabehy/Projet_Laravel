<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export des Rendez-vous</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #2d3748;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #c9848f;
        }
        
        .header h1 {
            color: #c9848f;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .header p {
            color: #6c757d;
            font-size: 12px;
        }
        
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
        }
        
        .stat-label {
            font-size: 10px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 20px;
            color: #1a202c;
            font-weight: 700;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background-color: #c9848f;
            color: white;
        }
        
        thead th {
            padding: 12px 8px;
            text-align: left;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
        }
        
        tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tbody td {
            padding: 10px 8px;
            font-size: 10px;
            color: #2d3748;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-proposed {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-confirmed {
            background-color: #f8e8eb;
            color: #8b4951;
        }
        
        .badge-completed {
            background-color: #dbeafe;
            color: #1e3a8a;
        }
        
        .badge-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #6c757d;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <h1>📅 Export des Rendez-vous</h1>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- Statistiques -->
    <div class="stats">
        <div class="stat-item">
            <div class="stat-label">Total</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Proposés</div>
            <div class="stat-value">{{ $stats['proposed'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Confirmés</div>
            <div class="stat-value">{{ $stats['confirmed'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Terminés</div>
            <div class="stat-value">{{ $stats['completed'] }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Annulés</div>
            <div class="stat-value">{{ $stats['cancelled'] }}</div>
        </div>
    </div>

    <!-- Tableau des rendez-vous -->
    @if($meetings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 12%;">Date/Heure</th>
                    <th style="width: 20%;">Utilisateurs</th>
                    <th style="width: 15%;">Lieu</th>
                    <th style="width: 20%;">Livres</th>
                    <th style="width: 10%;">Statut</th>
                    <th style="width: 18%;">Proposé</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meetings as $meeting)
                    <tr>
                        <td>{{ $meeting->id }}</td>
                        <td>
                            {{ $meeting->meeting_date->format('d/m/Y') }}<br>
                            <small style="color: #6c757d;">{{ \Carbon\Carbon::parse($meeting->meeting_time)->format('H:i') }}</small>
                        </td>
                        <td>
                            <strong>{{ $meeting->user1->name }}</strong><br>
                            <small style="color: #6c757d;">↔</small><br>
                            <strong>{{ $meeting->user2->name }}</strong>
                        </td>
                        <td>{{ Str::limit($meeting->meeting_place, 25) }}</td>
                        <td>
                            @if($meeting->book1)
                                {{ Str::limit($meeting->book1->title, 20) }}
                            @endif
                            @if($meeting->book1 && $meeting->book2)
                                <br><small style="color: #6c757d;">↔</small><br>
                            @endif
                            @if($meeting->book2)
                                {{ Str::limit($meeting->book2->title, 20) }}
                            @endif
                            @if(!$meeting->book1 && !$meeting->book2)
                                <em style="color: #9ca3af;">Aucun</em>
                            @endif
                        </td>
                        <td>
                            @php
                                $badges = [
                                    'proposed' => 'proposed',
                                    'confirmed' => 'confirmed',
                                    'completed' => 'completed',
                                    'cancelled' => 'cancelled',
                                ];
                            @endphp
                            <span class="badge badge-{{ $badges[$meeting->status] ?? 'secondary' }}">
                                {{ $meeting->status_text }}
                            </span>
                        </td>
                        <td>
                            <small>Par: <strong>{{ $meeting->proposedBy->name }}</strong></small><br>
                            <small style="color: #6c757d;">Le: {{ $meeting->proposed_at->format('d/m/Y') }}</small>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            Aucun rendez-vous à afficher
        </div>
    @endif

    <!-- Pied de page -->
    <div class="footer">
        <p><strong>Plateforme d'échange de livres</strong> | Document généré automatiquement</p>
        <p>© {{ date('Y') }} - Tous droits réservés</p>
    </div>
</body>
</html>

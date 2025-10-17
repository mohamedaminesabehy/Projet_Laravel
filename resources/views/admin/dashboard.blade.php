@extends('layouts.admin')

@section('title', 'Tableau de bord')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
<style>
    body {
        background-color: #f8f9fa; /* Light gray background for a modern feel */
    }
    .stat-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 20px;
    }
    .activity-item {
        padding: 15px;
        border-left: 3px solid #e0e0e0;
        position: relative;
        margin-bottom: 15px;
    }
    .activity-item:hover {
        background-color: #f9f9f9;
    }
    .activity-item::before {
        content: '';
        position: absolute;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #4e73df;
        left: -7px;
        top: 15px;
    }
    .activity-time {
        font-size: 12px;
        color: #6c757d;
    }
    select, .form-control, .form-select, textarea, input {
    height: 50px;
    padding: 0 30px 0 28px;
    padding-right: 45px;
    border: 1px solid var(--border-color);
    color: #000000;
    background-color: var(--white-color);
    border-radius: 9999px;
    border-radius: 0;
    font-size: 14px;
    width: 100%;
}
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- Statistiques principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Catégories</h6>
                        <h3 class="mb-0 font-weight-bold">24</h3>
                        <p class="text-success mb-0"><i class="fas fa-arrow-up me-1"></i>3 nouvelles ce mois</p>
                    </div>
                    <div class="stat-icon bg-primary-soft text-primary">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Livres échangés</h6>
                        <h3 class="mb-0 font-weight-bold">358</h3>
                        <p class="text-success mb-0"><i class="fas fa-arrow-up me-1"></i>15% ce mois</p>
                    </div>
                    <div class="stat-icon bg-success-soft text-success">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Livres disponibles</h6>
                        <h3 class="mb-0 font-weight-bold">1,258</h3>
                        <p class="text-success mb-0"><i class="fas fa-arrow-up me-1"></i>12% ce mois</p>
                    </div>
                    <div class="stat-icon bg-info-soft text-info">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Utilisateurs actifs</h6>
                        <h3 class="mb-0 font-weight-bold">842</h3>
                        <p class="text-success mb-0"><i class="fas fa-arrow-up me-1"></i>9.1% ce mois</p>
                    </div>
                    <div class="stat-icon bg-warning-soft text-warning">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row mb-4">
        <div class="col-xl-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Activité des échanges de livres</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="exchangeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Répartition des catégories</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières activités et commandes récentes -->
    <div class="row">
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dernières activités</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <strong>Nouveau livre ajouté</strong>
                                <span class="activity-time">Il y a 2 heures</span>
                            </div>
                            <p class="mb-0 text-muted">Le livre "L'Art de la Guerre" a été ajouté au catalogue</p>
                        </div>
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <strong>Commande #1234 complétée</strong>
                                <span class="activity-time">Il y a 5 heures</span>
                            </div>
                            <p class="mb-0 text-muted">La commande a été livrée avec succès</p>
                        </div>
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <strong>Nouvel utilisateur inscrit</strong>
                                <span class="activity-time">Il y a 1 jour</span>
                            </div>
                            <p class="mb-0 text-muted">Marie Dupont a créé un compte</p>
                        </div>
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <strong>Catégorie ajoutée</strong>
                                <span class="activity-time">Il y a 2 jours</span>
                            </div>
                            <p class="mb-0 text-muted">Nouvelle catégorie "Science Fiction" ajoutée</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Commandes récentes</h5>
                    <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">ID</th>
                                    <th class="text-dark">Client</th>
                                    <th class="text-dark">Total</th>
                                    <th class="text-dark">Statut</th>
                                    <th class="text-dark">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-dark">#ORD001</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/30" alt="Avatar" class="rounded-circle me-2" width="30" height="30">
                                            <span class="text-dark">Jean Dupont</span>
                                        </div>
                                    </td>
                                    <td class="text-dark">59.99 €</td>
                                    <td><span class="badge bg-success-subtle text-success text-dark">Terminée</span></td>
                                    <td class="text-dark">2023-10-26</td>
                                </tr>
                                <tr>
                                    <td class="text-dark">#ORD002</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/30" alt="Avatar" class="rounded-circle me-2" width="30" height="30">
                                            <span class="text-dark">Marie Curie</span>
                                        </div>
                                    </td>
                                    <td class="text-dark">34.50 €</td>
                                    <td><span class="badge bg-warning-subtle text-warning text-dark">En attente</span></td>
                                    <td class="text-dark">2023-10-25</td>
                                </tr>
                                <tr>
                                    <td class="text-dark">#ORD003</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/30" alt="Avatar" class="rounded-circle me-2" width="30" height="30">
                                            <span class="text-dark">Pierre Martin</span>
                                        </div>
                                    </td>
                                    <td class="text-dark">120.00 €</td>
                                    <td><span class="badge bg-danger-subtle text-danger text-dark">Annulée</span></td>
                                    <td class="text-dark">2023-10-24</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Graphique des échanges de livres
    const exchangeCtx = document.getElementById('exchangeChart').getContext('2d');
    const exchangeChart = new Chart(exchangeCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Livres échangés 2023',
                data: [28, 35, 42, 51, 48, 55, 62, 68, 72, 75, 82, 88],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                tension: 0.3,
                fill: true
            }, {
                label: 'Nouveaux livres ajoutés 2023',
                data: [45, 52, 38, 65, 72, 58, 80, 85, 92, 105, 112, 98],
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.05)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Graphique de répartition des catégories
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Fiction', 'Non-fiction', 'Jeunesse', 'Scolaire', 'Professionnel'],
            datasets: [{
                data: [35, 25, 20, 10, 10],
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            cutout: '70%'
        }
    });
</script>
@endpush
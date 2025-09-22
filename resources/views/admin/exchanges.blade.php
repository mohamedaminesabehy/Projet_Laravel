@extends('layouts.admin')

@section('title', 'Gestion des Échanges')

@push('styles')
<style>
    body {
        background-color: #f8f9fa; /* Light gray background for a modern feel */
    }
    .exchange-card {
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    .exchange-card:hover {
        transform: translateY(-5px);
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .exchange-details {
        border-left: 3px solid #e0e0e0;
        padding-left: 15px;
    }
    .book-cover {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }
    .exchange-filter-btn.active {
        background-color: #4e73df;
        color: white;
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Échanges</h1>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="fas fa-file-export me-2"></i>Exporter
            </button>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Filtres</h6>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                <i class="fas fa-filter me-1"></i>Afficher/Masquer
            </button>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-dark">Statut</label>
                        <select class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="pending">En attente</option>
                            <option value="approved">Approuvé</option>
                            <option value="in_progress">En cours</option>
                            <option value="completed">Complété</option>
                            <option value="cancelled">Annulé</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Utilisateur</label>
                        <input type="text" class="form-control" placeholder="Nom ou email">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Livre</label>
                        <input type="text" class="form-control" placeholder="Titre du livre">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-secondary me-2">Réinitialiser</button>
                    <button class="btn btn-primary">Appliquer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets de statut -->
    <div class="mb-4">
        <div class="btn-group w-100">
            <button class="btn btn-outline-primary exchange-filter-btn active" data-filter="all">
                Tous <span class="badge bg-secondary ms-1">42</span>
            </button>
            <button class="btn btn-outline-primary exchange-filter-btn" data-filter="pending">
                En attente <span class="badge bg-warning ms-1">12</span>
            </button>
            <button class="btn btn-outline-primary exchange-filter-btn" data-filter="approved">
                Approuvés <span class="badge bg-info ms-1">8</span>
            </button>
            <button class="btn btn-outline-primary exchange-filter-btn" data-filter="in_progress">
                En cours <span class="badge bg-primary ms-1">15</span>
            </button>
            <button class="btn btn-outline-primary exchange-filter-btn" data-filter="completed">
                Complétés <span class="badge bg-success ms-1">5</span>
            </button>
            <button class="btn btn-outline-primary exchange-filter-btn" data-filter="cancelled">
                Annulés <span class="badge bg-danger ms-1">2</span>
            </button>
        </div>
    </div>

    <!-- Liste des échanges -->
    <div class="row" id="exchangesList">
        <!-- Échange 1 -->
        <div class="col-12 mb-4 exchange-item" data-status="in_progress">
            <div class="card exchange-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0 text-dark">Échange #EX-2023-001</h5>
                        <span class="status-badge bg-primary-subtle text-primary">En cours</span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images/user-1.jpg') }}" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <h6 class="mb-0 text-dark">Sophie Martin</h6>
                                    <small class="text-muted text-dark">sophie.martin@email.com</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="exchange-details">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/book-cover-1.jpg') }}" class="book-cover me-2">
                                            <div>
                                                <h6 class="mb-0 text-dark">Le Nom du Vent</h6>
                                                <small class="text-muted text-dark">Patrick Rothfuss</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <i class="fas fa-exchange-alt fa-2x text-primary"></i>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/book-cover-2.jpg') }}" class="book-cover me-2">
                                            <div>
                                                <h6 class="mb-0 text-dark">La Peur du Sage</h6>
                                                <small class="text-muted text-dark">Patrick Rothfuss</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex flex-column align-items-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exchangeDetailsModal"><i class="fas fa-eye me-2 text-primary"></i>Voir détails</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-check me-2 text-success"></i>Marquer comme complété</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-times me-2 text-danger"></i>Annuler l'échange</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Contacter l'utilisateur</a></li>
                                    </ul>
                                </div>
                                <small class="text-muted mt-2 text-dark">Créé le: 15/06/2023</small>
                                <small class="text-muted text-dark">Mis à jour: 18/06/2023</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Échange 2 -->
        <div class="col-12 mb-4 exchange-item" data-status="pending">
            <div class="card exchange-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0 text-dark">Échange #EX-2023-002</h5>
                        <span class="status-badge bg-warning-subtle text-warning">En attente</span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images/user-2.jpg') }}" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <h6 class="mb-0">Thomas Dubois</h6>
                                    <small class="text-muted">thomas.dubois@email.com</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="exchange-details">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/book-cover-3.jpg') }}" class="book-cover me-2">
                                            <div>
                                                <h6 class="mb-0">1984</h6>
                                                <small class="text-muted">George Orwell</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <i class="fas fa-exchange-alt fa-2x text-primary"></i>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/book-cover-4.jpg') }}" class="book-cover me-2">
                                            <div>
                                                <h6 class="mb-0">Le Meilleur des Mondes</h6>
                                                <small class="text-muted">Aldous Huxley</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex flex-column align-items-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exchangeDetailsModal"><i class="fas fa-eye me-2 text-primary"></i>Voir détails</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-check me-2 text-success"></i>Approuver</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-times me-2 text-danger"></i>Rejeter</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Contacter l'utilisateur</a></li>
                                    </ul>
                                </div>
                                <small class="text-muted mt-2">Créé le: 20/06/2023</small>
                                <small class="text-muted">Mis à jour: 20/06/2023</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Échange 3 -->
        <div class="col-12 mb-4 exchange-item" data-status="completed">
            <div class="card exchange-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0 text-dark">Échange #EX-2023-003</h5>
                        <span class="status-badge bg-success-subtle text-success">Complété</span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images/user-3.jpg') }}" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <h6 class="mb-0">Marie Leroy</h6>
                                    <small class="text-muted">marie.leroy@email.com</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="exchange-details">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/book-cover-5.jpg') }}" class="book-cover me-2">
                                            <div>
                                                <h6 class="mb-0">Harry Potter à l'école des sorciers</h6>
                                                <small class="text-muted">J.K. Rowling</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <i class="fas fa-exchange-alt fa-2x text-success"></i>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/book-cover-6.jpg') }}" class="book-cover me-2">
                                            <div>
                                                <h6 class="mb-0">Le Seigneur des Anneaux</h6>
                                                <small class="text-muted">J.R.R. Tolkien</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex flex-column align-items-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exchangeDetailsModal"><i class="fas fa-eye me-2 text-primary"></i>Voir détails</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-undo me-2 text-warning"></i>Rouvrir l'échange</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Contacter l'utilisateur</a></li>
                                    </ul>
                                </div>
                                <small class="text-muted mt-2">Créé le: 10/06/2023</small>
                                <small class="text-muted">Complété le: 15/06/2023</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Pagination des échanges">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Suivant</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Modal Détails de l'échange -->
<div class="modal fade" id="exchangeDetailsModal" tabindex="-1" aria-labelledby="exchangeDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exchangeDetailsModalLabel">Détails de l'échange #EX-2023-001</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Informations générales</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>ID de l'échange:</th>
                                <td>EX-2023-001</td>
                            </tr>
                            <tr>
                                <th>Date de création:</th>
                                <td>15/06/2023 14:30</td>
                            </tr>
                            <tr>
                                <th>Dernière mise à jour:</th>
                                <td>18/06/2023 09:15</td>
                            </tr>
                            <tr>
                                <th>Statut:</th>
                                <td><span class="badge bg-primary">En cours</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Utilisateur</h6>
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/user-1.jpg') }}" class="rounded-circle me-2" width="50" height="50">
                            <div>
                                <h6 class="mb-0">Sophie Martin</h6>
                                <small class="text-muted">sophie.martin@email.com</small>
                            </div>
                        </div>
                        <p><strong>Téléphone:</strong> +33 6 12 34 56 78</p>
                        <p><strong>Adresse:</strong> 123 Rue de Paris, 75001 Paris</p>
                    </div>
                </div>

                <h6 class="text-muted mb-3">Livres échangés</h6>
                <div class="row mb-4">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Livre proposé</h6>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('assets/images/book-cover-1.jpg') }}" class="me-3" style="width: 80px; height: 120px; object-fit: cover;">
                                    <div>
                                        <h5 class="mb-1">Le Nom du Vent</h5>
                                        <p class="mb-1">Patrick Rothfuss</p>
                                        <p class="mb-1"><small>ISBN: 978-2-253-16383-8</small></p>
                                        <span class="badge bg-success">Excellent état</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-exchange-alt fa-3x text-primary"></i>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Livre demandé</h6>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('assets/images/book-cover-2.jpg') }}" class="me-3" style="width: 80px; height: 120px; object-fit: cover;">
                                    <div>
                                        <h5 class="mb-1">La Peur du Sage</h5>
                                        <p class="mb-1">Patrick Rothfuss</p>
                                        <p class="mb-1"><small>ISBN: 978-2-253-16384-5</small></p>
                                        <span class="badge bg-warning">Bon état</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="text-muted mb-3">Historique de l'échange</h6>
                <div class="timeline mb-4">
                    <div class="timeline-item">
                        <div class="timeline-item-date">15/06/2023 14:30</div>
                        <div class="timeline-item-content">
                            <div class="timeline-item-title">Demande d'échange créée</div>
                            <div class="timeline-item-text">Sophie Martin a proposé un échange</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-item-date">16/06/2023 10:15</div>
                        <div class="timeline-item-content">
                            <div class="timeline-item-title">Échange approuvé</div>
                            <div class="timeline-item-text">L'administrateur a approuvé la demande d'échange</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-item-date">18/06/2023 09:15</div>
                        <div class="timeline-item-content">
                            <div class="timeline-item-title">Livraison en cours</div>
                            <div class="timeline-item-text">Les livres sont en cours d'acheminement</div>
                        </div>
                    </div>
                </div>

                <h6 class="text-muted mb-3">Notes et commentaires</h6>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">L'utilisateur a demandé une livraison express. Prévoir un emballage renforcé pour le livre "La Peur du Sage" qui est une édition collector.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Mettre à jour le statut</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'exportation -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Exporter les données d'échanges</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Format d'exportation</label>
                        <select class="form-select">
                            <option value="csv">CSV</option>
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Période</label>
                        <div class="input-group">
                            <input type="date" class="form-control" placeholder="Date de début">
                            <span class="input-group-text">au</span>
                            <input type="date" class="form-control" placeholder="Date de fin">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Données à inclure</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="includeUserInfo" checked>
                            <label class="form-check-label" for="includeUserInfo">
                                Informations utilisateur
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="includeBookDetails" checked>
                            <label class="form-check-label" for="includeBookDetails">
                                Détails des livres
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="includeExchangeHistory" checked>
                            <label class="form-check-label" for="includeExchangeHistory">
                                Historique des échanges
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Exporter</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtrage des échanges par statut
        const filterButtons = document.querySelectorAll('.exchange-filter-btn');
        const exchangeItems = document.querySelectorAll('.exchange-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Mise à jour des boutons actifs
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filtrage des éléments
                exchangeItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-status') === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Activation des checkboxes pour les actions groupées
        const confirmDeleteCheckboxes = document.querySelectorAll('[id^="confirmDelete"]');
        confirmDeleteCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const deleteBtn = document.getElementById('deleteBtn' + this.id.replace('confirmDelete', ''));
                deleteBtn.disabled = !this.checked;
            });
        });
    });
</script>
@endpush
@extends('layouts.admin')

@section('title', 'Gestion des commandes')

@push('styles')
<style>
    body {
        background-color: #f8f9fa; /* Light gray background for a modern feel */
    }
    .order-card {
        transition: all 0.2s;
        border-radius: 10px;
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .status-pending {
        background-color: #ebf8ff;
        color: #3182ce;
    }
    .status-processing {
        background-color: #fef5e7;
        color: #f39c12;
    }
    .status-shipped {
        background-color: #e6fffa;
        color: #38b2ac;
    }
    .status-delivered {
        background-color: #f0fff4;
        color: #38a169;
    }
    .status-cancelled {
        background-color: #fff5f5;
        color: #e53e3e;
    }
    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- En-tête avec boutons d'action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Gestion des commandes</h4>
            <p class="text-muted">Suivez et gérez les commandes de vos clients</p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-secondary me-2">
                <i class="fas fa-file-export me-2"></i>Exporter
            </button>
            <button type="button" class="btn btn-outline-primary">
                <i class="fas fa-print me-2"></i>Imprimer
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Statistiques des commandes -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total commandes</h6>
                            <h4 class="mb-0">1,248</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">En attente</h6>
                            <h4 class="mb-0">42</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Livrées</h6>
                            <h4 class="mb-0">968</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Annulées</h6>
                            <h4 class="mb-0">24</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Filtres et recherche -->
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-dark"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control border-0 bg-light text-dark" placeholder="Rechercher une commande...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select border-0 bg-light text-dark">
                                <option value="">Tous les statuts</option>
                                <option value="pending">En attente</option>
                                <option value="processing">En traitement</option>
                                <option value="shipped">Expédiée</option>
                                <option value="delivered">Livrée</option>
                                <option value="cancelled">Annulée</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select border-0 bg-light text-dark">
                                <option value="">Toutes les périodes</option>
                                <option value="today">Aujourd'hui</option>
                                <option value="week">Cette semaine</option>
                                <option value="month">Ce mois</option>
                                <option value="year">Cette année</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select border-0 bg-light text-dark">
                                <option value="">Tous les paiements</option>
                                <option value="card">Carte bancaire</option>
                                <option value="paypal">PayPal</option>
                                <option value="transfer">Virement</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-dark"><i class="fas fa-calendar"></i></span>
                                <input type="text" class="form-control border-0 bg-light text-dark" placeholder="Date">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100">Filtrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des commandes -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Liste des commandes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th width="10%" class="text-dark">Commande</th>
                                    <th width="20%" class="text-dark">Client</th>
                                    <th width="15%" class="text-dark">Date</th>
                                    <th width="10%" class="text-dark">Total</th>
                                    <th width="15%" class="text-dark">Statut</th>
                                    <th width="10%" class="text-dark">Paiement</th>
                                    <th width="15%" class="text-dark">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td><a href="#" class="text-decoration-none text-dark">#ORD-7352</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/128" alt="Customer" class="customer-avatar me-3">
                                            <div>
                                                <div class="fw-semibold text-dark">Sophie Martin</div>
                                                <div class="small text-muted text-dark">sophie.martin@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark">12 Mai 2023</div>
                                        <div class="small text-muted text-dark">14:23</div>
                                    </td>
                                    <td><span class="fw-semibold text-dark">89,90 €</span></td>
                                    <td><span class="status-badge status-delivered text-dark">Livrée</span></td>
                                    <td><span class="badge bg-light text-dark">Carte bancaire</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Modifier</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-truck me-2"></i>Suivi</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Supprimer</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td><a href="#" class="text-decoration-none text-dark">#ORD-7351</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/128" alt="Customer" class="customer-avatar me-3">
                                            <div>
                                                <div class="fw-semibold text-dark">Thomas Dubois</div>
                                                <div class="small text-muted text-dark">thomas.dubois@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark">12 Mai 2023</div>
                                        <div class="small text-muted text-dark">10:45</div>
                                    </td>
                                    <td><span class="fw-semibold text-dark">124,50 €</span></td>
                                    <td><span class="status-badge status-processing text-dark">En traitement</span></td>
                                    <td><span class="badge bg-light text-dark">PayPal</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Modifier</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-truck me-2"></i>Suivi</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Supprimer</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td><a href="#" class="text-decoration-none text-dark">#ORD-7350</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/128" alt="Customer" class="customer-avatar me-3">
                                            <div>
                                                <div class="fw-semibold text-dark">Julie Leroy</div>
                                                <div class="small text-muted text-dark">julie.leroy@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark">11 Mai 2023</div>
                                        <div class="small text-muted text-dark">16:32</div>
                                    </td>
                                    <td><span class="fw-semibold text-dark">56,80 €</span></td>
                                    <td><span class="status-badge status-shipped text-dark">Expédiée</span></td>
                                    <td><span class="badge bg-light text-dark">Carte bancaire</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Modifier</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-truck me-2"></i>Suivi</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Supprimer</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Affichage de <strong>1-3</strong> sur <strong>248</strong> commandes</div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Précédent</a>
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails Commande -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Détails de la commande #ORD-7352</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Produits commandés</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://via.placeholder.com/120x160" alt="Product" class="me-3" style="width: 50px; height: 65px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Les Misérables</h6>
                                        <small class="text-muted">Victor Hugo</small>
                                    </div>
                                    <div class="text-end">
                                        <div>24,90 €</div>
                                        <small class="text-muted">Qté: 1</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://via.placeholder.com/120x160" alt="Product" class="me-3" style="width: 50px; height: 65px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">L'Étranger</h6>
                                        <small class="text-muted">Albert Camus</small>
                                    </div>
                                    <div class="text-end">
                                        <div>12,50 €</div>
                                        <small class="text-muted">Qté: 1</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/120x160" alt="Product" class="me-3" style="width: 50px; height: 65px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Le Petit Prince</h6>
                                        <small class="text-muted">Antoine de Saint-Exupéry</small>
                                    </div>
                                    <div class="text-end">
                                        <div>9,90 €</div>
                                        <small class="text-muted">Qté: 1</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="d-flex justify-content-between">
                                    <span>Sous-total:</span>
                                    <span>47,30 €</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Livraison:</span>
                                    <span>4,90 €</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>TVA (20%):</span>
                                    <span>8,70 €</span>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="fw-bold">Total:</span>
                                    <span class="fw-bold">89,90 €</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Informations client</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <img src="https://via.placeholder.com/128" alt="Customer" class="rounded-circle" width="80">
                                    <h6 class="mt-2 mb-0">Sophie Martin</h6>
                                    <p class="text-muted small">Client depuis Jan 2023</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><i class="fas fa-envelope text-muted me-2"></i> sophie.martin@example.com</p>
                                    <p class="mb-1"><i class="fas fa-phone text-muted me-2"></i> +33 6 12 34 56 78</p>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Adresse de livraison</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-1">Sophie Martin</p>
                                <p class="mb-1">12 rue des Lilas</p>
                                <p class="mb-1">75011 Paris</p>
                                <p class="mb-0">France</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Suivi de commande -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Suivi de commande</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="d-flex mb-4">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0">Commande livrée</h6>
                                        <small class="text-muted">14 Mai 2023, 11:32</small>
                                    </div>
                                    <p class="text-muted mb-0">La commande a été livrée avec succès</p>
                                </div>
                            </li>
                            <li class="d-flex mb-4">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0">Commande expédiée</h6>
                                        <small class="text-muted">13 Mai 2023, 09:15</small>
                                    </div>
                                    <p class="text-muted mb-0">La commande a été remise au transporteur</p>
                                    <div class="bg-light p-2 mt-2 rounded">
                                        <small>Numéro de suivi: <strong>LP00358924FR</strong></small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0">Commande préparée</h6>
                                        <small class="text-muted">12 Mai 2023, 16:40</small>
                                    </div>
                                    <p class="text-muted mb-0">La commande a été préparée et emballée</p>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0">Paiement confirmé</h6>
                                        <small class="text-muted">12 Mai 2023, 14:25</small>
                                    </div>
                                    <p class="text-muted mb-0">Le paiement par carte bancaire a été validé</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Imprimer la facture
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Sélectionner/désélectionner toutes les commandes
        $('#selectAll').on('change', function() {
            $('tbody .form-check-input').prop('checked', $(this).is(':checked'));
        });
        
        // Initialisation des tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
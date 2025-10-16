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
    /* Amélioration CSS des filtres */
    .order-filters .form-control,
    .order-filters .form-select {
        color: #000;
        background-color: #f8f9fa;
        border: none;
        border-radius: 8px;
        height: 44px;
    }
    .order-filters .form-control:focus,
    .order-filters .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
        border: none;
        color: #000;
        background-color: #fff;
    }
    .order-filters .input-group {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f8f9fa;
    }
    .order-filters .input-group-text {
        color: #000;
        background-color: #f8f9fa;
        border: none;
    }
    .filters-row > [class*="col-"] {
        display: flex;
        align-items: center;
    }
    .order-filters .form-control::placeholder { color: #6c757d; }
    .order-filters .btn-primary { height: 44px; border-radius: 8px; }
    .filters-row .col-md-3,
    .filters-row .col-md-2,
    .filters-row .col-md-1 {
        display: flex;
        align-items: center;
    }
    /* Texte noir dans le modal */
    .modal-body p,
    .modal-body h6,
    .modal-title,
    .modal-body strong {
        color: #000 !important;
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
                            <h4 class="mb-0">{{ $orders->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($orders->where('payment_status', 'pending')->count() > 0)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">En attente</h6>
                            <h4 class="mb-0">{{ $orders->where('payment_status', 'pending')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Livrées</h6>
                            <h4 class="mb-0">{{ $orders->where('payment_status', 'completed')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($orders->where('payment_status', 'cancelled')->count() > 0)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Annulées</h6>
                            <h4 class="mb-0">{{ $orders->where('payment_status', 'cancelled')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row">
        <!-- Filtres et recherche -->
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body order-filters">
                    <form method="GET" action="{{ route('admin.orders') }}">
                        <div class="row g-3 filters-row">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-dark"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 bg-light text-dark" placeholder="Rechercher par email, nom, titre ou ID">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="period" class="form-select border-0 bg-light text-dark">
                                    <option value="today" {{ request('period')==='today' ? 'selected' : '' }}>Aujourd'hui</option>
                                    <option value="week" {{ request('period')==='week' ? 'selected' : '' }}>Cette semaine</option>
                                    <option value="month" {{ request('period')==='month' ? 'selected' : '' }}>Ce mois</option>
                                    <option value="year" {{ request('period')==='year' ? 'selected' : '' }}>Cette année</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="date" name="date" value="{{ request('date') }}" class="form-control border-0 bg-light text-dark" placeholder="Date">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                            </div>
                        </div>
                    </form>
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
                                    <th width="15%" class="text-dark">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td><a href="#" class="text-decoration-none text-dark">#ORD-{{ $order->id }}</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!-- Image client supprimée -->
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $order->user->name }}</div>
                                                <div class="small text-muted text-dark">{{ $order->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark">{{ $order->transaction_date->format('d M Y') }}</div>
                                        <div class="small text-muted text-dark">{{ $order->transaction_date->format('H:i') }}</div>
                                    </td>
                                    <td><span class="fw-semibold text-dark">{{ number_format($order->price * $order->quantity, 2) }} €</span></td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            switch($order->payment_status) {
                                                case 'pending':
                                                    $statusClass = 'status-pending';
                                                    break;
                                                case 'processing':
                                                    $statusClass = 'status-processing';
                                                    break;
                                                case 'shipped':
                                                    $statusClass = 'status-shipped';
                                                    break;
                                                case 'delivered':
                                                    $statusClass = 'status-delivered';
                                                    break;
                                                case 'completed':
                                                    $statusClass = 'status-delivered';
                                                    break;
                                                case 'cancelled':
                                                    $statusClass = 'status-cancelled';
                                                    break;
                                                default:
                                                    $statusClass = 'status-pending';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }} text-dark">{{ ucfirst($order->payment_status) }}</span>
                                    </td>
                                    <td>
                                        <button type="button" id="orderViewBtn-{{ $order->id }}" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#orderDetailsModal-{{ $order->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Affichage de <strong>1-{{ $orders->count() }}</strong> sur <strong>{{ $orders->count() }}</strong> commandes</div>
                        <nav>
                            <ul class="pagination mb-0">
                                {{-- Pagination links can be added here if using paginate() in controller --}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails Commande -->
@foreach($orders as $order)
<div class="modal fade" id="orderDetailsModal-{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailsModalLabel-{{ $order->id }}" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel-{{ $order->id }}">Détails de la commande #ORD-{{ $order->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations client</h6>
                        <p><strong>Nom:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Détails de la commande</h6>
                        <p><strong>Date:</strong> {{ $order->transaction_date->format('d M Y H:i') }}</p>
                        @php
                            $statusClass = '';
                            switch($order->payment_status) {
                                case 'pending':
                                    $statusClass = 'status-pending';
                                    break;
                                case 'processing':
                                    $statusClass = 'status-processing';
                                    break;
                                case 'shipped':
                                    $statusClass = 'status-shipped';
                                    break;
                                case 'delivered':
                                    $statusClass = 'status-delivered';
                                    break;
                                case 'completed':
                                    $statusClass = 'status-delivered';
                                    break;
                                case 'cancelled':
                                    $statusClass = 'status-cancelled';
                                    break;
                                default:
                                    $statusClass = 'status-pending';
                            }
                        @endphp
                        <p><strong>Statut:</strong> <span class="status-badge {{ $statusClass }} text-dark">{{ ucfirst($order->payment_status) }}</span></p>
                        <p><strong>Paiement:</strong> PayPal</p>
                    </div>
                </div>
                <hr>
                <h6>Articles commandés</h6>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $order->book->title }}</strong>
                            <br>
                            <small>Quantité: {{ $order->quantity }}</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ number_format($order->price * $order->quantity, 2) }} €</span>
                    </li>
                </ul>
                <div class="text-end">
                    <h5>Total: {{ number_format($order->price * $order->quantity, 2) }} €</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endforeach

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

        // Gestion du focus et de l'attribut inert pour les modals afin d'éviter aria-hidden avec un descendant focus
        document.querySelectorAll('.modal').forEach(function(modalEl) {
            var $modal = $(modalEl);
            $modal.on('show.bs.modal', function(e) {
                var trigger = e.relatedTarget;
                // Retirer inert à l'ouverture
                modalEl.removeAttribute('inert');
                if (trigger) {
                    $modal.data('returnFocus', trigger);
                }
            });
            // Nouveau: s'assurer qu'aucun élément à l'intérieur du modal ne garde le focus AVANT que aria-hidden ne soit appliqué
            $modal.on('hide.bs.modal', function() {
                var active = document.activeElement;
                if (active && modalEl.contains(active)) {
                    active.blur();
                }
            });
            $modal.on('hidden.bs.modal', function() {
                // Si un élément garde le focus dans le modal, le retirer
                var focused = modalEl.querySelector(':focus');
                if (focused) { focused.blur(); }
                // Empêcher la prise de focus sur le modal caché
                modalEl.setAttribute('inert', '');
                // Restaurer le focus sur le bouton déclencheur
                var trigger = $modal.data('returnFocus');
                if (trigger && typeof trigger.focus === 'function') {
                    trigger.focus();
                }
            });
        });
    });
</script>
@endpush
@endsection
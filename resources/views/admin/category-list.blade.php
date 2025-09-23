@extends('layouts.admin')

@section('title', 'Gestion des catégories')

@push('styles')
<style>
    body {
        background-color: #f8f9fa; /* Light gray background for a modern feel */
    }
    .category-card {
        border-radius: 12px; /* Slightly larger border-radius for a softer look */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); /* More pronounced, softer shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effects */
        margin-bottom: 20px;
        border: none; /* Remove default border */
    }
    .category-card:hover {
        transform: translateY(-7px); /* More noticeable lift on hover */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12); /* Enhanced shadow on hover */
    }
    .category-icon {
        width: 55px; /* Slightly larger icon */
        height: 55px;
        border-radius: 12px; /* Match card border-radius */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px; /* Slightly larger icon font size */
        margin-right: 15px;
        color: #fff; /* Ensure icon color is white for contrast */
    }
    .category-count {
        font-size: 13px; /* Slightly smaller font size for count */
        color: #6c757d;
        font-weight: 500; /* Added font-weight for better readability */
    }
    .action-btn {
        width: 36px; /* Slightly larger action buttons */
        height: 36px;
        border-radius: 8px; /* Softer border-radius for buttons */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px; /* Increased margin for better spacing */
        transition: all 0.2s ease;
        background-color: #f1f3f5; /* Light background for action buttons */
        color: #495057; /* Darker color for icons */
        border: none; /* Remove default button border */
    }
    .action-btn:hover {
        transform: translateY(-3px); /* Slight lift on hover */
        background-color: #e2e6ea; /* Slightly darker background on hover */
        color: #212529;
    }
    .category-form {
        border-radius: 12px; /* Match card border-radius */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        border: none;
    }
    .color-preview {
        width: 35px; /* Slightly larger color preview */
        height: 35px;
        border-radius: 8px; /* Match button border-radius */
        display: inline-block;
        margin-right: 10px;
        vertical-align: middle;
        border: 1px solid rgba(0, 0, 0, 0.1); /* Added subtle border */
    }
    .drag-handle {
        cursor: grab; /* Changed to grab cursor */
        color: #adb5bd;
        font-size: 18px; /* Slightly larger drag handle icon */
    }
    /* General form control improvements */
    .form-control, .form-select {
        border-radius: 8px;
        border-color: #ced4da;
        padding: 10px 15px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
    .input-group-text {
        border-radius: 8px 0 0 8px;
        border-color: #ced4da;
        background-color: #e9ecef;
        color: #495057;
    }
    .input-group-text i {
        color: #6c757d;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .btn-outline-secondary {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }
    .card-header {
        border-bottom: 1px solid #e9ecef;
        background-color: #fff;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    .card-footer {
        border-top: 1px solid #e9ecef;
        background-color: #fff;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .pagination .page-link {
        border-radius: 8px;
        margin: 0 4px;
        color: #007bff;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }
    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0056b3;
    }
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .modal-header {
        border-bottom: 1px solid #e9ecef;
        padding: 15px 20px;
    }
    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 15px 20px;
    }
    .badge {
        padding: 0.5em 0.75em;
        border-radius: 6px;
        font-weight: 600;
    }
    .progress {
        height: 8px; /* Slightly thicker progress bar */
        border-radius: 4px;
        background-color: #e9ecef;
    }
    .progress-bar {
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- En-tête avec boutons d'action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Gestion des catégories</h4>
            <p class="text-muted mb-0">Gérez les catégories de livres de votre catalogue</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus me-2"></i>
                Ajouter une catégorie
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2 d-inline-flex align-items-center" id="bulkActionsBtn">
                <i class="fas fa-cog me-2"></i>
                Actions groupées
            </button>
        </div>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="card mb-4 border-0 shadow-sm rounded-3">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-dark rounded-start-3">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 text-dark rounded-end-3" id="searchCategory" placeholder="Rechercher une catégorie...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select text-dark rounded-3" id="filterStatus">
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select text-dark rounded-3" id="sortCategories">
                        <option value="name_asc">Nom (A-Z)</option>
                        <option value="name_desc">Nom (Z-A)</option>
                        <option value="books_count">Nombre de livres</option>
                        <option value="date_created">Date de création</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-primary w-100 rounded-3" id="resetFilters">
                        <i class="fas fa-redo-alt me-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Formulaire d'ajout/modification de catégorie -->
        <div class="col-lg-4 mb-4">
            <div class="card category-form h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Ajouter une catégorie</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Nom de la catégorie</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Ex: Science Fiction">
                        </div>
                        <div class="mb-3">
                            <label for="categorySlug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="categorySlug" placeholder="Ex: science-fiction">
                            <small class="text-muted">Utilisé dans les URLs (généré automatiquement)</small>
                        </div>
                        <div class="mb-3">
                            <label for="categoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" rows="3" placeholder="Description de la catégorie..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="categoryIcon" class="form-label">Icône</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                                <select class="form-select" id="categoryIcon">
                                    <option value="book">Livre (book)</option>
                                    <option value="bookmark">Marque-page (bookmark)</option>
                                    <option value="glasses">Lunettes (glasses)</option>
                                    <option value="graduation-cap">Diplôme (graduation-cap)</option>
                                    <option value="atlas">Atlas (atlas)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="categoryColor" class="form-label">Couleur</label>
                            <div class="input-group">
                                <span class="input-group-text p-1">
                                    <span class="color-preview" style="background-color: #4e73df;"></span>
                                </span>
                                <input type="text" class="form-control" id="categoryColor" value="#4e73df">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="categoryParent" class="form-label">Catégorie parente</label>
                            <select class="form-select" id="categoryParent">
                                <option value="">Aucune (catégorie principale)</option>
                                <option value="1">Romans</option>
                                <option value="2">Sciences</option>
                                <option value="3">Histoire</option>
                            </select>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="categoryActive" checked>
                            <label class="form-check-label" for="categoryActive">Catégorie active</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des catégories -->
        <div class="col-lg-8">
            <!-- Statistiques des catégories -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-layer-group fa-2x"></i>
                            </div>
                            <h3 class="fw-bold mb-1">12</h3>
                            <p class="text-muted mb-0">Catégories actives</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                            <h3 class="fw-bold mb-1">318</h3>
                            <p class="text-muted mb-0">Livres classés</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-star fa-2x"></i>
                            </div>
                            <h3 class="fw-bold mb-1">4.8</h3>
                            <p class="text-muted mb-0">Note moyenne</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex align-items-center">
                    <h5 class="mb-0">Toutes les catégories</h5>
                    <div class="ms-auto">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary active">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" id="categoryList">
                        @foreach($categories as $cat)
                        <div class="col-md-4 category-item" data-name="{{ $cat['name'] }}" data-status="{{ $cat['status'] }}" data-date="{{ $cat['created_at'] }}" data-books="{{ $cat['books_count'] }}">
                            <div class="card category-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="category-icon" @style([
                                                'background-color' => $cat['color']
                                            ])>
                                                <i class="{{ $cat['icon'] }} text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-0 text-dark">{{ $cat['name'] }}</h5>
                                                <span class="category-count text-dark">{{ $cat['books_count'] }} livres</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="dropdown">
                                                <button class="action-btn btn-light" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2 text-primary"></i>Modifier</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2 text-info"></i>Voir les livres</a></li>
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#statsModal{{ $cat['id'] }}"><i class="fas fa-chart-bar me-2 text-success"></i>Statistiques</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Supprimer</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-2">Romans contemporains, historiques et d'aventure.</p>
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-{{ $cat['status'] == 'active' ? 'success' : 'danger' }}-subtle text-{{ $cat['status'] == 'active' ? 'success' : 'danger' }}">{{ $cat['status'] == 'active' ? 'Actif' : 'Inactif' }}</span>
                                        <small class="text-muted text-dark">Dernière mise à jour: {{ $cat['created_at'] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white border-top py-3">
                    <nav aria-label="Pagination des catégories">
                        <ul class="pagination justify-content-center mb-0">
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
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter Catégorie -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Ajouter une nouvelle catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="modalCategoryName" class="form-label">Nom de la catégorie</label>
                        <input type="text" class="form-control" id="modalCategoryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalCategoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="modalCategoryDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="modalCategoryIcon" class="form-label">Icône</label>
                        <select class="form-select" id="modalCategoryIcon">
                            <option value="book">Livre</option>
                            <option value="bookmark">Marque-page</option>
                            <option value="glasses">Lunettes</option>
                            <option value="graduation-cap">Diplôme</option>
                            <option value="atlas">Atlas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modalCategoryColor" class="form-label">Couleur</label>
                        <input type="color" class="form-control form-control-color" id="modalCategoryColor" value="#4e73df">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal d'actions groupées -->
<div class="modal fade" id="bulkActionsModal" tabindex="-1" aria-labelledby="bulkActionsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkActionsModalLabel">Actions groupées</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary"><i class="fas fa-toggle-on me-2"></i>Activer les catégories sélectionnées</button>
                    <button class="btn btn-outline-warning"><i class="fas fa-toggle-off me-2"></i>Désactiver les catégories sélectionnées</button>
                    <button class="btn btn-outline-danger"><i class="fas fa-trash me-2"></i>Supprimer les catégories sélectionnées</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour les options avancées de gestion des catégories -->
<!-- Ces modals seraient générés dynamiquement pour chaque catégorie dans une boucle -->

<!-- Modals pour les options avancées de gestion des catégories -->
@foreach($categories as $cat)
<!-- Modal de statistiques -->
<div class="modal fade" id="statsModal{{ $cat['id'] }}" tabindex="-1" aria-labelledby="statsModalLabel{{ $cat['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statsModalLabel{{ $cat['id'] }}">Statistiques - {{ $cat['name'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenu des statistiques -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="card-title">Répartition des ventes</h6>
                                <canvas id="salesChart{{ $cat['id'] }}" width="400" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="card-title">Évolution mensuelle</h6>
                                <canvas id="monthlyChart{{ $cat['id'] }}" width="400" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Livres les plus populaires</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Titre</th>
                                                <th>Auteur</th>
                                                <th>Ventes</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Le Silence des Agneaux</td>
                                                <td>Thomas Harris</td>
                                                <td>245</td>
                                                <td>4.8/5</td>
                                            </tr>
                                            <tr>
                                                <td>Misery</td>
                                                <td>Stephen King</td>
                                                <td>198</td>
                                                <td>4.6/5</td>
                                            </tr>
                                            <tr>
                                                <td>Gone Girl</td>
                                                <td>Gillian Flynn</td>
                                                <td>176</td>
                                                <td>4.5/5</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Exporter les données</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de fusion de catégories -->
<div class="modal fade" id="mergeCategoryModal{{ $cat['id'] }}" tabindex="-1" aria-labelledby="mergeCategoryModalLabel{{ $cat['id'] }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mergeCategoryModalLabel{{ $cat['id'] }}">Fusionner la catégorie {{ $cat['name'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Attention : La fusion de catégories est irréversible.</p>
                <form>
                    <div class="mb-3">
                        <label for="targetCategory{{ $cat['id'] }}" class="form-label">Fusionner avec la catégorie :</label>
                        <select class="form-select" id="targetCategory{{ $cat['id'] }}" required>
                            <option value="" selected disabled>Sélectionner une catégorie</option>
                            @foreach($categories as $targetCat)
                                @if($targetCat['id'] != $cat['id'])
                                    <option value="{{ $targetCat['id'] }}">{{ $targetCat['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Options de fusion :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="transferBooks{{ $cat['id'] }}" checked>
                            <label class="form-check-label" for="transferBooks{{ $cat['id'] }}">
                                Transférer tous les livres
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="keepRedirect{{ $cat['id'] }}" checked>
                            <label class="form-check-label" for="keepRedirect{{ $cat['id'] }}">
                                Créer une redirection automatique
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Fusionner</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de changement de statut -->
<div class="modal fade" id="changeStatusModal{{ $cat['id'] }}" tabindex="-1" aria-labelledby="changeStatusModalLabel{{ $cat['id'] }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel{{ $cat['id'] }}">Changer le statut de {{ $cat['name'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="categoryStatus{{ $cat['id'] }}" class="form-label">Nouveau statut :</label>
                        <select class="form-select" id="categoryStatus{{ $cat['id'] }}" required>
                            <option value="active" {{ $cat['status'] == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ $cat['status'] == 'inactive' ? 'selected' : '' }}>Inactif</option>
                            <option value="featured" {{ $cat['status'] == 'featured' ? 'selected' : '' }}>Mis en avant</option>
                            <option value="archived" {{ $cat['status'] == 'archived' ? 'selected' : '' }}>Archivé</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="statusNote{{ $cat['id'] }}" class="form-label">Note (optionnelle) :</label>
                        <textarea class="form-control" id="statusNote{{ $cat['id'] }}" rows="3" placeholder="Raison du changement de statut..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de visualisation des livres -->
<div class="modal fade" id="viewBooksModal{{ $cat['id'] }}" tabindex="-1" aria-labelledby="viewBooksModalLabel{{ $cat['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBooksModalLabel{{ $cat['id'] }}">Livres de la catégorie {{ $cat['name'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Rechercher un livre..." aria-label="Rechercher un livre">
                    <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Livres de démonstration pour la catégorie -->
                            <tr>
                                <td>Le Nom du Vent</td>
                                <td>Patrick Rothfuss</td>
                                <td><span class="badge bg-success">Disponible</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>La Peur du Sage</td>
                                <td>Patrick Rothfuss</td>
                                <td><span class="badge bg-warning">En échange</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Le Trône de Fer</td>
                                <td>George R.R. Martin</td>
                                <td><span class="badge bg-success">Disponible</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pencil"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Ajouter un livre</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteCategoryModal{{ $cat['id'] }}" tabindex="-1" aria-labelledby="deleteCategoryModalLabel{{ $cat['id'] }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel{{ $cat['id'] }}">Supprimer la catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Attention : Cette action est irréversible.</p>
                <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong>{{ $cat['name'] }}</strong> ?</p>
                <p>Cette catégorie contient <strong>{{ $cat['books_count'] ?? 0 }}</strong> livres.</p>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="confirmDelete{{ $cat['id'] }}">
                    <label class="form-check-label" for="confirmDelete{{ $cat['id'] }}">
                        Je comprends que cette action est irréversible
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" disabled id="deleteBtn{{ $cat['id'] }}">Supprimer définitivement</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal d'actions groupées -->
<div class="modal fade" id="bulkActionsModal" tabindex="-1" aria-labelledby="bulkActionsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkActionsModalLabel">Actions groupées</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary"><i class="fas fa-toggle-on me-2"></i>Activer les catégories sélectionnées</button>
                    <button class="btn btn-outline-warning"><i class="fas fa-toggle-off me-2"></i>Désactiver les catégories sélectionnées</button>
                    <button class="btn btn-outline-danger"><i class="fas fa-trash me-2"></i>Supprimer les catégories sélectionnées</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialisation des tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Génération automatique du slug
        $('#categoryName').on('keyup', function() {
            let slug = $(this).val()
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            $('#categorySlug').val(slug);
        });
        
        // Mise à jour de la prévisualisation de couleur
        $('#categoryColor').on('input', function() {
            $(this).prev('.input-group-text').find('.color-preview').css('background-color', $(this).val());
        });
        
        // Recherche et filtrage des catégories
        $('#searchCategory').on('input', function() {
            filterCategories();
        });
        
        $('#filterStatus').on('change', function() {
            filterCategories();
        });
        
        $('#sortCategories').on('change', function() {
            sortCategories();
        });
        
        $('#resetFilters').on('click', function() {
            $('#searchCategory').val('');
            $('#filterStatus').val('');
            $('#sortCategories').val('name_asc');
            filterCategories();
            sortCategories();
        });
        
        function filterCategories() {
            const searchTerm = $('#searchCategory').val().toLowerCase();
            const statusFilter = $('#filterStatus').val();
            
            $('.category-card').each(function() {
                const card = $(this);
                const categoryName = card.find('h5').text().toLowerCase();
                const categoryStatus = card.find('.badge').text().toLowerCase();
                
                const matchesSearch = categoryName.includes(searchTerm);
                const matchesStatus = statusFilter === '' || categoryStatus === statusFilter;
                
                if (matchesSearch && matchesStatus) {
                    card.closest('.col-md-6').show();
                } else {
                    card.closest('.col-md-6').hide();
                }
            });
        }
        
        function sortCategories() {
            const sortOption = $('#sortCategories').val();
            const categoryContainer = $('.card-body .row');
            const categoryItems = categoryContainer.children('.col-md-6').get();
            
            categoryItems.sort(function(a, b) {
                const nameA = $(a).find('h5').text();
                const nameB = $(b).find('h5').text();
                const countA = parseInt($(a).find('.category-count').text());
                const countB = parseInt($(b).find('.category-count').text());
                const dateA = $(a).find('small.text-muted').text();
                const dateB = $(b).find('small.text-muted').text();
                
                switch(sortOption) {
                    case 'name_asc':
                        return nameA.localeCompare(nameB);
                    case 'name_desc':
                        return nameB.localeCompare(nameA);
                    case 'books_count':
                        return countB - countA;
                    case 'date_created':
                        return new Date(dateB.split(': ')[1]) - new Date(dateA.split(': ')[1]);
                    default:
                        return 0;
                }
            });
            
            // Réinsérer les éléments triés
            $.each(categoryItems, function(i, item) {
                categoryContainer.append(item);
            });
        }
        
        // Gestion des actions groupées
        $('#bulkActionsBtn').on('click', function() {
            $('#bulkActionsModal').modal('show');
        });
    });
</script>
@endpush
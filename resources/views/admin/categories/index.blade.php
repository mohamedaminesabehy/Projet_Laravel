@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@push('styles')
<style>
    .admin-header {
        background: linear-gradient(135deg, #2E4A5B 0%, #D16655 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #D16655;
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .category-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .category-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .category-body {
        padding: 1.5rem;
    }
    
    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 1rem;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .status-active {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
    }
    
    .status-inactive {
        background: linear-gradient(45deg, #dc3545, #fd7e14);
        color: white;
    }
    
    .action-btn {
        border: none;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-view {
        background: linear-gradient(135deg, #2E4A5B, #3a5a6e);
        color: white;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #D16655, #e07565);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #BD7579, #d18689);
        color: white;
    }
    
    .btn-toggle {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        color: white;
    }
    
    .search-box {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }
    
    .filter-form .form-control,
    .filter-form .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .filter-form .form-control:focus,
    .filter-form .form-select:focus {
        border-color: #D16655;
        box-shadow: 0 0 0 0.2rem rgba(209, 102, 85, 0.25);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    /* Modal de suppression personnalisé */
    .custom-delete-modal {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        transform: scale(0.95);
        animation: modalFadeIn 0.3s ease-out forwards;
    }
    
    @keyframes modalFadeIn {
        to { transform: scale(1); }
    }
    
    .custom-delete-modal-header {
        background: linear-gradient(135deg, #2E4A5B 0%, #D16655 100%);
        color: white;
        border: none;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .custom-delete-modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
    }
    
    .delete-icon-warning {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2rem;
        animation: pulse-warning 2s ease-in-out infinite;
    }
    
    @keyframes pulse-warning {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .custom-delete-modal-body {
        padding: 2rem;
        background: #F8EBE5;
    }
    
    .category-name-highlight {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        border-left: 4px solid #D16655;
        font-weight: 600;
        color: #2E4A5B;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .warning-delete-box {
        background: rgba(189, 117, 121, 0.1);
        padding: 0.75rem;
        border-radius: 8px;
        color: #BD7579;
        border: 1px solid rgba(189, 117, 121, 0.2);
    }
    
    .custom-delete-modal-footer {
        background: white;
        border: none;
        padding: 1.5rem 2rem;
        gap: 1rem;
    }
    
    .btn-cancel-delete {
        background: linear-gradient(135deg, #6c757d, #8a9ba8);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        min-width: 120px;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.2);
    }
    
    .btn-cancel-delete:hover {
        color: white;
        background: linear-gradient(135deg, #2E4A5B, #5a6c7a);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 74, 91, 0.4);
    }
    
    .btn-delete-confirm {
        background: linear-gradient(135deg, #D16655, #e8755f);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        min-width: 120px;
        box-shadow: 0 4px 15px rgba(209, 102, 85, 0.3);
    }
    }
    
    .btn-delete-confirm:hover {
        color: white;
        background: linear-gradient(135deg, #c55441, #D16655);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(197, 84, 65, 0.5);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête Admin -->
    <div class="admin-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-tags me-3"></i>Gestion des Catégories
                </h1>
                <p class="mb-0 opacity-90">Gérez les catégories de livres de votre plateforme</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus me-2"></i>Nouvelle Catégorie
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-tags text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $categories->total() }}</h3>
                        <small class="text-muted">Total Catégories</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $categories->where('is_active', true)->count() }}</h3>
                        <small class="text-muted">Actives</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-pause-circle text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $categories->where('is_active', false)->count() }}</h3>
                        <small class="text-muted">Inactives</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-user text-info" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                        <small class="text-muted">Administrateur</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et Recherche -->
    <div class="search-box">
        <form method="GET" class="filter-form">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Rechercher</label>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Nom ou description...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Statut</label>
                    <select class="form-select" name="status">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actives</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactives</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Trier par</label>
                    <select class="form-select" name="sort_by">
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Date de création</option>
                        <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nom</option>
                        <option value="updated_at" {{ request('sort_by') === 'updated_at' ? 'selected' : '' }}>Dernière modification</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filtrer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des Catégories -->
    @if($categories->count() > 0)
        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="category-card">
                        <div class="category-header">
                            <div class="d-flex align-items-center">
                                <div class="category-icon" style="background-color: {{ $category->color }}">
                                    <i class="{{ $category->icon }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $category->name }}</h5>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>{{ $category->user->name ?? 'Système' }}
                                    </small>
                                </div>
                                <div>
                                    @if($category->is_active)
                                        <span class="status-badge status-active">Active</span>
                                    @else
                                        <span class="status-badge status-inactive">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-body">
                            @if($category->description)
                                <p class="text-muted mb-3">{{ Str::limit($category->description, 100) }}</p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-book me-1"></i>{{ $category->books_count }} livre(s)
                                    </small>
                                </div>
                                <div>
                                    <small class="text-muted">
                                        Créé le {{ $category->created_at->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            @if($category->user_id === Auth::id())
                                <div class="d-flex gap-2">
                                    <button type="button"
                                            onclick="showCategoryDetails('{{ $category->id }}')"
                                            class="action-btn btn-view flex-fill">
                                        <i class="fas fa-eye"></i>Voir
                                    </button>
                                    
                                    <button type="button"
                                            onclick="editCategory('{{ $category->id }}')"
                                            class="action-btn btn-edit flex-fill">
                                        <i class="fas fa-edit"></i>Modifier
                                    </button>
                                    
                                    <form method="POST" 
                                          action="{{ route('admin.categories.toggle-status', $category) }}" 
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn btn-toggle">
                                            <i class="fas fa-toggle-{{ $category->is_active ? 'on' : 'off' }}"></i>
                                        </button>
                                    </form>
                                    
                                    @if($category->books()->count() === 0)
                                        <button type="button" 
                                                class="action-btn btn-delete"
                                                onclick="showDeleteModal('{{ $category->id }}', '{{ $category->name }}', {{ $category->books()->count() }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            @else
                                <div class="text-center text-muted">
                                    <small><i class="fas fa-lock me-1"></i>Catégorie d'un autre utilisateur</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->withQueryString()->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-tags"></i>
            <h3>Aucune catégorie trouvée</h3>
            <p>Il n'y a pas encore de catégories correspondant à vos critères.</p>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-plus me-2"></i>Créer la première catégorie
            </a>
        </div>
    @endif
</div>
@endsection

<!-- Modal de Suppression des Catégories -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-delete-modal">
            <div class="modal-header custom-delete-modal-header">
                <div class="w-100 text-center">
                    <div class="delete-icon-warning mb-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h4 class="modal-title" id="deleteCategoryModalLabel">Confirmer la suppression</h4>
                </div>
            </div>
            <div class="modal-body text-center custom-delete-modal-body">
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer définitivement la catégorie :</p>
                <div class="category-name-highlight mb-4">
                    <i class="fas fa-layer-group me-2"></i>
                    <span id="categoryNameToDelete"></span>
                </div>
                <div class="warning-delete-box">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Cette action est irréversible et supprimera définitivement la catégorie.</small>
                </div>
            </div>
            <div class="modal-footer custom-delete-modal-footer justify-content-center">
                <button type="button" class="btn btn-cancel-delete" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <form id="deleteCategoryForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete-confirm">
                        <i class="fas fa-trash-alt me-2"></i>Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé, initialisation des fonctions...');
    console.log('Bootstrap disponible:', typeof bootstrap !== 'undefined');
    console.log('Modal categories disponible:', document.getElementById('categoryDetailsModal') !== null);
    console.log('Modal edit disponible:', document.getElementById('categoryEditModal') !== null);
    console.log('Modal delete disponible:', document.getElementById('deleteCategoryModal') !== null);
    
    // Test simple
    window.testModal = function() {
        console.log('Test modal appelé');
        alert('Les fonctions JavaScript fonctionnent !');
    };
    
    document.querySelectorAll('.action-btn').forEach(btn => {
        console.log('Bouton trouvé:', btn.textContent.trim());
    });
    
    // Activation des tooltips Bootstrap si présents
    if (typeof bootstrap !== 'undefined') {}
    // Auto-submit form when filters change
    const selectFilters = document.querySelectorAll('select[name="status"], select[name="sort_by"]');
    
    selectFilters.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
    
    // Search with delay
    const searchInput = document.querySelector('input[name="search"]');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 800);
        });
    }
    
    // Fonctions pour les modals
    window.showCategoryDetails = function(categoryId) {
        console.log('showCategoryDetails appelée avec categoryId:', categoryId);
        
        try {
            const modal = new bootstrap.Modal(document.getElementById('categoryDetailsModal'));
            const body = document.getElementById('categoryDetailsBody');
            
            console.log('Modal trouvé:', modal);
            console.log('Body trouvé:', body);
            
            // Afficher le spinner
            body.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            `;
            
            // Ouvrir le modal
            modal.show();
            console.log('Modal détails ouvert');
            
            // Charger les données
            const url = `/admin/categories/${categoryId}/details`;
            console.log('URL de la requête détails:', url);
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                console.log('Réponse détails reçue:', response);
                return response.json();
            })
            .then(data => {
                console.log('Données détails reçues:', data);
                if (data.success) {
                    body.innerHTML = data.html;
                    document.getElementById('categoryDetailsHeader').style.background = 
                        `linear-gradient(135deg, ${data.category.color}dd 0%, ${data.category.color}aa 100%)`;
                    document.getElementById('categoryDetailsHeader').style.color = 'white';
                } else {
                    console.error('Erreur dans la réponse détails:', data);
                    body.innerHTML = `<div class="alert alert-danger">Erreur lors du chargement des détails.</div>`;
                }
            })
            .catch(error => {
                console.error('Erreur détails:', error);
                body.innerHTML = `<div class="alert alert-danger">Erreur de connexion.</div>`;
            });
        } catch (error) {
            console.error('Erreur dans showCategoryDetails:', error);
            alert('Erreur: ' + error.message);
        }
    };
    
    window.editCategory = function(categoryId) {
        console.log('editCategory appelée avec categoryId:', categoryId);
        
        try {
            const modal = new bootstrap.Modal(document.getElementById('categoryEditModal'));
            const body = document.getElementById('categoryEditBody');
            
            console.log('Modal trouvé:', modal);
            console.log('Body trouvé:', body);
            
            // Afficher le spinner
            body.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            `;
            
            // Ouvrir le modal
            modal.show();
            console.log('Modal ouvert');
            
            // Charger le formulaire d'édition
            const url = `/admin/categories/${categoryId}/edit-form`;
            console.log('URL de la requête:', url);
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                console.log('Réponse reçue:', response);
                return response.json();
            })
            .then(data => {
                console.log('Données reçues:', data);
                if (data.success) {
                    body.innerHTML = data.html;
                    // Initialiser les scripts du formulaire
                    initializeEditForm();
                } else {
                    console.error('Erreur dans la réponse:', data);
                    body.innerHTML = `<div class="alert alert-danger">Erreur lors du chargement du formulaire.</div>`;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                body.innerHTML = `<div class="alert alert-danger">Erreur de connexion.</div>`;
            });
        } catch (error) {
            console.error('Erreur dans editCategory:', error);
            alert('Erreur: ' + error.message);
        }
    };
    
    // Fonction pour le modal de suppression
    window.showDeleteModal = function(categoryId, categoryName, booksCount) {
        console.log('showDeleteModal appelée avec:', categoryId, categoryName, booksCount);
        document.getElementById('categoryNameToDelete').textContent = categoryName;
        
        const deleteForm = document.getElementById('deleteCategoryForm');
        deleteForm.action = `/admin/categories/${categoryId}`;
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
        deleteModal.show();
    };
    
    function initializeEditForm() {
        // Code pour initialiser les sélecteurs de couleur et d'icône dans le modal
        const colorOptions = document.querySelectorAll('.color-option');
        const iconOptions = document.querySelectorAll('.icon-option');
        const nameInput = document.querySelector('#edit_name');
        const descriptionInput = document.querySelector('#edit_description');
        const colorInput = document.querySelector('#edit_color');
        const iconInput = document.querySelector('#edit_icon');
        const previewIcon = document.querySelector('#edit_preview_icon');
        const previewIconClass = document.querySelector('#edit_preview_icon_class');
        const previewName = document.querySelector('#edit_preview_name');
        const previewDescription = document.querySelector('#edit_preview_description');
        
        // Gestion des couleurs
        if (colorOptions) {
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const color = this.dataset.color;
                    
                    colorOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    colorInput.value = color;
                    if (previewIcon) previewIcon.style.background = color;
                });
            });
        }
        
        // Gestion des icônes
        if (iconOptions) {
            iconOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const icon = this.dataset.icon;
                    
                    iconOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    iconInput.value = icon;
                    if (previewIconClass) previewIconClass.className = icon;
                });
            });
        }
        
        // Mise à jour du nom en temps réel
        if (nameInput && previewName) {
            nameInput.addEventListener('input', function() {
                const value = this.value.trim();
                previewName.textContent = value || 'Nom de la catégorie';
            });
        }
        
        // Mise à jour de la description en temps réel
        if (descriptionInput && previewDescription) {
            descriptionInput.addEventListener('input', function() {
                const value = this.value.trim();
                previewDescription.textContent = value || 'Description de la catégorie';
            });
        }
    }
});
</script>
@endpush

<!-- Modals -->
<div class="modal fade" id="categoryDetailsModal" tabindex="-1" aria-labelledby="categoryDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0" id="categoryDetailsHeader">
                <h5 class="modal-title" id="categoryDetailsModalLabel">Détails de la catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="categoryDetailsBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="categoryEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="categoryEditModalLabel">Modifier la catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="categoryEditBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
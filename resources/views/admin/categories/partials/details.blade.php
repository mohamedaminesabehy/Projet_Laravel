<style>
    .modal-category-header {
        background: linear-gradient(135deg, {{ $category->color }}dd 0%, {{ $category->color }}aa 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        margin: -1rem -1rem 2rem -1rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    
    .modal-category-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1rem;
    }
    
    .modal-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .modal-stat-card {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        text-align: center;
        border-left: 4px solid {{ $category->color }};
    }
    
    .modal-stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: {{ $category->color }};
        margin-bottom: 0.5rem;
    }
    
    .modal-info-table {
        width: 100%;
        margin-bottom: 1.5rem;
    }
    
    .modal-info-table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .modal-info-table td:first-child {
        font-weight: 600;
        color: #495057;
        background: #f8f9fa;
        width: 40%;
    }
    
    .modal-book-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 0.75rem;
    }
    
    .modal-book-cover {
        width: 40px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 1rem;
    }
    
    .modal-book-placeholder {
        width: 40px;
        height: 50px;
        background-color: {{ $category->color }}22;
        border-radius: 4px;
        margin-right: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: {{ $category->color }};
    }
</style>

<div class="modal-category-header">
    <div class="modal-category-icon">
        <i class="{{ $category->icon }}"></i>
    </div>
    <h3 class="mb-2">{{ $category->name }}</h3>
    <p class="mb-0 opacity-90">{{ $category->description ?: 'Aucune description disponible' }}</p>
</div>

<!-- Statistiques -->
<div class="modal-stats-grid">
    <div class="modal-stat-card">
        <div class="modal-stat-number">{{ $stats['books_count'] }}</div>
        <div class="text-muted">Livre(s)</div>
    </div>
    <div class="modal-stat-card">
        <div class="modal-stat-number">{{ $stats['active_books_count'] }}</div>
        <div class="text-muted">Disponible(s)</div>
    </div>
    <div class="modal-stat-card">
        <div class="modal-stat-number">{{ $category->is_active ? 'Oui' : 'Non' }}</div>
        <div class="text-muted">Active</div>
    </div>
</div>

<!-- Informations détaillées -->
<div class="row">
    <div class="col-lg-6">
        <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Informations</h6>
        <table class="modal-info-table">
            <tbody>
                <tr>
                    <td>Nom</td>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <td>Slug</td>
                    <td><code>{{ $category->slug }}</code></td>
                </tr>
                <tr>
                    <td>Couleur</td>
                    <td>
                        <span class="d-inline-flex align-items-center">
                            <span class="badge me-2" style="background-color: {{ $category->color }}; width: 20px; height: 20px;"></span>
                            {{ $category->color }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Icône</td>
                    <td>
                        <i class="{{ $category->icon }} me-2"></i>
                        <code>{{ $category->icon }}</code>
                    </td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td>
                        @if($category->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Créé le</td>
                    <td>{{ $category->created_at->format('d/m/Y à H:i') }}</td>
                </tr>
                <tr>
                    <td>Modifié le</td>
                    <td>{{ $category->updated_at->format('d/m/Y à H:i') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-lg-6">
        <h6 class="mb-3"><i class="fas fa-book me-2"></i>Livres Récents</h6>
        @if($stats['latest_books']->count() > 0)
            @foreach($stats['latest_books'] as $book)
                <div class="modal-book-item">
                    @if($book->cover_image)
                        <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="modal-book-cover">
                    @else
                        <div class="modal-book-placeholder">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <div class="fw-bold">{{ $book->title }}</div>
                        <small class="text-muted">par {{ $book->author }}</small>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">{{ $book->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
            
            @if($stats['books_count'] > 5)
                <div class="text-center mt-2">
                    <small class="text-muted">
                        Et {{ $stats['books_count'] - 5 }} autre(s) livre(s)...
                    </small>
                </div>
            @endif
        @else
            <div class="text-center text-muted py-4">
                <i class="fas fa-book-open fa-2x mb-2 opacity-50"></i>
                <p class="mb-0">Aucun livre dans cette catégorie</p>
            </div>
        @endif
    </div>
</div>
@extends('layouts.admin')

@section('title', $category->name . ' - Détails Catégorie')

@push('styles')
<style>
    .category-detail-card {
@section('content')
<div class="container-fluid py-4">round: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .category-header {
        background: linear-gradient(135deg, {{ $category->color }}dd 0%, {{ $category->color }}aa 100%);
        color: white;
        padding: 3rem 2rem;
        text-align: center;
        position: relative;
    }
    
    .category-icon-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 1rem;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-left: 4px solid {{ $category->color }};
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: {{ $category->color }};
        margin-bottom: 0.5rem;
    }
    
    .content-section {
        padding: 2rem;
    }
    
    .info-table {
        background: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .info-table tr td:first-child {
        background: {{ $category->color }}22;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .book-card {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .book-card:hover {
        transform: translateY(-3px);
    }
    
    .action-buttons {
        background: #f8f9fa;
        padding: 1.5rem 2rem;
        border-top: 1px solid #e9ecef;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #D16655, #e07565);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-edit:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(209, 102, 85, 0.3);
    }
    
    .btn-toggle {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-toggle:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #BD7579, #d18689);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-delete:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(189, 117, 121, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.categories.index') }}">Catégories</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="category-detail-card">
        <!-- Header avec informations principales -->
        <div class="category-header">
            <div class="category-icon-large">
                <i class="{{ $category->icon }}"></i>
            </div>
            <h1 class="mb-3">{{ $category->name }}</h1>
            <p class="mb-0 opacity-90 fs-5">{{ $category->description ?: 'Aucune description disponible' }}</p>
        </div>

        <!-- Statistiques -->
        <div class="content-section">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['books_count'] }}</div>
                    <div class="text-muted">Livre(s)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['active_books_count'] }}</div>
                    <div class="text-muted">Livre(s) Disponible(s)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['reviews_count'] }}</div>
                    <div class="text-muted">Avis</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $category->is_active ? 'Oui' : 'Non' }}</div>
                    <div class="text-muted">Active</div>
                </div>
            </div>

            <!-- Informations détaillées -->
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="mb-3">
                        <i class="fas fa-info-circle me-2"></i>Informations
                    </h5>
                    <table class="table info-table">
                        <tbody>
                            <tr>
                                <td style="width: 40%">Nom</td>
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
                                <td>Créé par</td>
                                <td>{{ $category->user->name ?? 'Système' }}</td>
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
                    <h5 class="mb-3">
                        <i class="fas fa-book me-2"></i>Livres Récents
                    </h5>
                    @if($stats['latest_books']->count() > 0)
                        <div class="d-grid gap-3">
                            @foreach($stats['latest_books'] as $book)
                                <div class="book-card">
                                    <div class="d-flex align-items-center">
                                        @if($book->cover_image)
                                            <img src="{{ $book->cover_image }}" 
                                                 alt="{{ $book->title }}" 
                                                 class="me-3"
                                                 style="width: 50px; height: 60px; object-fit: cover; border-radius: 5px;">
                                        @else
                                            <div class="me-3 d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 60px; background-color: {{ $category->color }}22; border-radius: 5px;">
                                                <i class="fas fa-book" style="color: {{ $category->color }}"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $book->title }}</h6>
                                            <small class="text-muted">par {{ $book->author }}</small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">{{ $book->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($stats['books_count'] > 5)
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Et {{ $stats['books_count'] - 5 }} autre(s) livre(s)...
                                </small>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-book-open fa-3x mb-3 opacity-50"></i>
                            <p>Aucun livre dans cette catégorie</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if($category->user_id === Auth::id())
            <div class="action-buttons">
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                    
                    <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-toggle">
                            <i class="fas fa-toggle-{{ $category->is_active ? 'off' : 'on' }} me-2"></i>
                            {{ $category->is_active ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                    
                    @if($stats['books_count'] === 0)
                        <form method="POST" 
                              action="{{ route('admin.categories.destroy', $category) }}" 
                              class="d-inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
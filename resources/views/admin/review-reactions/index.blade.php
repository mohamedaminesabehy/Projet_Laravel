@extends('layouts.admin')

@section('title', 'Gestion des Réactions aux Avis')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">
                <i class="fas fa-thumbs-up text-primary"></i> Réactions aux Avis
            </h2>
            <p class="text-muted">Gérez toutes les réactions (likes et dislikes) des utilisateurs</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Réactions</h6>
                            <h2 class="mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="fas fa-hand-pointer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Likes</h6>
                            <h2 class="mb-0">{{ number_format($stats['likes']) }}</h2>
                            <small class="text-white-75">{{ number_format($stats['likes_percentage'], 1) }}%</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Dislikes</h6>
                            <h2 class="mb-0">{{ number_format($stats['dislikes']) }}</h2>
                            <small class="text-white-75">{{ number_format($stats['dislikes_percentage'], 1) }}%</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="fas fa-thumbs-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Ratio Positif</h6>
                            <h2 class="mb-0">{{ $stats['total'] > 0 ? number_format(($stats['likes'] / $stats['total']) * 100, 1) : 0 }}%</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.review-reactions.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Type de Réaction</label>
                        <select name="reaction_type" class="form-select">
                            <option value="">Tous</option>
                            <option value="like" {{ request('reaction_type') === 'like' ? 'selected' : '' }}>👍 Like</option>
                            <option value="dislike" {{ request('reaction_type') === 'dislike' ? 'selected' : '' }}>👎 Dislike</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date de Début</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date de Fin</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Recherche</label>
                        <input type="text" name="search" class="form-control" placeholder="Utilisateur ou livre..." value="{{ request('search') }}">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrer
                        </button>
                        <a href="{{ route('admin.review-reactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reactions Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Liste des Réactions
                    <span class="badge bg-primary ms-2">{{ $reactions->total() }}</span>
                </h5>
                <div>
                    <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn" disabled>
                        <i class="fas fa-trash"></i> Supprimer sélection
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($reactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>Utilisateur</th>
                                <th>Avis</th>
                                <th>Livre</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reactions as $reaction)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input reaction-checkbox" value="{{ $reaction->id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                {{ strtoupper(substr($reaction->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $reaction->user->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $reaction->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <small class="text-muted">Par: {{ $reaction->review->user->name ?? 'N/A' }}</small><br>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $reaction->review->rating ? '' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ Str::limit($reaction->review->book->title ?? 'N/A', 30) }}</span>
                                    </td>
                                    <td>
                                        @if($reaction->reaction_type === 'like')
                                            <span class="badge bg-success">
                                                <i class="fas fa-thumbs-up"></i> Like
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-thumbs-down"></i> Dislike
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $reaction->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.review-reactions.show', $reaction->id) }}" class="btn btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.review-reactions.destroy', $reaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réaction ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-white">
                    {{ $reactions->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Aucune réaction trouvée</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Select all functionality
document.getElementById('selectAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.reaction-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateBulkDeleteButton();
});

// Update bulk delete button state
document.querySelectorAll('.reaction-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkDeleteButton);
});

function updateBulkDeleteButton() {
    const checkedBoxes = document.querySelectorAll('.reaction-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    bulkDeleteBtn.disabled = checkedBoxes.length === 0;
}

// Bulk delete
document.getElementById('bulkDeleteBtn')?.addEventListener('click', function() {
    const checkedBoxes = document.querySelectorAll('.reaction-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (confirm(`Êtes-vous sûr de vouloir supprimer ${ids.length} réaction(s) ?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.review-reactions.bulk-delete") }}';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'reaction_ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
});
</script>
@endpush
@endsection

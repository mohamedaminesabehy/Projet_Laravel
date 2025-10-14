@extends('layouts.admin')

@push('styles')
<style>
    body {
        background-color: #f8f9fa; /* Light gray background for a modern feel */
    }
    .book-cover {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .book-title {
        font-weight: 600;
        margin-bottom: 2px;
    }
    .book-author {
        font-size: 13px;
        color: #6c757d;
    }
    .book-price {
        font-weight: 600;
    }
    .book-stock {
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .stock-low {
        background-color: #fff5f5;
        color: #e53e3e;
    }
    .stock-medium {
        background-color: #fffaf0;
        color: #dd6b20;
    }
    .stock-high {
        background-color: #f0fff4;
        color: #38a169;
    }
    .filter-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
    }
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px;
    }
    .book-badge {
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 20px;
        margin-right: 5px;
        display: inline-block;
    }
    .badge-new {
        background-color: #ebf8ff;
        color: #3182ce;
    }
    .badge-bestseller {
        background-color: #fef5e7;
        color: #f39c12;
    }
    .badge-sale {
        background-color: #feebc8;
        color: #dd6b20;
    }
    select, .form-control, .form-select, textarea, input {
        height: 50px;
        padding: 0 30px 0 28px;
        padding-right: 45px;
        border: 1px solid var(--border-color);
        color: #000000;
        background-color: var(--white-color);
        border-radius: 9999px;
        border-size: 0;
        font-size: 14px;
        width: 100%;
    }
    .hidden {
        display: none;
    }
    .delete-confirm-modal {
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
    }
    .delete-confirm-content {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        width: 400px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    .delete-confirm-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .delete-confirm-title {
        font-size: 18px;
        font-weight: 600;
        color: #dc3545;
    }
    .delete-confirm-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }
    .delete-confirm-body {
        margin-bottom: 20px;
    }
    .delete-confirm-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .modal-content.book-detail-modal {
        border-radius: 12px;
        overflow: hidden;
        background-color: #ffffff;
    }
    .book-detail-header {
        background: linear-gradient(135deg, #fff1eb, #D16655);
        color: white;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .book-detail-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .book-detail-cover-wrapper {
    position: relative;
    padding-top: 127%;
    overflow: overlay;
    margin-top: 30px;
    border-radius: 17px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .book-detail-cover {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .book-detail-info-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    .book-detail-info-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .book-detail-info-card .title {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .book-detail-info-card .value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #343a40;
    }
    .book-detail-description {
        line-height: 1.8;
        color: #495057;
    }
    .book-detail-badge {
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    .badge-published {
        background-color: #d4edda;
        color: #28a745;
    }
    .badge-draft {
        background-color: #fff3cd;
        color: #ffc107;
    }
    .book-detail-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    .book-detail-meta span {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .meta-author {
        background-color: #e9ecef;
        color: #495057;
    }
    .meta-category {
        background-color: #e2f0ff;
        color: #007bff;
    }
    .meta-isbn {
        background-color: #eafbea;
        color: #28a745;
    }
    .modal-footer.book-detail-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 15px 25px;
    }
    .btn-close.book-detail-close {
        font-size: 1.2rem;
        color: white;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }
    .btn-close.book-detail-close:hover {
        opacity: 1;
    }
    .modal-body-text {
        color: #212529; /* Dark black color for text */
        font-size: 1rem;
        line-height: 1.5;
        font-family: cursive;
    }
    .btn-custom-close {
        background-color: #D16655;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .btn-custom-close:hover {
        background-color: #b35244; /* A slightly darker shade for hover effect */
        color: white; /* Keep text white on hover */
    }
    .table tbody tr {
        border-bottom: 1px solid #e9ecef; /* Subtle gray line to separate rows */
    }
    .table tbody tr:last-child {
        border-bottom: none; /* No border for the last row */
    }
    /* Ensure readable text color inside modal */
    .modal-body-text, #eventModal .modal-body, #eventModal table, #eventModal td, #eventModal th {
        color: #212529 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- En-tête avec boutons d'action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Gestion des Événements</h4>
            <p class="text-muted">Gérez vos événements</p>
        </div>
        <div>
            <a href="#" class="btn btn-primary open-event-modal" data-url="{{ route('admin.events.create') }}" data-title="Ajouter un nouvel événement">
                <i class="fas fa-plus me-2"></i> Ajouter un événement
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="col-lg-12 mb-4">
        <div class="card filter-card">
            <div class="card-body">
                <form action="{{ route('admin.events.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-dark"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control border-0 bg-light text-dark filter-input" id="search" name="search" placeholder="Titre, description, lieu..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select border-0 bg-light text-dark filter-input" id="status" name="status">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tous</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control border-0 bg-light text-dark filter-input" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control border-0 bg-light text-dark filter-input" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Events Table -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">Liste des Événements</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="eventsTable">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllEvents">
                                    </div>
                                </th>
                                <th width="35%" class="text-dark">Événement</th>
                                <th width="15%" class="text-dark">Début</th>
                                <th width="15%" class="text-dark">Fin</th>
                                <th width="10%" class="text-dark">Lieu</th>
                                <th width="10%" class="text-dark">Statut</th>
                                <th width="10%" class="text-dark">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $event->id }}" name="selected_events[]">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mb-2" id="currentImageContainer" style="display: none;"><img id="currentImagePreview" src="" alt="" class="img-thumbnail" style="max-height: 150px;"></div>
                                        <div>
                                            <div class="book-title text-dark">{{ $event->title }}</div>
                                            <div class="book-author text-dark">{{ $event->location ?? 'Lieu non spécifié' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-dark">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}</td>
                                <td class="text-dark">{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td class="text-dark">{{ $event->location ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $event->is_active ? 'bg-success' : 'bg-danger' }}">{{ $event->is_active ? 'Actif' : 'Inactif' }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="#" class="action-btn btn-light open-event-modal" data-url="{{ route('admin.events.show', $event->id) }}" data-title="Détails de l'événement">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                        <a href="#" class="action-btn btn-light open-event-modal" data-url="{{ route('admin.events.edit', $event->id) }}" data-title="Modifier l'événement">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="action-btn btn-light delete-event-btn" data-url="{{ route('admin.events.destroy', $event->id) }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun événement trouvé</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Affichage de {{ $events->firstItem() }}-{{ $events->lastItem() }} sur {{ $events->total() }} événements</div>
                    <nav>
                        {{ $events->appends(request()->query())->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour l'ajout, l'édition et l'affichage des événements -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content book-detail-modal">
            <div class="modal-header book-detail-header">
                <h5 class="modal-title book-detail-title" id="eventModalLabel"></h5>
                <button type="button" class="btn-close book-detail-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="eventModalBody">
                <!-- Le contenu du formulaire ou des détails de l'événement sera chargé ici via AJAX -->
            </div>
        </div>
    </div>
</div>


<!-- Create Event Modal Content -->
<div id="createEventModalContent" style="display: none;">
    <div class="modal-body p-4">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="addEventForm">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="form-label modal-body-text">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control modal-body-text @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location" class="form-label modal-body-text">Lieu</label>
                        <input type="text" class="form-control modal-body-text @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date" class="form-label modal-body-text">Date de début <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control modal-body-text @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date" class="form-label modal-body-text">Date de fin</label>
                        <input type="datetime-local" class="form-control modal-body-text @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label modal-body-text">Description</label>
                <textarea class="form-control modal-body-text @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image" class="form-label modal-body-text">Image</label>
                            <div class="mb-2" id="currentImageContainer" style="display: none;">
                                <img id="currentImagePreview" src="" alt="" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                            <label class="custom-file-label modal-body-text" for="image">Choisir une nouvelle image</label>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted modal-body-text">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="is_active" class="form-label modal-body-text">Statut</label>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                            <label class="custom-control-label modal-body-text" for="is_active">Actif</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer book-detail-footer">
                <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
        
        {{-- Removed inline script; logic handled in bottom scripts --}}
    </div>
</div>

<!-- Edit Event Modal Content -->
<div id="editEventModalContent" style="display: none;">
    <div class="modal-body p-4">
        <form action="{{ route('admin.events.update', ['event' => ':event_id']) }}" method="POST" enctype="multipart/form-data" id="editEventForm">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="form-label modal-body-text">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control modal-body-text @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location" class="form-label modal-body-text">Lieu</label>
                        <input type="text" class="form-control modal-body-text @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date" class="form-label modal-body-text">Date de début <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control modal-body-text @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date" class="form-label modal-body-text">Date de fin</label>
                        <input type="datetime-local" class="form-control modal-body-text @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label modal-body-text">Description</label>
                <textarea class="form-control modal-body-text @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image" class="form-label modal-body-text">Image</label>
                        <div class="mb-2" id="currentImageContainer" style="display: none;"><img id="currentImagePreview" src="" alt="" class="img-thumbnail" style="max-height: 150px;"></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                            <label class="custom-file-label modal-body-text" for="image">Choisir une nouvelle image</label>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted modal-body-text">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="is_active" class="form-label modal-body-text">Statut</label>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1">
                            <label class="custom-control-label modal-body-text" for="is_active">Actif</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer book-detail-footer">
                <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<!-- Show Event Modal Content -->
<div id="showEventModalContent" style="display: none;">
    <div class="modal-body p-4">
        <div class="row">
            <!-- Left Column - Image -->
            <div class="col-lg-4 text-center">
                <img id="event-image" src="" alt="Event image" class="img-fluid rounded mb-3 d-none" style="max-height: 200px;">
                <div id="event-image-placeholder" class="text-center p-5 bg-light rounded mb-3">
                    <i class="fas fa-image fa-3x text-gray-400"></i>
                    <p class="mt-2 text-gray-500 modal-body-text">Aucune image disponible</p>
                </div>
            </div>
            
            <!-- Right Column - Details -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <h6 class="m-0 font-weight-bold text-primary modal-body-text">Informations</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="modal-body-text" style="width: 30%">ID</th>
                                    <td class="modal-body-text" id="event-id"></td>
                                </tr>
                                <tr>
                                    <th class="modal-body-text">Titre</th>
                                    <td class="modal-body-text" id="event-title"></td>
                                </tr>
                                <tr>
                                    <th class="modal-body-text">Date de début</th>
                                    <td class="modal-body-text" id="event-start-date"></td>
                                </tr>
                                <tr>
                                    <th class="modal-body-text">Date de fin</th>
                                    <td class="modal-body-text" id="event-end-date"></td>
                                </tr>
                                <tr>
                                    <th class="modal-body-text">Lieu</th>
                                    <td class="modal-body-text" id="event-location"></td>
                                </tr>
                                <tr>
                                    <th class="modal-body-text">Statut</th>
                                    <td class="modal-body-text" id="event-status"></td>
                                </tr>
                                <tr>
                                    <th class="modal-body-text">Créé le</th>
                                    <td class="modal-body-text" id="event-created-at"></td>
                                </tr>
                                <tr>
                                    <th class="modal-body-text">Dernière modification</th>
                                    <td class="modal-body-text" id="event-updated-at"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Description Card -->
                <div class="mb-4">
                    <h6 class="m-0 font-weight-bold text-primary modal-body-text">Description</h6>
                    <div class="modal-body-text" id="event-description"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer book-detail-footer">
        <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal">Fermer</button>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Display selected file name for all file inputs
        $(document).on('change', '.custom-file-input', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Gérer l'ouverture de la modale pour ajouter, éditer ou afficher un événement
        $(document).on('click', '.open-event-modal', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var title = $(this).data('title');

            $('#eventModalLabel').text(title);
            $('#eventModalBody').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
            $('#eventModal').modal('show');

            // Check if it's the create event modal
            if (url.includes('admin/events/create')) {
                $('#eventModalBody').html($('#createEventModalContent').html());
                // Reinitialize CKEDITOR for the create form
                if (typeof CKEDITOR !== 'undefined') {
                    for (var instanceName in CKEDITOR.instances) {
                        CKEDITOR.instances[instanceName].destroy(true);
                    }
                    CKEDITOR.replace('description');
                    // Ensure CKEDITOR instance is ready before setting data
                    CKEDITOR.on('instanceReady', function(evt) {
                        if (evt.editor.name === 'description') {
                            evt.editor.setData(event.description || '');
                        }
                    });
                }
            } else {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (url.includes('/edit')) {
                            // Populate edit form
                            $('#eventModalBody').html($('#editEventModalContent').html());
                            var event = response.event; // Assuming response contains an 'event' object
                            if (event && event.id) {
                                $('#editEventForm').attr('action', '/admin/events/' + event.id);
                            } else {
                                console.error('Event ID is missing, cannot set form action.');
                            }
                            $('#editEventForm #title').val(event.title);
                            $('#editEventForm #location').val(event.location);
                            $('#editEventForm #start_date').val(event.start_date ? new Date(event.start_date).toISOString().slice(0, 16) : '');
                            $('#editEventForm #end_date').val(event.end_date ? new Date(event.end_date).toISOString().slice(0, 16) : '');
                                        CKEDITOR.on('instanceReady', function(evt) {
                if (evt.editor.name === 'description') {
                    evt.editor.setData(event.description || '');
                }
            });
                            // Handle image display
                            if (event.image) {
                                $('#editEventForm #currentImagePreview').attr('src', '/storage/' + event.image);
                                $('#editEventForm #currentImageContainer').show();
                            } else {
                                $('#editEventForm #currentImageContainer').hide();
                            }
                            $('#editEventForm #is_active').prop('checked', event.is_active);


                            // Handle image display if needed
                            if (event.image) {
                                var imageUrl = '/storage/' + event.image;
                                $('#editEventForm').find('.img-thumbnail').attr('src', imageUrl).parent().show();
                            } else {
                                $('#editEventForm').find('.img-thumbnail').parent().hide();
                            }

                        } else { // Show event
                            $('#eventModalBody').html($('#showEventModalContent').html());
                            var event = response.event; // Assuming response contains an 'event' object
                            $('#showEventModalContent #event-id').text(event.id);
                            $('#showEventModalContent #event-title').text(event.title);
                            $('#showEventModalContent #event-start-date').text(event.start_date ? new Date(event.start_date).toLocaleString() : 'Non spécifiée');
                            $('#showEventModalContent #event-end-date').text(event.end_date ? new Date(event.end_date).toLocaleString() : 'Non spécifiée');
                            $('#showEventModalContent #event-location').text(event.location || 'Non spécifié');
                            // Use Bootstrap 5 badge classes
                            var statusBadge = '<span class="badge ' + (event.is_active ? 'bg-success' : 'bg-danger') + ' p-2">' + (event.is_active ? 'Actif' : 'Inactif') + '</span>';
                            $('#showEventModalContent #event-status').html(statusBadge);
                            $('#showEventModalContent #event-created-at').text(event.created_at ? new Date(event.created_at).toLocaleString() : '');
                            $('#showEventModalContent #event-updated-at').text(event.updated_at ? new Date(event.updated_at).toLocaleString() : '');
                            $('#showEventModalContent #event-description').html(event.description || '<p class="text-muted">Aucune description disponible</p>');

                            // Image toggle
                            if (event.image) {
                                var imageUrl = '/storage/' + event.image;
                                $('#showEventModalContent #event-image').attr('src', imageUrl).removeClass('d-none');
                                $('#showEventModalContent #event-image-placeholder').addClass('d-none');
                            } else {
                                $('#showEventModalContent #event-image').attr('src', '').addClass('d-none');
                                $('#showEventModalContent #event-image-placeholder').removeClass('d-none');
                            }
                        }

                        // Reinitialize CKEDITOR if present for edit form
                        if (typeof CKEDITOR !== 'undefined') {
                            for (var instanceName in CKEDITOR.instances) {
                                CKEDITOR.instances[instanceName].destroy(true);
                            }
                            CKEDITOR.replaceAll('ckeditor');
                        }
                    },
                    error: function(xhr) {
                        $('#eventModalBody').html('<div class="alert alert-danger">Impossible de charger le contenu.</div>');
                    }
                });
            }
        });

        // Gérer la soumission du formulaire via AJAX
        $(document).on('submit', '#addEventForm, #editEventForm', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = new FormData(form[0]);

            // Ajouter le jeton CSRF
            var csrf = $('meta[name="csrf-token"]').attr('content');
            if (csrf) {
                formData.append('_token', csrf);
            }

            // If CKEDITOR is used, update the textarea before submitting
            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.description) {
                formData.set('description', CKEDITOR.instances.description.getData());
            }

            $.ajax({
                url: url,
                type: 'POST', // Always use POST for forms with file uploads and method spoofing
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#eventModal').modal('hide'); // Hide modal on success
                        location.reload(); 
                    } else if (response.errors) {
                        // Afficher les erreurs de validation
                        var errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each(response.errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul></div>';
                        $('#eventModalBody').prepend(errorsHtml);
                    }
                },
                error: function(xhr) {
                    var errorsHtml = '<div class="alert alert-danger">Une erreur est survenue.</div>';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul></div>';
                    }
                    $('#eventModalBody').prepend(errorsHtml);
                }
            });
        });

        // Delete event confirmation
        $(document).on('click', '.delete-event-btn', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
                form.submit();
            }
        });

        // Select-all behavior for events
        $(document).on('change', '#selectAllEvents', function() {
            var checked = $(this).is(':checked');
            $(this).closest('table').find('tbody input.form-check-input[type="checkbox"]').prop('checked', checked);
        });
    });
</script>
@endpush

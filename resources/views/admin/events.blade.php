@extends('layouts.admin')

@push('styles')
<style>
    body { background-color: #f8f9fa; }
    .thumb { width: 56px; height: 56px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,.08); }
    .book-title { font-weight: 600; margin-bottom: 2px; }
    .book-author { font-size: 13px; color: #6c757d; }
    .filter-card { border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.04); }
    .action-btn { width: 32px; height: 32px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; margin-right: 5px; }
    select, .form-control, .form-select, textarea, input {
        height: 50px; padding: 0 30px 0 28px; padding-right: 45px;
        border: 1px solid var(--border-color); color: #000; background-color: var(--white-color);
        border-radius: 9999px; font-size: 14px; width: 100%;
    }
    textarea { height: auto; border-radius: 16px; padding: 14px 20px; }
    .table tbody tr { border-bottom: 1px solid #e9ecef; }
    .table tbody tr:last-child { border-bottom: none; }
    .modal-content.book-detail-modal { border-radius: 12px; overflow: hidden; background-color: #fff; }
    .book-detail-header { background: linear-gradient(135deg, #fff1eb, #D16655); color: #fff; padding: 20px 25px; display: flex; align-items: center; justify-content: space-between; }
    .book-detail-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 0; }
    .modal-body-text, #eventModal .modal-body, #eventModal table, #eventModal td, #eventModal th { color: #212529 !important; }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
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

    <!-- Filters -->
    <div class="col-lg-12 mb-4">
        <div class="card filter-card">
            <div class="card-body">
                <form id="filterForm" action="{{ route('admin.events.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-dark"><i class="fas fa-search"></i></span>
                            <input
                                type="text"
                                class="form-control border-0 bg-light text-dark filter-input"
                                id="search" name="search"
                                placeholder="Rechercher par titre…"
                                value="{{ request('search') }}"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select border-0 bg-light text-dark filter-input" id="status" name="status">
                            <option value="all" {{ request('status','all') == 'all' ? 'selected' : '' }}>Tous</option>
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
                    <div class="col-md-1 d-none">
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
                                <th width="4%">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllEvents">
                                    </div>
                                </th>
                                <th width="10%" class="text-dark">Image</th>
                                <th width="26%" class="text-dark">Événement</th>
                                <th width="14%" class="text-dark">Début</th>
                                <th width="14%" class="text-dark">Fin</th>
                                <th width="10%" class="text-dark">Lieu</th>
                                <th width="10%" class="text-dark">Participants</th>
                                <th width="12%" class="text-dark">Actions</th>
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
                                    @php $img = $event->image_url ?? null; @endphp
                                    @if($img)
                                        <img src="{{ $img }}" alt="{{ $event->title }}" class="thumb">
                                    @else
                                        <div class="text-muted">—</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="book-title text-dark">{{ $event->title }}</div>
                                    <div class="book-author">{{ $event->location ?? 'Lieu non spécifié' }}</div>
                                    <div class="mt-1">
                                        {{-- OPEN PARTICIPANTS IN MODAL (no navigation) --}}
                                        <a href="#"
                                           class="action-btn btn-light open-participants-modal"
                                           data-url="{{ route('admin.events.participants', $event) }}"
                                           data-title="Participants — {{ $event->title }}"
                                           title="Voir les participants">
                                            <i class="fas fa-users text-secondary"></i>
                                        </a>
                                    </div>
                                </td>
                                <td class="text-dark">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}</td>
                                <td class="text-dark">
                                    {{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td class="text-dark">{{ $event->location ?? 'N/A' }}</td>
                                <td class="text-dark">
                                    {{ $event->participations_count ?? $event->participations()->count() }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Show -->
                                        <a href="#" class="action-btn btn-light open-event-modal"
                                           data-url="{{ route('admin.events.show', $event) }}"
                                           data-title="Détails de l'événement"
                                           title="Voir">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                        <!-- Edit -->
                                        <a href="#" class="action-btn btn-light open-event-modal"
                                           data-url="{{ route('admin.events.edit', $event) }}"
                                           data-title="Modifier l'événement"
                                           title="Modifier">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <!-- PDF -->
                                        <a href="{{ route('admin.events.downloadPdf', $event) }}"
                                           class="action-btn btn-light"
                                           title="Télécharger PDF"
                                           target="_blank">
                                            <i class="fas fa-file-pdf text-danger"></i>
                                        </a>
                                        <!-- Delete -->
                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="action-btn btn-light delete-event-btn" title="Supprimer">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun événement trouvé</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Affichage de {{ $events->firstItem() }}-{{ $events->lastItem() }} sur {{ $events->total() }} événements
                    </div>
                    <nav>
                        {{ $events->appends(request()->query())->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for create/edit/show/participants -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content book-detail-modal">
            <div class="modal-header book-detail-header">
                <h5 class="modal-title book-detail-title" id="eventModalLabel"></h5>
                <button type="button" class="btn-close book-detail-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="eventModalBody"></div>
        </div>
    </div>
</div>

<!-- Create template -->
<div id="createEventModalContent" style="display: none;">
    <div class="modal-body p-4">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="addEventForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="title" class="form-label modal-body-text">Titre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control modal-body-text @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="location" class="form-label modal-body-text">Lieu</label>
                    <input type="text" class="form-control modal-body-text @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="start_date" class="form-label modal-body-text">Date de début <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control modal-body-text @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="end_date" class="form-label modal-body-text">Date de fin</label>
                    <input type="datetime-local" class="form-control modal-body-text @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- AI block start (CREATE) --}}
            <div class="card mb-3 mt-3">
                <div class="card-header">AI: Générer Titre & Description</div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label">Mots-clés (séparés par des virgules)</label>
                        <input id="ai_keywords" class="form-control" placeholder="ex: ia, innovation, étudiants">
                    </div>

                    <div class="row g-2">
                        <div class="col">
                            <label class="form-label">Audience</label>
                            <select id="ai_audience" class="form-select">
                                <option value="everyone">Tout le monde</option>
                                <option value="students">Étudiants</option>
                                <option value="developers">Développeurs</option>
                                <option value="managers">Managers</option>
                                <option value="designers">Designers</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Ton</label>
                            <select id="ai_tone" class="form-select">
                                <option value="professional">Professionnel</option>
                                <option value="friendly">Convivial</option>
                                <option value="exciting">Dynamique</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Langue</label>
                            <select id="ai_lang" class="form-select">
                                <option value="fr" selected>Français</option>
                                <option value="en">English</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Longueur</label>
                            <select id="ai_length" class="form-select">
                                <option value="medium" selected>Moyen</option>
                                <option value="short">Court</option>
                                <option value="long">Long</option>
                            </select>
                        </div>
                    </div>

                    <button type="button" id="ai_generate" class="btn btn-outline-primary mt-3">
                        ⚡ Générer le titre & la description
                    </button>

                    <div id="ai_variants" class="mt-2" style="display:none;">
                        <small class="text-muted">Autres variantes de titre :</small>
                        <div id="ai_variant_list" class="mt-1"></div>
                    </div>
                </div>
            </div>
            {{-- AI block end (CREATE) --}}

            <div class="mt-3">
                <label for="description" class="form-label modal-body-text">Description</label>
                <textarea class="form-control modal-body-text @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="image" class="form-label modal-body-text">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="form-text text-muted modal-body-text">Formats: JPG, PNG, GIF, WebP. Max: 4MB</small>
                </div>
                <div class="col-md-6">
                    <label for="is_active" class="form-label modal-body-text">Statut</label>
                    <div class="form-check form-switch mt-2">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active','1')=='1'?'checked':'' }}>
                        <label class="form-check-label modal-body-text" for="is_active">Actif</label>
                    </div>
                </div>
            </div>

            <div class="modal-footer book-detail-footer mt-4">
                <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit template -->
<div id="editEventModalContent" style="display: none;">
    <div class="modal-body p-4">
        <form action="{{ route('admin.events.update', ['event' => ':event_id']) }}" method="POST" enctype="multipart/form-data" id="editEventForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <label for="title" class="form-label modal-body-text">Titre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control modal-body-text @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="location" class="form-label modal-body-text">Lieu</label>
                    <input type="text" class="form-control modal-body-text @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="start_date" class="form-label modal-body-text">Date de début <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control modal-body-text @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="end_date" class="form-label modal-body-text">Date de fin</label>
                    <input type="datetime-local" class="form-control modal-body-text @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- AI block start (EDIT) --}}
            <div class="card mb-3 mt-3">
                <div class="card-header">AI: Générer Titre & Description</div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label">Mots-clés (séparés par des virgules)</label>
                        <input id="ai_keywords" class="form-control" placeholder="ex: ia, innovation, étudiants">
                    </div>

                    <div class="row g-2">
                        <div class="col">
                            <label class="form-label">Audience</label>
                            <select id="ai_audience" class="form-select">
                                <option value="everyone">Tout le monde</option>
                                <option value="students">Étudiants</option>
                                <option value="developers">Développeurs</option>
                                <option value="managers">Managers</option>
                                <option value="designers">Designers</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Ton</label>
                            <select id="ai_tone" class="form-select">
                                <option value="professional">Professionnel</option>
                                <option value="friendly">Convivial</option>
                                <option value="exciting">Dynamique</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Langue</label>
                            <select id="ai_lang" class="form-select">
                                <option value="fr" selected>Français</option>
                                <option value="en">English</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Longueur</label>
                            <select id="ai_length" class="form-select">
                                <option value="medium" selected>Moyen</option>
                                <option value="short">Court</option>
                                <option value="long">Long</option>
                            </select>
                        </div>
                    </div>

                    <button type="button" id="ai_generate" class="btn btn-outline-primary mt-3">
                        ⚡ Générer le titre & la description
                    </button>

                    <div id="ai_variants" class="mt-2" style="display:none;">
                        <small class="text-muted">Autres variantes de titre :</small>
                        <div id="ai_variant_list" class="mt-1"></div>
                    </div>
                </div>
            </div>
            {{-- AI block end (EDIT) --}}

            <div class="mt-3">
                <label for="description" class="form-label modal-body-text">Description</label>
                <textarea class="form-control modal-body-text @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="image" class="form-label modal-body-text">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="form-text text-muted modal-body-text">Formats: JPG, PNG, GIF, WebP. Max: 4MB</small>
                    <div class="mt-2" id="currentImageContainer" style="display: none;">
                        <img id="currentImagePreview" src="" alt="" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="is_active" class="form-label modal-body-text">Statut</label>
                    <div class="form-check form-switch mt-2">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1">
                        <label class="form-check-label modal-body-text" for="is_active">Actif</label>
                    </div>
                </div>
            </div>

            <div class="modal-footer book-detail-footer mt-4">
                <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<!-- Show template -->
<div id="showEventModalContent" style="display: none;">
    <div class="modal-body p-4">
        <div class="row">
            <div class="col-lg-4 text-center">
                <img id="event-image" src="" alt="Event image" class="img-fluid rounded mb-3 d-none" style="max-height: 200px;">
                <div id="event-image-placeholder" class="text-center p-5 bg-light rounded mb-3">
                    <i class="fas fa-image fa-3x text-gray-400"></i>
                    <p class="mt-2 text-gray-500 modal-body-text">Aucune image disponible</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="mb-4">
                    <h6 class="m-0 font-weight-bold text-primary modal-body-text">Informations</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th class="modal-body-text" style="width:30%">ID</th><td class="modal-body-text" id="event-id"></td></tr>
                                <tr><th class="modal-body-text">Titre</th><td class="modal-body-text" id="event-title"></td></tr>
                                <tr><th class="modal-body-text">Date de début</th><td class="modal-body-text" id="event-start-date"></td></tr>
                                <tr><th class="modal-body-text">Date de fin</th><td class="modal-body-text" id="event-end-date"></td></tr>
                                <tr><th class="modal-body-text">Lieu</th><td class="modal-body-text" id="event-location"></td></tr>
                                <tr><th class="modal-body-text">Statut</th><td class="modal-body-text" id="event-status"></td></tr>
                                <tr><th class="modal-body-text">Créé le</th><td class="modal-body-text" id="event-created-at"></td></tr>
                                <tr><th class="modal-body-text">Dernière modification</th><td class="modal-body-text" id="event-updated-at"></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
    // Auto-submit filters (page refresh on input/change)
    (function () {
        const form = document.getElementById('filterForm');
        let timer = null;
        const search = document.getElementById('search');
        if (search) {
            search.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(() => form.submit(), 200);
            });
        }
        ['status', 'date_from', 'date_to'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('change', () => form.submit());
        });
    })();

    // Display selected file name (if using custom-file inputs)
    $(document).on('change', '.custom-file-input', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    // Open modal (create / edit / show)
    $(document).on('click', '.open-event-modal', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        var title = $(this).data('title');

        $('#eventModalLabel').text(title);
        $('#eventModalBody').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
        $('#eventModal').modal('show');

        if (url.includes('admin/events/create')) {
            $('#eventModalBody').html($('#createEventModalContent').html());
            if (typeof CKEDITOR !== 'undefined') {
                for (var instanceName in CKEDITOR.instances) { CKEDITOR.instances[instanceName].destroy(true); }
                CKEDITOR.replace('description');
            }
        } else {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (url.includes('/edit')) {
                        $('#eventModalBody').html($('#editEventModalContent').html());
                        var event = response.event || {};
                        if (event.id) $('#editEventForm').attr('action', '/admin/events/' + event.id);
                        $('#editEventForm #title').val(event.title || '');
                        $('#editEventForm #location').val(event.location || '');
                        $('#editEventForm #start_date').val(event.start_date ? new Date(event.start_date).toISOString().slice(0, 16) : '');
                        $('#editEventForm #end_date').val(event.end_date ? new Date(event.end_date).toISOString().slice(0, 16) : '');
                        if (event.image || event.image_url) {
                            var preview = event.image_url ? event.image_url : ('/storage/' + event.image);
                            $('#editEventForm #currentImagePreview').attr('src', preview);
                            $('#editEventForm #currentImageContainer').show();
                        } else {
                            $('#editEventForm #currentImageContainer').hide();
                        }
                        $('#editEventForm #is_active').prop('checked', !!event.is_active);
                        if (typeof CKEDITOR !== 'undefined') {
                            for (var instanceName in CKEDITOR.instances) { CKEDITOR.instances[instanceName].destroy(true); }
                            CKEDITOR.replace('description');
                        }
                    } else {
                        $('#eventModalBody').html($('#showEventModalContent').html());
                        var event = response.event || {};
                        $('#showEventModalContent #event-id').text(event.id || '');
                        $('#showEventModalContent #event-title').text(event.title || '');
                        $('#showEventModalContent #event-start-date').text(event.start_date ? new Date(event.start_date).toLocaleString() : 'Non spécifiée');
                        $('#showEventModalContent #event-end-date').text(event.end_date ? new Date(event.end_date).toLocaleString() : 'Non spécifiée');
                        $('#showEventModalContent #event-location').text(event.location || 'Non spécifié');
                        var statusBadge = '<span class="badge ' + (event.is_active ? 'bg-success' : 'bg-danger') + ' p-2">' + (event.is_active ? 'Actif' : 'Inactif') + '</span>';
                        $('#showEventModalContent #event-status').html(statusBadge);
                        $('#showEventModalContent #event-created-at').text(event.created_at ? new Date(event.created_at).toLocaleString() : '');
                        $('#showEventModalContent #event-updated-at').text(event.updated_at ? new Date(event.updated_at).toLocaleString() : '');
                        $('#showEventModalContent #event-description').html(event.description || '<p class="text-muted">Aucune description disponible</p>');
                        if (event.image || event.image_url) {
                            var imageUrl = event.image_url ? event.image_url : ('/storage/' + event.image);
                            $('#showEventModalContent #event-image').attr('src', imageUrl).removeClass('d-none');
                            $('#showEventModalContent #event-image-placeholder').addClass('d-none');
                        } else {
                            $('#showEventModalContent #event-image').attr('src', '').addClass('d-none');
                            $('#showEventModalContent #event-image-placeholder').removeClass('d-none');
                        }
                    }
                },
                error: function() {
                    $('#eventModalBody').html('<div class="alert alert-danger">Impossible de charger le contenu.</div>');
                }
            });
        }
    });

    // Delete confirm
    $(document).on('click', '.delete-event-btn', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
            form.submit();
        }
    });

    // Select-all checkboxes
    $(document).on('change', '#selectAllEvents', function() {
        var checked = $(this).is(':checked');
        $(this).closest('table').find('tbody input.form-check-input[type="checkbox"]').prop('checked', checked);
    });

    // Open "participants" in the same modal (AJAX-loaded partial)
    $(document).on('click', '.open-participants-modal', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        var title = $(this).data('title') || 'Participants';

        $('#eventModalLabel').text(title);
        $('#eventModalBody').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
        $('#eventModal').modal('show');

        $.get(url, function (html) {
            $('#eventModalBody').html(html);
        }).fail(function () {
            $('#eventModalBody').html('<div class="alert alert-danger m-3">Impossible de charger les participants.</div>');
        });
    });

    // =========================
    // AI Generator (delegated)
    // =========================
    $(document).on('click', '#ai_generate', async function () {
        const kw = ($('#ai_keywords').val() || '')
            .split(',').map(s => s.trim()).filter(Boolean);

        const payload = {
            keywords: kw,
            audience: $('#ai_audience').val(),
            tone: $('#ai_tone').val(),
            lang: $('#ai_lang').val(),
            length: $('#ai_length').val(),
            start_date: $('#eventModalBody #start_date').val() || null,
            end_date:   $('#eventModalBody #end_date').val() || null,
            location:   $('#eventModalBody #location').val() || null
        };

        try {
            const res = await fetch("{{ route('admin.events.ai.generate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('Réponse invalide du serveur');
            const data = await res.json();

            // If CKEditor is used, update its instance; else, update textarea value
            if (data.title) { $('#eventModalBody #title').val(data.title); }

            if (data.description) {
                if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['description']) {
                    CKEDITOR.instances['description'].setData(data.description);
                } else {
                    $('#eventModalBody #description').val(data.description);
                }
            }

            const $box = $('#ai_variants');
            const $list = $('#ai_variant_list');
            $list.empty();
            if (data.variants && data.variants.length > 1) {
                $box.show();
                data.variants.forEach(t => {
                    const btn = $('<button/>', {
                        type: 'button',
                        class: 'btn btn-sm btn-light me-2 mb-2',
                        text: t,
                        click: () => $('#eventModalBody #title').val(t)
                    });
                    $list.append(btn);
                });
            } else {
                $box.hide();
            }
        } catch (e) {
            alert('Impossible de générer le titre/description. Réessayez.');
            console.error(e);
        }
    });
</script>
@endpush

@extends('layouts.admin')

@section('title', 'Nouvelle Catégorie')

@push('styles')
<style>
    .form-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #2E4A5B 0%, #D16655 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .form-body {
        padding: 2rem;
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #D16655;
        box-shadow: 0 0 0 0.2rem rgba(209, 102, 85, 0.25);
    }
    
    .color-picker {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .color-option {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 3px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .color-option:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .color-option.selected {
        border-color: white;
        box-shadow: 0 0 0 4px #D16655;
        transform: scale(1.1);
    }
    
    .icon-picker {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        max-height: 400px;
        overflow-y: auto;
    }
    
    .icon-option {
        padding: 1rem;
        text-align: center;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    
    .icon-option:hover {
        border-color: #D16655;
        transform: translateY(-2px);
    }
    
    .icon-option.selected {
        border-color: #D16655;
        background-color: #D16655;
        color: white;
    }
    
    .icon-option i {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .preview-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 2px solid #e9ecef;
    }
    
    .preview-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #D16655 0%, #e07565 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(209, 102, 85, 0.3);
    }
    
    .btn-cancel {
        background: linear-gradient(135deg, #6c757d 0%, #868e96 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-cancel:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="form-container">
                <div class="form-header">
                    <h1 class="mb-2">
                        <i class="fas fa-plus-circle me-3"></i>Créer une Nouvelle Catégorie
                    </h1>
                    <p class="mb-0 opacity-90">Ajoutez une nouvelle catégorie de livres à votre plateforme</p>
                </div>

                <div class="form-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Nom de la catégorie -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-tag me-2 text-primary"></i>Nom de la catégorie
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           maxlength="10"
                                           placeholder="Ex: Romance, Science-Fiction..."
                                           required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Maximum 10 caractères, lettres uniquement
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold">
                                        <i class="fas fa-align-left me-2 text-success"></i>Description
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3"
                                              maxlength="255"
                                              placeholder="Décrivez cette catégorie...">{{ old('description') }}</textarea>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Optionnel - Maximum 255 caractères
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Couleur -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-palette me-2 text-warning"></i>Couleur de la catégorie
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="color-picker">
                                        @foreach($colors as $colorValue => $colorName)
                                            <div class="color-option" 
                                                 style="background-color: {{ $colorValue }}"
                                                 data-color="{{ $colorValue }}"
                                                 title="{{ $colorName }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="color" value="{{ old('color', '#D16655') }}" required>
                                    @error('color')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Icône -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-icons me-2 text-info"></i>Icône de la catégorie
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="icon-picker">
                                        @foreach($icons as $iconClass => $iconName)
                                            <div class="icon-option" 
                                                 data-icon="{{ $iconClass }}">
                                                <i class="{{ $iconClass }}"></i>
                                                <small>{{ $iconName }}</small>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="icon" value="{{ old('icon', 'fas fa-book') }}" required>
                                    @error('icon')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Statut -->
                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">
                                            <i class="fas fa-toggle-on me-2 text-success"></i>Catégorie active
                                        </label>
                                        <div class="form-text">
                                            Les catégories actives sont visibles sur le site public
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Aperçu -->
                                <div class="preview-card sticky-top">
                                    <h5 class="mb-3">
                                        <i class="fas fa-eye me-2"></i>Aperçu
                                    </h5>
                                    
                                    <div class="preview-content">
                                        <div class="d-flex align-items-center mb-3">
                                            <div id="preview-icon" class="preview-icon" style="background-color: #D16655">
                                                <i class="fas fa-book"></i>
                                            </div>
                                            <div>
                                                <h6 id="preview-name" class="mb-0">Nom de la catégorie</h6>
                                                <small class="text-muted">Catégorie</small>
                                            </div>
                                        </div>
                                        
                                        <div id="preview-description" class="text-muted mb-3">
                                            Description de la catégorie...
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span id="preview-status" class="badge bg-success">Active</span>
                                            <small class="text-muted">
                                                Par {{ Auth::user()->name }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-3 justify-content-center">
                                    <a href="{{ route('admin.categories.index') }}" 
                                       class="btn-cancel">
                                        <i class="fas fa-times me-2"></i>Annuler
                                    </a>
                                    <button type="submit" class="btn-submit">
                                        <i class="fas fa-save me-2"></i>Créer la catégorie
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const colorInput = document.querySelector('input[name="color"]');
    const iconInput = document.querySelector('input[name="icon"]');
    const statusInput = document.getElementById('is_active');
    
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewIcon = document.getElementById('preview-icon');
    const previewIconElement = previewIcon.querySelector('i');
    const previewStatus = document.getElementById('preview-status');
    
    // Gestion des couleurs
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            colorInput.value = this.dataset.color;
            updatePreview();
        });
        
        // Sélectionner la couleur par défaut
        if (option.dataset.color === colorInput.value) {
            option.classList.add('selected');
        }
    });
    
    // Gestion des icônes
    document.querySelectorAll('.icon-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            iconInput.value = this.dataset.icon;
            updatePreview();
        });
        
        // Sélectionner l'icône par défaut
        if (option.dataset.icon === iconInput.value) {
            option.classList.add('selected');
        }
    });
    
    // Mise à jour de l'aperçu
    function updatePreview() {
        previewName.textContent = nameInput.value || 'Nom de la catégorie';
        previewDescription.textContent = descriptionInput.value || 'Description de la catégorie...';
        previewIcon.style.backgroundColor = colorInput.value;
        previewIconElement.className = iconInput.value;
        
        if (statusInput.checked) {
            previewStatus.textContent = 'Active';
            previewStatus.className = 'badge bg-success';
        } else {
            previewStatus.textContent = 'Inactive';
            previewStatus.className = 'badge bg-danger';
        }
    }
    
    // Écouteurs d'événements
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    statusInput.addEventListener('change', updatePreview);
    
    // Validation du nom (seulement lettres)
    nameInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
    });
    
    // Initialiser l'aperçu
    updatePreview();
});
</script>
@endpush
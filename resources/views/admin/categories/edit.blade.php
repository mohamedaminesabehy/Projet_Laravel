@extends('layouts.admin')

@section('title', 'Modifier Catégorie - ' . $category->name)

@push('styles')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        @section('content')
<div class="container-fluid py-4">;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-header {
        background: linear-gradient(135deg, #D16655, #BD7579);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .form-body {
        padding: 3rem 2rem;
    }
    
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }
    
    .form-label {
        color: #2E4A5B;
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-control {
        border-radius: 15px;
        border: 2px solid #F8EBE5;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fdfcfb;
    }
    
    .form-control:focus {
        border-color: #D16655;
        box-shadow: 0 0 0 0.25rem rgba(209, 102, 85, 0.15);
        background-color: white;
    }
    
    .form-control.is-invalid {
        border-color: #BD7579;
        box-shadow: 0 0 0 0.25rem rgba(189, 117, 121, 0.15);
    }
    
    .invalid-feedback {
        color: #BD7579;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    
    .color-picker {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 0.75rem;
        margin-top: 0.75rem;
    }
    
    .color-option {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 3px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .color-option:hover {
        transform: scale(1.1);
        border-color: #2E4A5B;
    }
    
    .color-option.selected {
        border-color: #2E4A5B;
        transform: scale(1.15);
        box-shadow: 0 4px 15px rgba(46, 74, 91, 0.3);
    }
    
    .color-option.selected::after {
        content: '✓';
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    
    .icon-picker {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 0.75rem;
        margin-top: 0.75rem;
        max-height: 300px;
        overflow-y: auto;
        padding: 0.5rem;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .icon-option {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        border: 2px solid transparent;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #6c757d;
    }
    
    .icon-option:hover {
        border-color: #D16655;
        background: #F8EBE5;
        transform: scale(1.05);
    }
    
    .icon-option.selected {
        border-color: #D16655;
        background: #D16655;
        color: white;
        transform: scale(1.1);
    }
    
    .preview-section {
        background: linear-gradient(135deg, #F8EBE5, #f0f9ff);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
        border: 2px dashed #D16655;
    }
    
    .preview-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1rem;
        transition: all 0.3s ease;
    }
    
    .preview-name {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2E4A5B;
        margin-bottom: 0.5rem;
    }
    
    .preview-description {
        color: #6c757d;
        font-style: italic;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #D16655, #BD7579);
        border: none;
        border-radius: 25px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #BD7579, #D16655);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(209, 102, 85, 0.3);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        border: none;
        border-radius: 25px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(108, 117, 125, 0.3);
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .character-count {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 0.875rem;
        pointer-events: none;
    }
    
    .character-count.warning {
        color: #fd7e14;
    }
    
    .character-count.danger {
        color: #BD7579;
    }
    
    @media (max-width: 768px) {
        .form-body {
            padding: 2rem 1rem;
        }
        
        .color-picker,
        .icon-picker {
            grid-template-columns: repeat(6, 1fr);
        }
        
        .form-actions {
            flex-direction: column;
        }
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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.categories.show', $category) }}">{{ $category->name }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Modifier</li>
        </ol>
    </nav>

    <div class="form-card">
        <!-- Header -->
        <div class="form-header">
            <h1 class="mb-0">
                <i class="fas fa-edit me-2"></i>
                Modifier la Catégorie
            </h1>
            <p class="mb-0 mt-2 opacity-90">Modifiez les informations de la catégorie</p>
        </div>

        <!-- Formulaire -->
        <div class="form-body">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <!-- Aperçu en temps réel -->
                <div class="preview-section">
                    <div class="preview-icon" id="preview-icon" style="background: {{ old('color', $category->color) }}">
                        <i class="{{ old('icon', $category->icon) }}" id="preview-icon-class"></i>
                    </div>
                    <div class="preview-name" id="preview-name">
                        {{ old('name', $category->name) ?: 'Nom de la catégorie' }}
                    </div>
                    <div class="preview-description" id="preview-description">
                        {{ old('description', $category->description) ?: 'Description de la catégorie' }}
                    </div>
                </div>

                <!-- Nom -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-tag"></i>
                        Nom de la catégorie *
                    </label>
                    <div class="position-relative">
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name) }}"
                               maxlength="20"
                               pattern="[A-Za-zÀ-ÿ\s]+"
                               title="Seules les lettres et les espaces sont autorisés"
                               required>
                        <span class="character-count" id="name-count">{{ strlen(old('name', $category->name)) }}/20</span>
                    </div>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Seules les lettres et espaces sont autorisés (max 20 caractères)</small>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">
                        <i class="fas fa-align-left"></i>
                        Description (optionnel)
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3"
                              maxlength="500">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Couleur -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-palette"></i>
                        Couleur *
                    </label>
                    <input type="hidden" name="color" id="color-input" value="{{ old('color', $category->color) }}" required>
                    <div class="color-picker">
                        @php
                            $colors = [
                                '#D16655', '#BD7579', '#2E4A5B', '#F8EBE5',
                                '#e74c3c', '#e67e22', '#f39c12', '#f1c40f',
                                '#2ecc71', '#27ae60', '#16a085', '#1abc9c',
                                '#3498db', '#2980b9', '#9b59b6', '#8e44ad',
                                '#34495e', '#2c3e50', '#95a5a6', '#7f8c8d',
                                '#e91e63', '#9c27b0', '#673ab7', '#3f51b5',
                                '#2196f3', '#03a9f4', '#00bcd4', '#009688',
                                '#4caf50', '#8bc34a', '#cddc39', '#ffeb3b'
                            ];
                        @endphp
                        @foreach($colors as $color)
                            <div class="color-option {{ old('color', $category->color) === $color ? 'selected' : '' }}" 
                                 style="background-color: {{ $color }}" 
                                 data-color="{{ $color }}"></div>
                        @endforeach
                    </div>
                    @error('color')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Icône -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-icons"></i>
                        Icône *
                    </label>
                    <input type="hidden" name="icon" id="icon-input" value="{{ old('icon', $category->icon) }}" required>
                    <div class="icon-picker">
                        @php
                            $icons = [
                                'fas fa-book', 'fas fa-bookmark', 'fas fa-heart', 'fas fa-star',
                                'fas fa-graduation-cap', 'fas fa-lightbulb', 'fas fa-music', 'fas fa-film',
                                'fas fa-gamepad', 'fas fa-palette', 'fas fa-camera', 'fas fa-microphone',
                                'fas fa-globe', 'fas fa-plane', 'fas fa-car', 'fas fa-home',
                                'fas fa-shopping-cart', 'fas fa-utensils', 'fas fa-coffee', 'fas fa-pizza-slice',
                                'fas fa-dumbbell', 'fas fa-running', 'fas fa-bicycle', 'fas fa-futbol',
                                'fas fa-leaf', 'fas fa-tree', 'fas fa-sun', 'fas fa-moon',
                                'fas fa-fire', 'fas fa-snowflake', 'fas fa-bolt', 'fas fa-rainbow',
                                'fas fa-gem', 'fas fa-crown', 'fas fa-magic', 'fas fa-rocket',
                                'fas fa-microscope', 'fas fa-flask', 'fas fa-dna', 'fas fa-atom',
                                'fas fa-calculator', 'fas fa-chart-bar', 'fas fa-briefcase', 'fas fa-tools',
                                'fas fa-puzzle-piece', 'fas fa-chess', 'fas fa-dice', 'fas fa-trophy'
                            ];
                        @endphp
                        @foreach($icons as $icon)
                            <div class="icon-option {{ old('icon', $category->icon) === $icon ? 'selected' : '' }}" 
                                 data-icon="{{ $icon }}">
                                <i class="{{ $icon }}"></i>
                            </div>
                        @endforeach
                    </div>
                    @error('icon')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="form-group">
                    <div class="form-check form-switch" style="padding-left: 3rem;">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active"
                               value="1"
                               style="width: 3em; height: 1.5em;"
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label form-label" for="is_active">
                            <i class="fas fa-toggle-on"></i>
                            Catégorie active
                        </label>
                    </div>
                    <small class="text-muted">Les catégories inactives ne sont pas visibles aux utilisateurs</small>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-save me-2"></i>
                        Mettre à jour
                    </button>
                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-secondary flex-fill">
                        <i class="fas fa-times me-2"></i>
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const colorInput = document.getElementById('color-input');
    const iconInput = document.getElementById('icon-input');
    
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewIcon = document.getElementById('preview-icon');
    const previewIconClass = document.getElementById('preview-icon-class');
    
    const nameCount = document.getElementById('name-count');
    const colorOptions = document.querySelectorAll('.color-option');
    const iconOptions = document.querySelectorAll('.icon-option');

    // Mise à jour du nom en temps réel
    nameInput.addEventListener('input', function() {
        const value = this.value.trim();
        const length = value.length;
        
        // Mise à jour du compteur
        nameCount.textContent = length + '/20';
        nameCount.className = 'character-count';
        
        if (length > 15) {
            nameCount.classList.add('warning');
        }
        if (length > 18) {
            nameCount.classList.add('danger');
        }
        
        // Mise à jour de l'aperçu
        previewName.textContent = value || 'Nom de la catégorie';
        
        // Validation temps réel
        const pattern = /^[A-Za-zÀ-ÿ\s]*$/;
        if (!pattern.test(value) && value !== '') {
            this.setCustomValidity('Seules les lettres et espaces sont autorisés');
        } else {
            this.setCustomValidity('');
        }
    });

    // Mise à jour de la description en temps réel
    descriptionInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewDescription.textContent = value || 'Description de la catégorie';
    });

    // Gestion des couleurs
    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            const color = this.dataset.color;
            
            // Mise à jour des sélections
            colorOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            
            // Mise à jour des inputs et aperçu
            colorInput.value = color;
            previewIcon.style.background = color;
        });
    });

    // Gestion des icônes
    iconOptions.forEach(option => {
        option.addEventListener('click', function() {
            const icon = this.dataset.icon;
            
            // Mise à jour des sélections
            iconOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            
            // Mise à jour des inputs et aperçu
            iconInput.value = icon;
            previewIconClass.className = icon;
        });
    });

    // Validation du formulaire
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const nameValue = nameInput.value.trim();
        
        if (!nameValue) {
            e.preventDefault();
            alert('Le nom de la catégorie est obligatoire');
            nameInput.focus();
            return;
        }
        
        if (!colorInput.value) {
            e.preventDefault();
            alert('Veuillez sélectionner une couleur');
            return;
        }
        
        if (!iconInput.value) {
            e.preventDefault();
            alert('Veuillez sélectionner une icône');
            return;
        }
    });

    // Initialisation de l'aperçu
    const initialName = nameInput.value || 'Nom de la catégorie';
    const initialDesc = descriptionInput.value || 'Description de la catégorie';
    previewName.textContent = initialName;
    previewDescription.textContent = initialDesc;
    
    // Mise à jour du compteur initial
    nameCount.textContent = nameInput.value.length + '/20';
});
</script>
@endpush
@endsection
<style>
    .edit-form-container {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .edit-preview-section {
        background: linear-gradient(135deg, #F8EBE5, #f0f9ff);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
        border: 2px dashed #D16655;
    }
    
    .edit-preview-icon {
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
    
    .edit-color-picker {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 0.5rem;
        margin-top: 0.75rem;
    }
    
    .edit-color-option {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 3px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .edit-color-option:hover {
        transform: scale(1.1);
        border-color: #2E4A5B;
    }
    
    .edit-color-option.selected {
        border-color: #2E4A5B;
        transform: scale(1.15);
        box-shadow: 0 4px 15px rgba(46, 74, 91, 0.3);
    }
    
    .edit-color-option.selected::after {
        content: '✓';
        color: white;
        font-weight: bold;
        font-size: 1rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    
    .edit-icon-picker {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 0.5rem;
        margin-top: 0.75rem;
        max-height: 200px;
        overflow-y: auto;
        padding: 0.5rem;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .edit-icon-option {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        border: 2px solid transparent;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #6c757d;
    }
    
    .edit-icon-option:hover {
        border-color: #D16655;
        background: #F8EBE5;
        transform: scale(1.05);
    }
    
    .edit-icon-option.selected {
        border-color: #D16655;
        background: #D16655;
        color: white;
        transform: scale(1.1);
    }
</style>

<form class="edit-form-container" id="editCategoryForm" action="/admin/categories/{{ $category->id }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Aperçu en temps réel -->
    <div class="edit-preview-section">
        <div class="edit-preview-icon" id="edit_preview_icon" style="background: {{ $category->color }}">
            <i class="{{ $category->icon }}" id="edit_preview_icon_class"></i>
        </div>
        <div class="fw-bold fs-5 text-dark mb-1" id="edit_preview_name">
            {{ $category->name ?: 'Nom de la catégorie' }}
        </div>
        <div class="text-muted fst-italic" id="edit_preview_description">
            {{ $category->description ?: 'Description de la catégorie' }}
        </div>
    </div>

    <!-- Nom -->
    <div class="mb-3">
        <label for="edit_name" class="form-label">
            <i class="fas fa-tag me-2"></i>Nom de la catégorie *
        </label>
        <input type="text" 
               class="form-control" 
               id="edit_name" 
               name="name" 
               value="{{ $category->name }}"
               maxlength="10"
               pattern="[A-Za-zÀ-ÿ\s]+"
               required>
        <small class="text-muted">Seules les lettres et espaces sont autorisés (max 10 caractères)</small>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="edit_description" class="form-label">
            <i class="fas fa-align-left me-2"></i>Description (optionnel)
        </label>
        <textarea class="form-control" 
                  id="edit_description" 
                  name="description" 
                  rows="3"
                  maxlength="500">{{ $category->description }}</textarea>
    </div>

    <!-- Couleur -->
    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-palette me-2"></i>Couleur *
        </label>
        <input type="hidden" name="color" id="edit_color" value="{{ $category->color }}" required>
        <div class="edit-color-picker">
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
                <div class="edit-color-option {{ $category->color === $color ? 'selected' : '' }}" 
                     style="background-color: {{ $color }}" 
                     data-color="{{ $color }}"></div>
            @endforeach
        </div>
    </div>

    <!-- Icône -->
    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-icons me-2"></i>Icône *
        </label>
        <input type="hidden" name="icon" id="edit_icon" value="{{ $category->icon }}" required>
        <div class="edit-icon-picker">
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
                    'fas fa-microscope', 'fas fa-flask', 'fas fa-dna', 'fas fa-atom'
                ];
            @endphp
            @foreach($icons as $icon)
                <div class="edit-icon-option {{ $category->icon === $icon ? 'selected' : '' }}" 
                     data-icon="{{ $icon }}">
                    <i class="{{ $icon }}"></i>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Statut -->
    <div class="mb-4">
        <div class="form-check form-switch">
            <input class="form-check-input" 
                   type="checkbox" 
                   id="edit_is_active" 
                   name="is_active"
                   value="1"
                   {{ $category->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="edit_is_active">
                <i class="fas fa-toggle-on me-2"></i>Catégorie active
            </label>
        </div>
        <small class="text-muted">Les catégories inactives ne sont pas visibles aux utilisateurs</small>
    </div>

    <!-- Actions -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success flex-fill">
            <i class="fas fa-save me-2"></i>Mettre à jour
        </button>
        <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i>Annuler
        </button>
    </div>
</form>
@extends('layouts.app')

@section('title', 'Modifier le Rendez-vous')

@section('content')
<style>
    .edit-meeting-container {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 30px 0;
    }
    
    .edit-form-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-title {
        font-size: 24px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-title i {
        color: #c9848f;
    }
    
    .info-box {
        background: #f8e8eb;
        border-left: 3px solid #c9848f;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 25px;
    }
    
    .info-box p {
        color: #5d4037;
        font-size: 14px;
        margin: 0;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 8px;
    }
    
    .form-label i {
        color: #c9848f;
        margin-right: 6px;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #c9848f;
        box-shadow: 0 0 0 3px rgba(201, 132, 143, 0.1);
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    
    .form-select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-size: 14px;
        background-color: white;
        cursor: pointer;
    }
    
    .form-select:focus {
        outline: none;
        border-color: #c9848f;
        box-shadow: 0 0 0 3px rgba(201, 132, 143, 0.1);
    }
    
    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }
    
    .btn {
        flex: 1;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        border: none;
    }
    
    .btn-primary {
        background: #c9848f;
        color: white;
    }
    
    .btn-primary:hover {
        background: #b67680;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(201, 132, 143, 0.3);
    }
    
    .btn-secondary {
        background: #6c757d;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
    }
</style>

<div class="edit-meeting-container">
<div class="container mx-auto px-4">
    <div class="edit-form-card">
        <h1 class="form-title">
            <i class="fas fa-edit"></i> Modifier le Rendez-vous
        </h1>

        <div class="info-box">
            <p>
                <i class="fas fa-info-circle"></i>
                <strong>Note :</strong> Vous pouvez modifier les détails de ce rendez-vous. Les deux participants seront informés des modifications.
            </p>
        </div>

        <form action="{{ route('meetings.update', $meeting->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Date -->
            <div class="form-group">
                <label for="meeting_date" class="form-label">
                    <i class="fas fa-calendar"></i>Date du rendez-vous *
                </label>
                <input type="date" 
                       id="meeting_date" 
                       name="meeting_date" 
                       min="{{ now()->toDateString() }}"
                       class="form-control @error('meeting_date') is-invalid @enderror"
                       value="{{ old('meeting_date', $meeting->meeting_date->format('Y-m-d')) }}"
                       required>
                @error('meeting_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Heure -->
            <div class="form-group">
                <label for="meeting_time" class="form-label">
                    <i class="fas fa-clock"></i>Heure du rendez-vous *
                </label>
                <input type="time" 
                       id="meeting_time" 
                       name="meeting_time" 
                       class="form-control @error('meeting_time') is-invalid @enderror"
                       value="{{ old('meeting_time', $meeting->meeting_time) }}"
                       required>
                @error('meeting_time')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Lieu -->
            <div class="form-group">
                <label for="meeting_place" class="form-label">
                    <i class="fas fa-map-marker-alt"></i>Lieu du rendez-vous *
                </label>
                <input type="text" 
                       id="meeting_place" 
                       name="meeting_place" 
                       placeholder="Ex: Café Central, Place de la République"
                       class="form-control @error('meeting_place') is-invalid @enderror"
                       value="{{ old('meeting_place', $meeting->meeting_place) }}"
                       required>
                @error('meeting_place')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Adresse complète -->
            <div class="form-group">
                <label for="meeting_address" class="form-label">
                    <i class="fas fa-location-arrow"></i>Adresse complète (optionnel)
                </label>
                <textarea id="meeting_address" 
                          name="meeting_address" 
                          rows="2"
                          placeholder="Ex: 123 Rue de la Paix, 75001 Paris"
                          class="form-control @error('meeting_address') is-invalid @enderror">{{ old('meeting_address', $meeting->meeting_address) }}</textarea>
                @error('meeting_address')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Livres -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-book"></i>Livres concernés (optionnel)
                </label>
                <div class="row" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div>
                        <label for="book1_id" style="font-size: 13px; color: #6c757d; margin-bottom: 5px; display: block;">Mon livre</label>
                        <select id="book1_id" name="book1_id" class="form-select">
                            <option value="">Aucun livre</option>
                            @foreach($myBooks as $book)
                                <option value="{{ $book->id }}" {{ old('book1_id', $meeting->book1_id) == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="book2_id" style="font-size: 13px; color: #6c757d; margin-bottom: 5px; display: block;">Livre de l'autre personne</label>
                        <select id="book2_id" name="book2_id" class="form-select">
                            <option value="">Aucun livre</option>
                            @foreach($otherUserBooks as $book)
                                <option value="{{ $book->id }}" {{ old('book2_id', $meeting->book2_id) == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label for="notes" class="form-label">
                    <i class="fas fa-sticky-note"></i>Notes supplémentaires (optionnel)
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="4"
                          placeholder="Ajoutez des notes ou instructions particulières..."
                          class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $meeting->notes) }}</textarea>
                @error('notes')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>Enregistrer les modifications
                </button>
                <a href="{{ route('meetings.show', $meeting->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>Annuler
                </a>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

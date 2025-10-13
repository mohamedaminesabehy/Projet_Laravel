@extends('layouts.app')

@section('title', 'Proposer un Rendez-vous')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- En-tête -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Proposer un Rendez-vous</h1>
            <a href="{{ route('pages.messages') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>

        <!-- Contexte de la conversation -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
            <p class="text-gray-700">
                <i class="fas fa-info-circle mr-2"></i>
                Vous proposez un rendez-vous à <strong>{{ $message->sender_id === Auth::id() ? $message->receiver->name : $message->sender->name }}</strong>
            </p>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('meetings.store') }}" method="POST" class="bg-white rounded-lg shadow-lg p-8">
            @csrf

            <input type="hidden" name="message_id" value="{{ $message->id }}">
            <input type="hidden" name="user2_id" value="{{ $message->sender_id === Auth::id() ? $message->receiver_id : $message->sender_id }}">

            <!-- Date -->
            <div class="mb-6">
                <label for="meeting_date" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-calendar mr-2"></i>Date du rendez-vous *
                </label>
                <input type="date" 
                       id="meeting_date" 
                       name="meeting_date" 
                       min="{{ now()->toDateString() }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meeting_date') border-red-500 @enderror"
                       value="{{ old('meeting_date') }}"
                       required>
                @error('meeting_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Heure -->
            <div class="mb-6">
                <label for="meeting_time" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-clock mr-2"></i>Heure du rendez-vous *
                </label>
                <input type="time" 
                       id="meeting_time" 
                       name="meeting_time" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meeting_time') border-red-500 @enderror"
                       value="{{ old('meeting_time') }}"
                       required>
                @error('meeting_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lieu -->
            <div class="mb-6">
                <label for="meeting_place" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>Lieu du rendez-vous *
                </label>
                <input type="text" 
                       id="meeting_place" 
                       name="meeting_place" 
                       placeholder="Ex: Café Central, Place de la République"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meeting_place') border-red-500 @enderror"
                       value="{{ old('meeting_place') }}"
                       required>
                @error('meeting_place')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Adresse complète (optionnelle) -->
            <div class="mb-6">
                <label for="meeting_address" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-location-arrow mr-2"></i>Adresse complète (optionnel)
                </label>
                <textarea id="meeting_address" 
                          name="meeting_address" 
                          rows="2"
                          placeholder="Ex: 123 Rue de la Paix, 75001 Paris"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meeting_address') border-red-500 @enderror">{{ old('meeting_address') }}</textarea>
                @error('meeting_address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sélection des livres -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-book mr-2"></i>Livres concernés (optionnel)
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Mon livre -->
                    <div>
                        <label for="book1_id" class="block text-sm text-gray-600 mb-2">Mon livre</label>
                        <select id="book1_id" 
                                name="book1_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Sélectionner --</option>
                            @foreach($myBooks as $book)
                                <option value="{{ $book->id }}" {{ old('book1_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Livre de l'autre personne -->
                    <div>
                        <label for="book2_id" class="block text-sm text-gray-600 mb-2">Livre de {{ $message->sender_id === Auth::id() ? $message->receiver->name : $message->sender->name }}</label>
                        <select id="book2_id" 
                                name="book2_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Sélectionner --</option>
                            @foreach($otherUserBooks as $book)
                                <option value="{{ $book->id }}" {{ old('book2_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Notes ou instructions (optionnel)
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="4"
                          placeholder="Ex: Je serai en pull rouge, j'arriverai avec mon vélo..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                    <i class="fas fa-paper-plane mr-2"></i>Proposer le rendez-vous
                </button>
                <a href="{{ route('pages.messages') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

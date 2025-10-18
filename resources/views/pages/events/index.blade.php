@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="container py-5">
    <h1 class="mb-5 text-center fw-bold text-primary">🌟 Upcoming Events</h1>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($events->isEmpty())
        <p class="text-center text-muted fs-5">No events available at the moment.</p>
    @else
        <div class="row g-4">
            @foreach($events as $event)
                @php
    $alreadyJoined = auth()->check()
        ? \App\Models\Participation::active()
            ->where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->exists()
        : false;
@endphp

                <div class="col-md-4">
                    <div class="card shadow-lg border-0 h-100 rounded-4 overflow-hidden hover-shadow">
                        {{-- Event image --}}
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" 
                                 class="card-img-top object-fit-cover" 
                                 alt="{{ $event->title }}" 
                                 style="height: 200px; width: 100%;">
                        @else
                            <img src="{{ asset('images/default-event.jpg') }}" 
                                 class="card-img-top object-fit-cover" 
                                 alt="Default event image" 
                                 style="height: 200px; width: 100%;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-dark fw-semibold">{{ $event->title }}</h5>
                            <p class="card-text text-muted small mb-2">
                                {{ Str::limit(strip_tags($event->description), 100) }}
                            </p>

                            <ul class="list-unstyled small text-secondary mb-3">
                                <li><strong>📅 Start:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}</li>
                                <li><strong>🏁 End:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}</li>
                                <li><strong>📍 Location:</strong> {{ $event->location ?? '—' }}</li>
                            </ul>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                

                                @auth
                                    @if($alreadyJoined)
                                        {{-- LEAVE --}}
                                        <form action="{{ route('events.leave', $event) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                Leave
                                            </button>
                                        </form>
                                    @else
                                        {{-- JOIN --}}
                                        <form action="{{ route('events.join', $event) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Join
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('signin') }}" class="btn btn-secondary btn-sm">
                                        Join
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
    @endif
</div>

{{-- Optional Hover Animation --}}
<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
</style>
@endsection

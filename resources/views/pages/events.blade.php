@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Upcoming Events</h1>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($events->isEmpty())
        <p class="text-center text-muted">No events available at the moment.</p>
    @else
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($event->description, 100) }}</p>
                            <p class="small mb-1"><strong>Start:</strong> {{ $event->start_date }}</p>
                            <p class="small mb-1"><strong>End:</strong> {{ $event->end_date }}</p>
                            <p class="small"><strong>Location:</strong> {{ $event->location }}</p>

                            {{-- Button Section --}}
                            <div class="mt-3">
                                @auth
                                    @php
                                        $alreadyJoined = $event->participants->contains(auth()->id());
                                    @endphp

                                    @if($alreadyJoined)
                                        <form action="{{ route('events.leave', $event) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Leave Event</button>
                                        </form>
                                    @else
                                        <form action="{{ route('events.join', $event) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Join Event</button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('signin') }}" class="btn btn-secondary btn-sm">Sign in to join</a>
                                @endauth

                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm ms-2">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection

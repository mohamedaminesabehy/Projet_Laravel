@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Upcoming Events</h1>

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
                            <p class="card-text text-muted">
                                {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 100) }}
                            </p>
                            <p class="small mb-1"><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}</p>
                            @if($event->end_date)
                                <p class="small mb-1"><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}</p>
                            @endif
                            <p class="small"><strong>Location:</strong> {{ $event->location }}</p>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm">View Details</a>
                            <a href="{{ route('events.join', $event->id) }}" class="btn btn-success btn-sm mt-2">Join Event</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection

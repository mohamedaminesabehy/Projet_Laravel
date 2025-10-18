@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-3">{{ $event->title }}</h1>
            <p class="text-muted">
                <strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}
                @if($event->end_date)
                    &nbsp; | &nbsp; <strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}
                @endif
                &nbsp; | &nbsp; <strong>Location:</strong> {{ $event->location }}
            </p>
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="img-fluid rounded mb-4">
            @endif
            <div>{!! $event->description !!}</div>
        </div>
        <div class="col-md-4">
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary mb-3">&larr; Back to Events</a>
        </div>
    </div>
</div>
@endsection

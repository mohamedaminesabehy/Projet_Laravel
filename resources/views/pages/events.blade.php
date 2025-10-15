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
                            <p class="card-text text-muted">{{ Str::limit($event->description, 100) }}</p>
                            <p class="small mb-1"><strong>Date:</strong> {{ $event->date }}</p>
                            <p class="small"><strong>Location:</strong> {{ $event->location }}</p>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach

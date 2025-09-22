@extends('layouts.app')

@section('content')
    <style>
        .fav-hero{background:linear-gradient(180deg,#f4f7ff 0%,#eef5ff 100%)}
        .fav-card{background:#fff;border:1px solid rgba(17,38,65,.08);box-shadow:0 12px 30px rgba(17,38,65,.08);border-radius:16px}
        .fav-item{transition:transform .2s ease, box-shadow .2s ease}
        .fav-item:hover{transform:translateY(-4px);box-shadow:0 10px 24px rgba(2,6,23,.12)}
        .fav-cover{width:100%;height:200px;object-fit:cover;border-radius:10px}
    </style>
    <!-- Breadcrumb -->
    <section class="py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa-solid fa-house me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Favorites</li>
                </ol>
            </nav>
        </div>
    </section>

    <main>
        <section class="py-80 fav-hero">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="p-4 p-md-5 fav-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h1 class="h4 mb-1">Your Favorites</h1>
                                    <p class="mb-0 text-muted">Saved books you love</p>
                                </div>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to Home</a>
                            </div>
                            <div class="row g-4">
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="fav-item p-3 border rounded-3 h-100">
                                        <img src="{{ asset('assets/img/product/prod-1-1.png') }}" alt="Book" class="fav-cover mb-3">
                                        <h6 class="mb-1">The Great Adventure</h6>
                                        <p class="text-muted small mb-2">by Jane Writer</p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('shop-details') }}" class="vs-btn">View</a>
                                            <button class="btn btn-outline-danger"><i class="fa-regular fa-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="fav-item p-3 border rounded-3 h-100">
                                        <img src="{{ asset('assets/img/product/prod-1-2.png') }}" alt="Book" class="fav-cover mb-3">
                                        <h6 class="mb-1">Designing Stories</h6>
                                        <p class="text-muted small mb-2">by Mark Pages</p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('shop-details') }}" class="vs-btn">View</a>
                                            <button class="btn btn-outline-danger"><i class="fa-regular fa-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="fav-item p-3 border rounded-3 h-100">
                                        <img src="{{ asset('assets/img/product/prod-1-3.png') }}" alt="Book" class="fav-cover mb-3">
                                        <h6 class="mb-1">UX for Readers</h6>
                                        <p class="text-muted small mb-2">by Lina Type</p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('shop-details') }}" class="vs-btn">View</a>
                                            <button class="btn btn-outline-danger"><i class="fa-regular fa-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="fav-item p-3 border rounded-3 h-100">
                                        <img src="{{ asset('assets/img/product/prod-1-4.png') }}" alt="Book" class="fav-cover mb-3">
                                        <h6 class="mb-1">Code & Chapters</h6>
                                        <p class="text-muted small mb-2">by Dev Script</p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('shop-details') }}" class="vs-btn">View</a>
                                            <button class="btn btn-outline-danger"><i class="fa-regular fa-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

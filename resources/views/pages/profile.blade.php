@extends('layouts.app')

@section('content')
<section class="py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"><i class="fa-solid fa-house me-1"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</section>

<main>
    <section class="py-80 profile-hero">
        <div class="container">
            <div class="row g-4">

                <!-- Sidebar Profil -->
                <div class="col-lg-4">
                    <aside class="profile-card p-4 profile-sidebar text-center">
                        <div class="avatar mb-3" style="font-size:60px; background:#f3f4f6; border-radius:50%; width:120px; height:120px; display:flex; align-items:center; justify-content:center;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <h2 class="h5 mb-1">{{ Auth::user()->name }}</h2>
                        <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                        <a href="{{ route('profile') }}#settings" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-user-pen me-1"></i>Edit Profile
                        </a>
                    </aside>
                </div>

                <!-- Contenu principal -->
                <div class="col-lg-8">
                    <div class="profile-card p-4 p-md-5">
                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                                    <i class="fa-regular fa-user me-1"></i>Overview
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">
                                    <i class="fa-regular fa-gear me-1"></i>Settings
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">
                                    <i class="fa-regular fa-shield-check me-1"></i>Security
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content pt-4" id="profileTabsContent">
                            <!-- Overview -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                <h3 class="h5 mb-2">About</h3>
                                <p class="text-muted mb-3">Email: {{ Auth::user()->email }}</p>
                                <ul class="list-check mb-0">
                                    <li><i class="fa-solid fa-check"></i> Member since <span class="badge-soft">{{ Auth::user()->created_at->format('Y-m-d') }}</span></li>
                                </ul>
                            </div>

                            <!-- Settings -->
                            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <button type="submit" class="vs-btn"><i class="fa-regular fa-floppy-disk me-1"></i>Save changes</button>
                                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Security -->
                            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <form action="{{ route('profile.updatePassword') }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Current password</label>
                                            <input type="password" class="form-control" name="current_password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">New password</label>
                                            <input type="password" class="form-control" name="new_password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Confirm new password</label>
                                            <input type="password" class="form-control" name="new_password_confirmation" required>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <button type="submit" class="vs-btn"><i class="fa-regular fa-lock-keyhole me-1"></i>Update password</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection

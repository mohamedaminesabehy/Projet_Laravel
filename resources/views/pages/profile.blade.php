@extends('layouts.app')

@section('content')
    <section class="py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa-solid fa-house me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </section>

    <main>
        <section class="py-80 profile-hero">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <aside class="profile-card p-4 profile-sidebar">
                            <div class="text-center">
                                <div class="avatar-upload-wrapper mb-3">
                                    <img src="{{ asset('assets/img/profile.avif') }}" alt="Avatar" class="avatar mb-3">
                                    <label for="avatar-upload" class="avatar-upload-icon"><i class="fa-solid fa-camera"></i></label>
                                    <input type="file" id="avatar-upload" class="d-none">
                                </div>
                                <h2 class="h5 mb-1">John Doe</h2>
                                <p class="text-muted mb-3">Book Enthusiast</p>
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="stat-badge"><i class="fa-regular fa-bookmark"></i> 24 Favorites</span>
                                    <span class="stat-badge" style="background:#ecfeff;color:#0369a1"><i class="fa-regular fa-comment"></i> 12 Reviews</span>
                                </div>
                                <a href="{{ route('profile') }}#settings" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-user-pen me-1"></i>Edit Profile</a>
                            </div>
                            <hr class="my-4">
                        </aside>
                    </div>
                    <div class="col-lg-8">
                        <div class="profile-card p-4 p-md-5">
                            <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true"><i class="fa-regular fa-user me-1"></i>Overview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false"><i class="fa-regular fa-gear me-1"></i>Settings</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false"><i class="fa-regular fa-shield-check me-1"></i>Security</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="addresses-tab" data-bs-toggle="tab" data-bs-target="#addresses" type="button" role="tab" aria-controls="addresses" aria-selected="false"><i class="fa-regular fa-location-dot me-1"></i>Addresses</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="review-history-tab" data-bs-toggle="tab" data-bs-target="#review-history" type="button" role="tab" aria-controls="review-history" aria-selected="false"><i class="fa-regular fa-comment me-1"></i>Review History</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="my-books-tab" data-bs-toggle="tab" data-bs-target="#my-books" type="button" role="tab" aria-controls="my-books" aria-selected="false"><i class="fa-solid fa-book me-1"></i>My Books</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-4" id="profileTabsContent">
                                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-md-7">
                                            <h3 class="h5 mb-2">About</h3>
                                            <p class="text-muted mb-3">Avid reader and passionate about sharing great books with friends. Loves design, technology, and sci‑fi.</p>
                                            <ul class="list-check mb-0">
                                                <li><i class="fa-solid fa-check"></i> Member since <span class="badge-soft">2023</span></li>
                                                <li><i class="fa-solid fa-check"></i> 50+ books purchased</li>
                                                <li><i class="fa-solid fa-check"></i> 12 verified reviews</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0">
                                                <h6 class="mb-2"><i class="fa-regular fa-trophy me-1"></i>Badges</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge-soft"><i class="fa-regular fa-star me-1"></i> Top Reviewer</span>
                                                    <span class="badge-soft"><i class="fa-regular fa-book-open me-1"></i> Storyteller</span>
                                                    <span class="badge-soft"><i class="fa-regular fa-users me-1"></i> Community</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                    <form class="mt-2">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">First name</label>
                                                <input type="text" class="form-control" placeholder="John">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Last name</label>
                                                <input type="text" class="form-control" placeholder="Doe">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" placeholder="name@example.com">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Phone</label>
                                                <input type="text" class="form-control" placeholder="+216 00 000 000">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Bio</label>
                                                <textarea class="form-control" rows="3" placeholder="Tell others about your favorite books..."></textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 mt-3">
                                            <button type="submit" class="vs-btn"><i class="fa-regular fa-floppy-disk me-1"></i>Save changes</button>
                                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                    <form class="mt-2">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Current password</label>
                                                <input type="password" class="form-control" placeholder="••••••••">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">New password</label>
                                                <input type="password" class="form-control" placeholder="Create a strong password">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Confirm new password</label>
                                                <input type="password" class="form-control" placeholder="Repeat new password">
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 mt-3">
                                            <button type="submit" class="vs-btn"><i class="fa-regular fa-lock-keyhole me-1"></i>Update password</button>
                                            <button type="button" class="btn btn-outline-danger"><i class="fa-regular fa-right-from-bracket me-1"></i>Logout all devices</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                            <div class="p-3 border rounded-3 h-100">
                                                <h6 class="mb-1"><i class="fa-regular fa-location-dot me-1"></i>Default Shipping</h6>
                                                <p class="text-muted mb-2">32/65 Willow Creek<br>Colorado, USA</p>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-regular fa-pen-to-square me-1"></i>Edit</button>
                                                    <button class="btn btn-outline-danger btn-sm"><i class="fa-regular fa-trash-can"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 border rounded-3 h-100">
                                                <h6 class="mb-1"><i class="fa-regular fa-location-dot me-1"></i>Billing</h6>
                                                <p class="text-muted mb-2">221B Baker Street<br>London, UK</p>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-regular fa-pen-to-square me-1"></i>Edit</button>
                                                    <button class="btn btn-outline-danger btn-sm"><i class="fa-regular fa-trash-can"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="review-history" role="tabpanel" aria-labelledby="review-history-tab">
                                    @include('pages.profile.review-history')
                                </div>
                                <div class="tab-pane fade" id="my-books" role="tabpanel" aria-labelledby="my-books-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-sm">
                                                <div class="card-header bg-white border-0">
                                                    <h5 class="mb-0">My Books</h5>
                                                </div>
                                                <div class="card-body">
                                                    @if ($user->books->count() > 0)
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Category</th>
                                                                    <th>Price</th>
                                                                    <th>Stock</th>
                                                                    <th>Status</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($user->books as $book)
                                                                    <tr>
                                                                        <td>{{ $book->title }}</td>
                                                                        <td>{{ $book->category->name ?? 'N/A' }}</td>
                                                                        <td>{{ $book->price }}</td>
                                                                        <td>{{ $book->stock }}</td>
                                                                        <td>{{ $book->status }}</td>
                                                                        <td>
                                                                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p>You have not added any books yet.</p>
                                                    @endif
                                                </div>
                                            </div>
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
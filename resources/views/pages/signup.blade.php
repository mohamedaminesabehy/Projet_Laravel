@extends('layouts.auth')

@section('content')

<main>
    <section class="cartoon-hero py-80">
        <div class="container position-relative">
            <div class="row justify-content-center align-items-center g-4">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="cartoon-anim">
                        <svg viewBox="0 0 700 520" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <defs>
                                <linearGradient id="bookGrad" x1="0" x2="1" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#60a5fa" />
                                    <stop offset="100%" stop-color="#22d3ee" />
                                </linearGradient>
                                <linearGradient id="arrowGrad" x1="0" x2="1">
                                    <stop offset="0%" stop-color="#34d399" />
                                    <stop offset="100%" stop-color="#10b981" />
                                </linearGradient>
                                <filter id="softShadow" x="-50%" y="-50%" width="200%" height="200%">
                                    <feDropShadow dx="0" dy="8" stdDeviation="8" flood-color="#1f2937"
                                        flood-opacity=".15" />
                                </filter>
                            </defs>
                            <g filter="url(#softShadow)">
                                <ellipse cx="350" cy="470" rx="220" ry="20" fill="#000" opacity=".08"
                                    class="pulse"></ellipse>
                            </g>
                            <g class="float-y">
                                <rect x="260" y="120" rx="14" ry="14" width="180" height="120"
                                    fill="url(#bookGrad)" />
                                <rect x="270" y="130" width="160" height="14" fill="#e0f2fe" />
                                <rect x="270" y="152" width="120" height="10" fill="#bae6fd" />
                                <rect x="270" y="170" width="140" height="10" fill="#bae6fd" />
                                <rect x="270" y="188" width="110" height="10" fill="#bae6fd" />
                                <rect x="270" y="206" width="150" height="10" fill="#bae6fd" />
                            </g>
                            <g class="float-y-2">
                                <rect x="110" y="210" rx="12" ry="12" width="140" height="90"
                                    fill="#fca5a5" />
                                <rect x="120" y="222" width="120" height="10" fill="#fee2e2" />
                                <rect x="120" y="240" width="90" height="8" fill="#fecaca" />
                            </g>
                            <g class="float-y sway">
                                <rect x="470" y="230" rx="12" ry="12" width="140" height="90"
                                    fill="#a7f3d0" />
                                <rect x="480" y="242" width="120" height="10" fill="#dcfce7" />
                                <rect x="480" y="260" width="100" height="8" fill="#bbf7d0" />
                            </g>
                            <g class="float-y" style="animation-delay:1s">
                                <path d="M350 260 C390 300, 470 300, 510 260" fill="none" stroke="url(#arrowGrad)"
                                    stroke-width="10" stroke-linecap="round" />
                                <polygon points="515,255 535,260 515,265" fill="#10b981" />
                            </g>
                            <g class="float-y-2" style="animation-delay:.5s">
                                <path d="M350 260 C310 300, 230 300, 190 260" fill="none" stroke="#60a5fa"
                                    stroke-width="10" stroke-linecap="round" />
                                <polygon points="185,255 165,260 185,265" fill="#3b82f6" />
                            </g>
                            <g class="float-y" style="animation-delay:.8s">
                                <circle cx="140" cy="150" r="34" fill="#fde68a" />
                                <rect x="120" y="180" width="40" height="12" fill="#fbbf24" class="flip" />
                            </g>
                            <g class="float-y-2" style="animation-delay:1.2s">
                                <circle cx="560" cy="150" r="34" fill="#c4b5fd" />
                                <rect x="540" y="180" width="40" height="12" fill="#a78bfa" class="flip" />
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10">
                    <div class="p-4 p-md-5 auth-card">
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo" class="logo-hero">
                            <h1 class="h3 mt-3 mb-1">Create account</h1>
                            <p class="text-muted mb-0">Join us and explore the best books.</p>
                        </div>
                        <form>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="John"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Doe"
                                        required>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="signupEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="signupEmail"
                                    placeholder="name@example.com" required>
                            </div>
                            <div class="row g-3 mt-1">
                                <div class="col-sm-6">
                                    <label for="signupPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="signupPassword"
                                        placeholder="Create a password" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="confirmPassword" class="form-label">Confirm password</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        placeholder="Repeat password" required>
                                </div>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="terms">
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a>
                                </label>
                            </div>
                            <button type="submit" class="vs-btn w-100 mt-3">Create account</button>
                        </form>
                        <div class="text-center mt-4">
                            <p class="mb-2 text-muted">Or sign up with</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-outline-secondary px-3"><i
                                        class="fab fa-google me-2"></i>Google</button>
                                <button type="button" class="btn btn-outline-secondary px-3"><i
                                        class="fab fa-facebook-f me-2"></i>Facebook</button>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <span class="text-muted">Already have an account?</span>
                            <a href="{{ route('signin') }}" class="ms-1">Sign in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection 
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Connexion - Test BookShare</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <p class="text-muted">Pour tester le système d'avis, connectez-vous avec le compte de test :</p>
                            <p><strong>Email :</strong> test@example.com</p>
                            <p><strong>Mot de passe :</strong> password</p>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Se connecter comme utilisateur test</button>
                        </div>
                    </form>

                    <hr>

                    <div class="text-center">
                        <h5>Actions rapides :</h5>
                        <a href="{{ route('reviews.index') }}" class="btn btn-outline-info">Voir tous les avis</a>
                        <a href="{{ route('shop-details') }}" class="btn btn-outline-success">Tester le formulaire d'avis</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    text-align: center;
}

.btn-lg {
    padding: 0.75rem 1.25rem;
    font-size: 1.125rem;
}
</style>
@endsection
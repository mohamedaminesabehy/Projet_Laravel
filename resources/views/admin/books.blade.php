@extends('layouts.admin')

@section('title', 'Gestion des livres')

@push('styles')
<style>
    body {
        background-color: #f8f9fa; /* Light gray background for a modern feel */
    }
    .book-cover {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .book-title {
        font-weight: 600;
        margin-bottom: 2px;
    }
    .book-author {
        font-size: 13px;
        color: #6c757d;
    }
    .book-price {
        font-weight: 600;
    }
    .book-stock {
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .stock-low {
        background-color: #fff5f5;
        color: #e53e3e;
    }
    .stock-medium {
        background-color: #fffaf0;
        color: #dd6b20;
    }
    .stock-high {
        background-color: #f0fff4;
        color: #38a169;
    }
    .filter-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
    }
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px;
    }
    .book-badge {
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 20px;
        margin-right: 5px;
        display: inline-block;
    }
    .badge-new {
        background-color: #ebf8ff;
        color: #3182ce;
    }
    .badge-bestseller {
        background-color: #fef5e7;
        color: #f39c12;
    }
    .badge-sale {
        background-color: #feebc8;
        color: #dd6b20;
    }
    select, .form-control, .form-select, textarea, input {
        height: 50px;
        padding: 0 30px 0 28px;
        padding-right: 45px;
        border: 1px solid var(--border-color);
        color: #000000;
        background-color: var(--white-color);
        border-radius: 9999px;
        border-radius: 0;
        font-size: 14px;
        width: 100%;
    }
    .hidden {
        display: none;
    }
    .delete-confirm-modal {
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
    }
    .delete-confirm-content {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        width: 400px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    .delete-confirm-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .delete-confirm-title {
        font-size: 18px;
        font-weight: 600;
        color: #dc3545;
    }
    .delete-confirm-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }
    .delete-confirm-body {
        margin-bottom: 20px;
    }
    .delete-confirm-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .modal-content.book-detail-modal {
        border-radius: 12px;
        overflow: hidden;
        background-color: #ffffff;
    }
    .book-detail-header {
        background: linear-gradient(135deg, #fff1eb, #D16655);
        color: white;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .book-detail-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .book-detail-cover-wrapper {
    position: relative;
    padding-top: 127%;
    overflow: overlay;
    margin-top: 30px;
    border-radius: 17px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .book-detail-cover {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .book-detail-info-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    .book-detail-info-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .book-detail-info-card .title {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .book-detail-info-card .value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #343a40;
    }
    .book-detail-description {
        line-height: 1.8;
        color: #495057;
    }
    .book-detail-badge {
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    .badge-published {
        background-color: #d4edda;
        color: #28a745;
    }
    .badge-draft {
        background-color: #fff3cd;
        color: #ffc107;
    }
    .book-detail-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    .book-detail-meta span {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .meta-author {
        background-color: #e9ecef;
        color: #495057;
    }
    .meta-category {
        background-color: #e2f0ff;
        color: #007bff;
    }
    .meta-isbn {
        background-color: #eafbea;
        color: #28a745;
    }
    .modal-footer.book-detail-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 15px 25px;
    }
    .btn-close.book-detail-close {
        font-size: 1.2rem;
        color: white;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }
    .btn-close.book-detail-close:hover {
        opacity: 1;
    }
    .modal-body-text {
        color: #212529; /* Dark black color for text */
        font-size: 1rem;
        line-height: 1.5;
        font-family: cursive;
    }
    .btn-custom-close {
        background-color: #D16655;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .btn-custom-close:hover {
        background-color: #b35244; /* A slightly darker shade for hover effect */
        color: white; /* Keep text white on hover */
    }
    .table tbody tr {
        border-bottom: 1px solid #e9ecef; /* Subtle gray line to separate rows */
    }
    .table tbody tr:last-child {
        border-bottom: none; /* No border for the last row */
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- En-tête avec boutons d'action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Gestion des livres</h4>
            <p class="text-muted">Gérez votre catalogue de livres</p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-secondary me-2">
                <i class="fas fa-file-export me-2"></i>Exporter
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
                <i class="fas fa-plus me-2"></i>Ajouter un livre
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Filtres et recherche -->
        <div class="col-lg-12 mb-4">
            <div class="card filter-card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-dark"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control border-0 bg-light text-dark filter-input" placeholder="Rechercher un livre..." id="search" name="search">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select border-0 bg-light text-dark filter-input" id="category" name="category">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control border-0 bg-light text-dark filter-input" placeholder="Prix min" id="min_price" name="min_price" min="0" step="0.01">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control border-0 bg-light text-dark filter-input" placeholder="Prix max" id="max_price" name="max_price" min="0" step="0.01">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100" id="reset-filters">Réinitialiser</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des livres -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Catalogue de livres</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th width="35%" class="text-dark">Livre</th>
                                    <th width="15%" class="text-dark">Catégorie</th>
                                    <th width="10%" class="text-dark">Prix</th>
                                    <th width="10%" class="text-dark">Stock</th>
                                    <th width="15%" class="text-dark">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                <tr data-category-id="{{ $book->category->id }}">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($book->cover_image) }}" 
                                                 alt="{{ $book->title }}" class="book-cover me-3">
                                            <div>
                                                <div class="book-title text-dark">{{ $book->title }}</div>
                                                <div class="book-author text-dark">{{ $book->author }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-dark">{{ $book->category->name }}</td>
                                    <td><span class="book-price text-dark">{{ number_format($book->price, 2, ',', ' ') }} €</span></td>
                                    <td>
                                        @if($book->stock > 20)
                                            <span class="book-stock stock-high text-dark">En stock ({{ $book->stock }})</span>
                                        @elseif($book->stock > 5)
                                            <span class="book-stock stock-medium text-dark">Stock moyen ({{ $book->stock }})</span>
                                        @else
                                            <span class="book-stock stock-low text-dark">Stock faible ({{ $book->stock }})</span>
                                        @endif
                                    </td>
                                   
                                    <td>
                                        <button type="button" class="action-btn btn-light view-book" title="Voir" data-id="{{ $book->id }}">
                                            <i class="fas fa-eye text-primary"></i>
                                        </button>
                                        <button type="button" class="action-btn btn-light edit-book-btn" title="Modifier" data-bs-toggle="modal" data-bs-target="#editBookModal" data-book='{{ json_encode($book) }}'>
                                            <i class="fas fa-edit text-info"></i>
                                        </button>
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="action-btn btn-light delete-btn" title="Supprimer" data-id="{{ $book->id }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Affichage de <strong>1-3</strong> sur <strong>24</strong> livres</div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Précédent</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Suivant</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Book Modal -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content book-detail-modal">
            <div class="modal-header book-detail-header">
                <h5 class="modal-title book-detail-title" id="editBookModalLabel">Modifier le Livre</h5>
                <button type="button" class="btn-close book-detail-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBookForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editBookTitle" class="form-label modal-body-text">Titre</label>
                                <input type="text" class="form-control modal-body-text" id="editBookTitle" name="title">
                            </div>
                            <div class="mb-3">
                                <label for="editBookAuthor" class="form-label modal-body-text">Auteur</label>
                                <input type="text" class="form-control modal-body-text" id="editBookAuthor" name="author">
                            </div>
                            <div class="mb-3">
                                <label for="editBookCategory" class="form-label modal-body-text">Catégorie</label>
                                <select class="form-select modal-body-text" id="editBookCategory" name="category_id">
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editBookIsbn" class="form-label modal-body-text">ISBN</label>
                                <input type="text" class="form-control modal-body-text" id="editBookIsbn" name="isbn">
                            </div>
                            <div class="mb-3">
                                <label for="editBookPrice" class="form-label modal-body-text">Prix</label>
                                <input type="number" class="form-control modal-body-text" id="editBookPrice" name="price">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editBookStock" class="form-label modal-body-text">Stock</label>
                                <input type="number" class="form-control modal-body-text" id="editBookStock" name="stock">
                            </div>
                            <div class="mb-3">
                                <label for="editBookDescription" class="form-label modal-body-text">Description</label>
                                <textarea class="form-control modal-body-text" id="editBookDescription" name="description" rows="5"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editBookCoverImage" class="form-label modal-body-text">Image de Couverture</label>
                                <input type="file" class="form-control modal-body-text" id="editBookCoverImage" name="cover_image">
                                <img id="currentCoverImage" src="" alt="" class="img-thumbnail mt-2" style="max-width: 100px;">
                            </div>
                            <div class="mb-3">
                                <label for="editBookStatus" class="form-label modal-body-text">Statut</label>
                                <select class="form-select modal-body-text" id="editBookStatus" name="status">
                                    <option value="published">Publié</option>
                                    <option value="draft">Brouillon</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer book-detail-footer">
                    <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ajouter Livre -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content book-detail-modal">
            <div class="modal-header book-detail-header">
                <h5 class="modal-title book-detail-title" id="addBookModalLabel">Ajouter un nouveau livre</h5>
                <button type="button" class="btn-close book-detail-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBookForm" action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="addBookGlobalError" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label modal-body-text">Titre du livre</label>
                                <input type="text" class="form-control modal-body-text @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback d-block js-error" data-field="title"></div>
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label modal-body-text">Auteur</label>
                                <input type="text" class="form-control modal-body-text @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author') }}" placeholder="Saisir le nom de l'auteur">
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback d-block js-error" data-field="author"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="addBookCategory" class="form-label modal-body-text">Catégorie</label>
                                        <select class="form-select modal-body-text @error('category_id') is-invalid @enderror" id="addBookCategory" name="category_id">
                                            <option value="">Sélectionner une catégorie</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="invalid-feedback d-block js-error" data-field="category_id"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="isbn" class="form-label modal-body-text">ISBN</label>
                                        <input type="text" class="form-control modal-body-text @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn') }}">
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label modal-body-text">Prix (€)</label>
                                        <input type="number" class="form-control modal-body-text @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="invalid-feedback d-block js-error" data-field="price"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label modal-body-text">Stock</label>
                                        <input type="number" class="form-control modal-body-text @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}">
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="invalid-feedback d-block js-error" data-field="stock"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label modal-body-text">Description</label>
                                <textarea class="form-control modal-body-text @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label modal-body-text">Couverture du livre</label>
                                <div class="border rounded p-3 text-center">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p class="modal-body-text">Cliquez pour télécharger une image</p>
                                    <input type="file" class="form-control modal-body-text" id="cover_image" name="cover_image">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label modal-body-text">Statut</label>
                                <select class="form-select modal-body-text @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publié</option>
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback d-block js-error" data-field="status"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer book-detail-footer">
                        <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal pour afficher les détails du livre -->
<div class="modal fade" id="bookDetailsModal" tabindex="-1" aria-labelledby="bookDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content book-detail-modal">
            <div class="modal-header book-detail-header">
                <h5 class="modal-title book-detail-title" id="bookDetailsModalLabel">Détails du livre</h5>
                <button type="button" class="btn-close book-detail-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="book-detail-cover-wrapper mb-3">
                            <img id="bookCover" src="" alt="Couverture du livre" class="book-detail-cover">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h3 id="bookTitle" class="fw-bold mb-3 text-dark"></h3>
                        <div class="book-detail-meta">
                            <span class="meta-author modal-body-text"><i class="fas fa-user me-1"></i> <span id="bookAuthor"></span></span>
                            <span class="meta-category modal-body-text"><i class="fas fa-tag me-1"></i> <span id="bookCategory"></span></span>
                            <span class="meta-isbn modal-body-text"><i class="fas fa-barcode me-1"></i> ISBN: <span id="bookIsbn"></span></span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="book-detail-info-card">
                                    <h6 class="title modal-body-text">Prix</h6>
                                    <p class="value modal-body-text" id="bookPrice"></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="book-detail-info-card">
                                    <h6 class="title modal-body-text">Stock</h6>
                                    <p class="value modal-body-text" id="bookStock"></p>
                                </div>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark modal-body-text">Description</h5>
                        <p id="bookDescription" class="book-detail-description modal-body-text"></p>
                        <div class="mt-3">
                            <span class="book-detail-badge modal-body-text" id="bookStatus"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer book-detail-footer">
                <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal fade" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content book-detail-modal">
            <div class="modal-header book-detail-header">
                <h5 class="modal-title book-detail-title" id="deleteConfirmModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close book-detail-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="modal-body-text">Voulez-vous vraiment supprimer ce livre ? Cette action est définitive et irréversible.</p>
            </div>
            <div class="modal-footer book-detail-footer">
                <button type="button" class="btn btn-secondary btn-custom-close" data-bs-dismiss="modal" id="cancelDelete">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Confirmer</button>
            </div>
        </div>
    </div>
</div>

<!-- Script pour gérer l'affichage des détails du livre et la suppression -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables pour la suppression
    let currentDeleteForm = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    const confirmDeleteBtn = document.getElementById('confirmDelete');

    // Filtrage dynamique
    const filterInputs = document.querySelectorAll('.filter-input');
    const resetFiltersBtn = document.getElementById('reset-filters');
    const tableRows = document.querySelectorAll('tbody tr');

    // Fonction de filtrage
    function applyFilters() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const categoryValue = document.getElementById('category').value; // category ID
        const minPrice = parseFloat(document.getElementById('min_price').value) || 0;
        const maxPrice = parseFloat(document.getElementById('max_price').value) || Infinity;

        tableRows.forEach(row => {
            const title = row.querySelector('.book-title').textContent.toLowerCase();
            const rowCategoryId = row.getAttribute('data-category-id');
            const priceText = row.querySelector('.book-price').textContent.replace('€', '').replace(',', '.').trim();
            const price = parseFloat(priceText);

            const matchesSearch = !searchValue || title.includes(searchValue);
            const matchesCategory = !categoryValue || rowCategoryId === categoryValue;
            const matchesPrice = price >= minPrice && price <= maxPrice;

            if (matchesSearch && matchesCategory && matchesPrice) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    // Écouteurs d'événements pour le filtrage
    filterInputs.forEach(input => {
        input.addEventListener('input', applyFilters);
    });
    // Assurer le déclenchement sur changement de la catégorie
    const categorySelect = document.getElementById('category');
    if (categorySelect) {
        categorySelect.addEventListener('change', applyFilters);
    }

    // Réinitialiser les filtres
    resetFiltersBtn.addEventListener('click', function() {
        filterInputs.forEach(input => {
            input.value = '';
        });
        if (categorySelect) categorySelect.value = '';
        tableRows.forEach(row => {
            row.classList.remove('hidden');
        });
        applyFilters();
    });

    // Gestion de la suppression avec confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            currentDeleteForm = this.closest('.delete-form');
            deleteModal.show();
        });
    });

    // Fermer la modal de confirmation
    function closeDeleteModal() {
        deleteModal.hide();
        currentDeleteForm = null;
    }

    // Confirmer la suppression
    confirmDeleteBtn.addEventListener('click', function() {
        if (currentDeleteForm) {
            currentDeleteForm.submit();
        }
        closeDeleteModal();
    });

    // Annuler la suppression
    document.getElementById('cancelDelete').addEventListener('click', closeDeleteModal);
    
    // Fermeture automatique lors de la fermeture de la modal
    document.getElementById('deleteConfirmModal').addEventListener('hidden.bs.modal', function () {
        currentDeleteForm = null;
    });

    // Gestionnaire pour les boutons "Voir"
    const viewButtons = document.querySelectorAll('.view-book');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const bookId = this.getAttribute('data-id');
            fetchBookDetails(bookId);
        });
    });

    // Fonction pour récupérer les détails du livre
    function fetchBookDetails(bookId) {
        fetch(`/admin/books/${bookId}`)
            .then(response => response.json())
            .then(book => {
                // Remplir les détails du livre dans la modal
                document.getElementById('bookTitle').textContent = book.title;
                document.getElementById('bookAuthor').textContent = book.author;
                document.getElementById('bookCategory').textContent = book.category ? book.category.name : 'Non disponible';
                document.getElementById('bookIsbn').textContent = book.isbn || 'Non disponible';
                document.getElementById('bookPrice').textContent = book.price + ' €';
                
                document.getElementById('bookDescription').textContent = book.description || 'Aucune description disponible';

                // Set stock status styling
                const bookStockElement = document.getElementById('bookStock');
                bookStockElement.textContent = book.stock;
                bookStockElement.classList.remove('stock-high', 'stock-medium', 'stock-low', 'text-dark');

                if (book.stock > 20) {
                    bookStockElement.classList.add('book-stock', 'stock-high', 'text-dark');
                } else if (book.stock > 5) {
                    bookStockElement.classList.add('book-stock', 'stock-medium', 'text-dark');
                } else {
                    bookStockElement.classList.add('book-stock', 'stock-low', 'text-dark');
                }

                // Set book status badge
                const bookStatusBadge = document.getElementById('bookStatus');
                bookStatusBadge.textContent = book.status === 'published' ? 'Publié' : 'Brouillon';
                bookStatusBadge.classList.remove('badge-published', 'badge-draft');
                if (book.status === 'published') {
                    bookStatusBadge.classList.add('badge-published');
                } else {
                    bookStatusBadge.classList.add('badge-draft');
                }

                // Afficher l'image de couverture
                const coverImage = document.getElementById('bookCover');
                if (book.cover_image) {
                    coverImage.src = `/${book.cover_image}`;
                } else {
                    coverImage.src = '/images/default-book-cover.jpg';
                }
                
                // Afficher la modal
                const modal = new bootstrap.Modal(document.getElementById('bookDetailsModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des détails du livre:', error);
                alert('Une erreur est survenue lors de la récupération des détails du livre.');
            });
    }
});
</script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Sélectionner/désélectionner tous les livres
        $('#selectAll').on('change', function() {
            $('tbody .form-check-input').prop('checked', $(this).is(':checked'));
        });
    });
</script>
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var addModalEl = document.getElementById('addBookModal');
        if (addModalEl) {
            // Assure que aria-hidden n'est pas true lorsque le modal est affiché
            addModalEl.setAttribute('aria-hidden', 'false');
            var addModal = new bootstrap.Modal(addModalEl);
            addModal.show();
        }
    });
</script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editBookModal = document.getElementById('editBookModal');
        if (editBookModal) {
            editBookModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var book = JSON.parse(button.getAttribute('data-book'));

                var modalTitle = editBookModal.querySelector('.modal-title');
                var editBookForm = document.getElementById('editBookForm');
                var currentCoverImage = document.getElementById('currentCoverImage');

                if (modalTitle) modalTitle.textContent = 'Modifier le Livre: ' + book.title;
                if (editBookForm) editBookForm.action = '/admin/books/' + book.id;

                // Fill form fields safely
                if (editBookForm.querySelector('#editBookTitle')) editBookForm.querySelector('#editBookTitle').value = book.title || '';
                if (editBookForm.querySelector('#editBookAuthor')) editBookForm.querySelector('#editBookAuthor').value = book.author || '';
                if (editBookForm.querySelector('#editBookCategory')) editBookForm.querySelector('#editBookCategory').value = book.category_id || '';
                if (editBookForm.querySelector('#editBookIsbn')) editBookForm.querySelector('#editBookIsbn').value = book.isbn || '';
                if (editBookForm.querySelector('#editBookPrice')) editBookForm.querySelector('#editBookPrice').value = book.price || '';
                if (editBookForm.querySelector('#editBookStock')) editBookForm.querySelector('#editBookStock').value = book.stock || '';
                if (editBookForm.querySelector('#editBookDescription')) editBookForm.querySelector('#editBookDescription').value = book.description || '';
                if (editBookForm.querySelector('#editBookStatus')) editBookForm.querySelector('#editBookStatus').value = book.status || '';
                
                // Set current cover image if exists
                if (currentCoverImage && book.cover_image) {
                    currentCoverImage.src = '/' + book.cover_image;
                    currentCoverImage.style.display = 'block';
                } else if (currentCoverImage) {
                    currentCoverImage.style.display = 'none';
                }
            });
        }

        // Gestion des attributs aria-hidden pour l'accessibilité des modals
        var addBookModalEl = document.getElementById('addBookModal');
        if (addBookModalEl) {
            addBookModalEl.addEventListener('shown.bs.modal', function () {
                addBookModalEl.setAttribute('aria-hidden', 'false');
            });
            addBookModalEl.addEventListener('hidden.bs.modal', function () {
                addBookModalEl.setAttribute('aria-hidden', 'true');
            });

            // Soumission AJAX pour afficher les erreurs sans rafraîchissement
            var addBookForm = document.getElementById('addBookForm');
            if (addBookForm) {
                addBookForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Nettoyer les erreurs précédentes
                    addBookForm.querySelectorAll('.is-invalid').forEach(function(el){ el.classList.remove('is-invalid'); });
                    addBookForm.querySelectorAll('.js-error').forEach(function(el){ el.textContent = ''; });

                    var formData = new FormData(addBookForm);

                    fetch(addBookForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    }).then(async function(response){
                        if (response.status === 422) {
                            var data = await response.json();
                            var errors = data.errors || {};
                            Object.keys(errors).forEach(function(field){
                                var input = addBookForm.querySelector('[name="' + field + '"]');
                                if (input) { input.classList.add('is-invalid'); }
                                var errDiv = addBookForm.querySelector('.js-error[data-field="' + field + '"]');
                                if (errDiv) { errDiv.textContent = errors[field][0]; }
                            });
                            // Garder la pop-up ouverte
                            var modalInstance = bootstrap.Modal.getInstance(addBookModalEl) || new bootstrap.Modal(addBookModalEl);
                            modalInstance.show();
                            return;
                        }

                        if (response.ok) {
                            // Fermer le modal et rafraîchir la page pour voir la liste mise à jour
                            var modalInstance = bootstrap.Modal.getInstance(addBookModalEl) || new bootstrap.Modal(addBookModalEl);
                            modalInstance.hide();
                            try { await response.json(); } catch(e) {}
                            window.location.reload();
                            return;
                        }

                        // Erreur non prévue (serveur): afficher un message global
                        var globalErr = document.getElementById('addBookGlobalError');
                        if (globalErr) {
                            globalErr.textContent = 'Une erreur est survenue. Réessayez plus tard.';
                            globalErr.classList.remove('d-none');
                        }
                    }).catch(function(){
                        var globalErr = document.getElementById('addBookGlobalError');
                        if (globalErr) {
                            globalErr.textContent = 'Impossible de soumettre le formulaire. Vérifiez votre connexion.';
                            globalErr.classList.remove('d-none');
                        }
                    });
                });
            }
        }
    });
</script>
@endpush
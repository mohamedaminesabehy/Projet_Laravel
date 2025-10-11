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
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-dark"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control border-0 bg-light text-dark" placeholder="Rechercher un livre...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select border-0 bg-light text-dark">
                                <option value="">Toutes les catégories</option>
                                <option value="1">Romans</option>
                                <option value="2">Science Fiction</option>
                                <option value="3">Histoire</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select border-0 bg-light text-dark">
                                <option value="">Tous les auteurs</option>
                                <option value="1">Victor Hugo</option>
                                <option value="2">J.K. Rowling</option>
                                <option value="3">Albert Camus</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select border-0 bg-light text-dark">
                                <option value="">Tous les statuts</option>
                                <option value="published">Publié</option>
                                <option value="draft">Brouillon</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select border-0 bg-light text-dark">
                                <option value="">Trier par</option>
                                <option value="newest">Plus récent</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="title_asc">Titre A-Z</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100">Filtrer</button>
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
                                    <th width="10%" class="text-dark">Statut</th>
                                    <th width="15%" class="text-dark">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://img.freepik.com/free-psd/book-mockup_125540-572.jpg" 
                                                 alt="Les Misérables" class="book-cover me-3">
                                            <div>
                                                <div class="book-title text-dark">Les Misérables</div>
                                                <div class="book-author text-dark">Victor Hugo</div>
                                                <div class="mt-1">
                                                    <span class="book-badge badge-bestseller">Bestseller</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-dark">Romans</td>
                                    <td><span class="book-price text-dark">24,90 €</span></td>
                                    <td><span class="book-stock stock-high text-dark">En stock (45)</span></td>
                                    <td><span class="badge bg-success text-dark">Publié</span></td>
                                    <td>
                                        <button type="button" class="action-btn btn-light" title="Voir">
                                            <i class="fas fa-eye text-primary"></i>
                                        </button>
                                        <button type="button" class="action-btn btn-light" title="Modifier">
                                            <i class="fas fa-edit text-info"></i>
                                        </button>
                                        <button type="button" class="action-btn btn-light" title="Supprimer">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://img.freepik.com/free-psd/hardcover-book-mockup_125540-625.jpg" 
                                                 alt="Harry Potter" class="book-cover me-3">
                                            <div>
                                                <div class="book-title text-dark">Harry Potter et la Chambre des Secrets</div>
                                                <div class="book-author text-dark">J.K. Rowling</div>
                                                <div class="mt-1">
                                                    <span class="book-badge badge-bestseller">Bestseller</span>
                                                    <span class="book-badge badge-sale">Promo</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-dark">Science Fiction</td>
                                    <td><span class="book-price text-dark">19,90 €</span></td>
                                    <td><span class="book-stock stock-medium text-dark">Stock moyen (12)</span></td>
                                    <td><span class="badge bg-success text-dark">Publié</span></td>
                                    <td>
                                        <button type="button" class="action-btn btn-light" title="Voir">
                                            <i class="fas fa-eye text-primary"></i>
                                        </button>
                                        <button type="button" class="action-btn btn-light" title="Modifier">
                                            <i class="fas fa-edit text-info"></i>
                                        </button>
                                        <button type="button" class="action-btn btn-light" title="Supprimer">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://img.freepik.com/free-psd/book-mockup_125540-721.jpg" 
                                                 alt="L'Étranger" class="book-cover me-3">
                                            <div>
                                                <div class="book-title text-dark">L'Étranger</div>
                                                <div class="book-author text-dark">Albert Camus</div>
                                                <div class="mt-1">
                                                    <span class="book-badge badge-new">Nouveau</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Romans</td>
                                    <td><span class="book-price text-dark">12,50 €</span></td>
                                    <td><span class="book-stock stock-low text-dark">Stock faible (3)</span></td>
                                    <td><span class="badge bg-success text-dark">Publié</span></td>
                                    <td>
                                        <button type="button" class="action-btn btn-light" title="Voir">
                                            <i class="fas fa-eye text-primary"></i>
                                        </button>
                                        <button type="button" class="action-btn btn-light" title="Modifier">
                                            <i class="fas fa-edit text-info"></i>
                                        </button>
                                        <button type="button" class="action-btn btn-light" title="Supprimer">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
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

<!-- Modal Ajouter Livre -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Ajouter un nouveau livre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="bookTitle" class="form-label">Titre du livre</label>
                                <input type="text" class="form-control" id="bookTitle" required>
                            </div>
                            <div class="mb-3">
                                <label for="bookAuthor" class="form-label">Auteur</label>
                                <select class="form-select" id="bookAuthor">
                                    <option value="">Sélectionner un auteur</option>
                                    <option value="1">Victor Hugo</option>
                                    <option value="2">J.K. Rowling</option>
                                    <option value="3">Albert Camus</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bookCategory" class="form-label">Catégorie</label>
                                        <select class="form-select" id="bookCategory">
                                            <option value="">Sélectionner une catégorie</option>
                                            <option value="1">Romans</option>
                                            <option value="2">Science Fiction</option>
                                            <option value="3">Histoire</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bookISBN" class="form-label">ISBN</label>
                                        <input type="text" class="form-control" id="bookISBN">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bookPrice" class="form-label">Prix (€)</label>
                                        <input type="number" class="form-control" id="bookPrice" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bookStock" class="form-label">Stock</label>
                                        <input type="number" class="form-control" id="bookStock" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="bookDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="bookDescription" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Couverture du livre</label>
                                <div class="border rounded p-3 text-center">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p>Cliquez pour télécharger une image</p>
                                    <input type="file" class="d-none" id="bookCover">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('bookCover').click()">Parcourir</button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Badges</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="badgeNew">
                                    <label class="form-check-label" for="badgeNew">
                                        <span class="book-badge badge-new">Nouveau</span>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="badgeBestseller">
                                    <label class="form-check-label" for="badgeBestseller">
                                        <span class="book-badge badge-bestseller">Bestseller</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="badgeSale">
                                    <label class="form-check-label" for="badgeSale">
                                        <span class="book-badge badge-sale">Promo</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Statut</label>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="bookPublished" checked>
                                    <label class="form-check-label" for="bookPublished">Publié</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
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
@endpush
@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
<style>
    body {
        background-color: #f8f9fa; /* Light gray background for a modern feel */
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #495057;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px;
        transition: all 0.2s;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .filter-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    .user-role {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .role-admin {
        background-color: rgba(78, 115, 223, 0.1);
        color: #4e73df;
    }
    .role-editor {
        background-color: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
    }
    .role-customer {
        background-color: rgba(54, 185, 204, 0.1);
        color: #36b9cc;
    }
    .status-active {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #1cc88a;
        display: inline-block;
        margin-right: 5px;
    }
    .status-inactive {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #e74a3b;
        display: inline-block;
        margin-right: 5px;
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
            <h4 class="mb-0">Gestion des utilisateurs</h4>
            <p class="text-muted">Gérez tous les utilisateurs de la plateforme</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Ajouter un utilisateur
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-download me-2"></i>Exporter
            </button>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="roleFilter" class="form-label text-dark">Rôle</label>
                    <select class="form-select text-dark" id="roleFilter">
                        <option value="">Tous les rôles</option>
                        <option value="admin">Administrateur</option>
                        <option value="editor">Éditeur</option>
                        <option value="customer">Client</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label text-dark">Statut</label>
                    <select class="form-select text-dark" id="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="dateFilter" class="form-label text-dark">Date d'inscription</label>
                    <div class="input-group">
                        <input type="date" class="form-control text-dark" id="dateFrom">
                        <span class="input-group-text text-dark">à</span>
                        <input type="date" class="form-control text-dark" id="dateTo">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-primary w-100">Appliquer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-dark">Utilisateur</th>
                            <th class="text-dark">Email</th>
                            <th class="text-dark">Rôle</th>
                            <th class="text-dark">Date d'inscription</th>
                            <th class="text-dark">Statut</th>
                            <th class="text-dark">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">JD</div>
                                    <div>
                                        <h6 class="mb-0 text-dark">Jean Dupont</h6>
                                        <small class="text-muted text-dark">ID: #USR-001</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-dark">jean.dupont@example.com</td>
                            <td><span class="user-role role-admin text-dark">Administrateur</span></td>
                            <td class="text-dark">15/01/2023</td>
                            <td><span class="status-active"></span> <span class="text-dark">Actif</span></td>
                            <td>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Voir">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Modifier">
                                    <i class="fas fa-edit text-info"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">ML</div>
                                    <div>
                                        <h6 class="mb-0 text-dark">Marie Leclerc</h6>
                                        <small class="text-muted text-dark">ID: #USR-002</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-dark">marie.leclerc@example.com</td>
                            <td><span class="user-role role-editor text-dark">Éditeur</span></td>
                            <td class="text-dark">22/02/2023</td>
                            <td><span class="status-active"></span> <span class="text-dark">Actif</span></td>
                            <td>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Voir">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Modifier">
                                    <i class="fas fa-edit text-info"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">PB</div>
                                    <div>
                                        <h6 class="mb-0 text-dark">Pierre Bernard</h6>
                                        <small class="text-muted text-dark">ID: #USR-003</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-dark">pierre.bernard@example.com</td>
                            <td><span class="user-role role-customer text-dark">Client</span></td>
                            <td class="text-dark">10/03/2023</td>
                            <td><span class="status-inactive"></span> <span class="text-dark">Inactif</span></td>
                            <td>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Voir">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Modifier">
                                    <i class="fas fa-edit text-info"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">SD</div>
                                    <div>
                                        <h6 class="mb-0 text-dark">Sophie Dubois</h6>
                                        <small class="text-muted text-dark">ID: #USR-004</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-dark">sophie.dubois@example.com</td>
                            <td><span class="user-role role-customer text-dark">Client</span></td>
                            <td class="text-dark">05/04/2023</td>
                            <td><span class="status-active"></span> <span class="text-dark">Actif</span></td>
                            <td>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Voir">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Modifier">
                                    <i class="fas fa-edit text-info"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">LM</div>
                                    <div>
                                        <h6 class="mb-0 text-dark">Luc Martin</h6>
                                        <small class="text-muted text-dark">ID: #USR-005</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-dark">luc.martin@example.com</td>
                            <td><span class="user-role role-editor text-dark">Éditeur</span></td>
                            <td class="text-dark">18/05/2023</td>
                            <td><span class="status-active"></span> <span class="text-dark">Actif</span></td>
                            <td>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Voir">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Modifier">
                                    <i class="fas fa-edit text-info"></i>
                                </button>
                                <button type="button" class="action-btn btn-light" data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter Utilisateur -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Ajouter un nouvel utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="lastName" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="phone">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="confirmPassword" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="role" class="form-label">Rôle</label>
                            <select class="form-select" id="role" required>
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin">Administrateur</option>
                                <option value="editor">Éditeur</option>
                                <option value="customer">Client</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Statut</label>
                            <select class="form-select" id="status" required>
                                <option value="active">Actif</option>
                                <option value="inactive">Inactif</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Adresse</label>
                        <textarea class="form-control" id="address" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permissions</label>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="viewBooks">
                                    <label class="form-check-label" for="viewBooks">Voir les livres</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editBooks">
                                    <label class="form-check-label" for="editBooks">Éditer les livres</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="viewOrders">
                                    <label class="form-check-label" for="viewOrders">Voir les commandes</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="manageUsers">
                                    <label class="form-check-label" for="manageUsers">Gérer les utilisateurs</label>
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
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialisation de DataTables
        $('#usersTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            }
        });
        
        // Initialisation des tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
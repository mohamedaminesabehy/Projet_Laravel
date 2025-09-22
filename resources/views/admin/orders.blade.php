@extends('admin.dashboard')

@section('title', 'Gestion des Commandes')

@push('styles')
    <!-- Additional styles for orders page if needed -->
@endpush

@section('content')
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gestion des Commandes</h1>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter une Commande
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des Commandes</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Commande</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID Commande</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <!-- Exemple de données de commande -->
                            <tr>
                                <td>#ORD001</td>
                                <td>Jean Dupont</td>
                                <td>2023-10-26</td>
                                <td>59.99 €</td>
                                <td><span class="badge bg-success-subtle text-success">Terminée</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD002</td>
                                <td>Marie Curie</td>
                                <td>2023-10-25</td>
                                <td>34.50 €</td>
                                <td><span class="badge bg-warning-subtle text-warning">En attente</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD003</td>
                                <td>Pierre Martin</td>
                                <td>2023-10-24</td>
                                <td>120.00 €</td>
                                <td><span class="badge bg-danger-subtle text-danger">Annulée</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <!-- Fin des exemples de données -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
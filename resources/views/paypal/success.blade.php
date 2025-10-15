<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Réussi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .success-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 90%;
        }
        .success-icon {
            color: #28a745;
            font-size: 80px;
            margin-bottom: 20px;
        }
        h1 {
            color: #28a745;
            margin-bottom: 15px;
            font-weight: bold;
        }
        p {
            color: #555;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .order-summary {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            margin-bottom: 30px;
            text-align: left;
        }
        .order-summary h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 22px;
        }
        .order-summary p {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .btn-home {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 18px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-home:hover {
            background-color: #0056b3;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">&#10004;</div>
        <h1>Paiement Réussi !</h1>
        <p>Merci pour votre achat et pour la confiance que vous nous accordez.</p>

        <div class="order-summary">
            <h3>Détails de la transaction</h3>
            @if(isset($cart_historique) && $cart_historique->count())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Livre</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Date de transaction</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart_historique as $item)
                                <tr>
                                    <td>{{ $item->user ? ($item->user->first_name . ' ' . $item->user->last_name) : 'Utilisateur inconnu' }}</td>
                                    <td>{{ $item->book ? $item->book->title : 'Livre inconnu' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 2, ',', ' ') }} €</td>
                                    <td>{{ $item->transaction_date ? $item->transaction_date->format('d/m/Y H:i') : '' }}</td>
                                    <td>{{ ucfirst($item->payment_status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Aucune transaction à afficher.</p>
            @endif
        </div>

        <a href="/" class="btn btn-home">Retour à l'accueil</a>
    </div>
</body>
</html>
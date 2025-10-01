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
            <h3>Récapitulatif de la commande</h3>
            <p><strong>Numéro de commande:</strong> #123456</p>
            <p><strong>Date:</strong> 23/07/2024</p>
            <p><strong>Total:</strong> 120.00 €</p>
            <p><strong>Articles:</strong></p>
            <ul>
                <li>Livre A (x1) - 25.00 €</li>
                <li>Livre B (x2) - 70.00 €</li>
                <li>Frais de port - 5.00 €</li>
            </ul>
            <p><em>Ceci est un exemple de récapitulatif. Le contenu réel sera généré dynamiquement.</em></p>
        </div>

        <a href="/" class="btn btn-home">Retour à l'accueil</a>
    </div>
</body>
</html>
<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            
            \Log::info('PayPalController: Attempting to get access token.');
            // Vérifier si l'accès à l'API PayPal est possible
            try {
                $paypalToken = $provider->getAccessToken();
                \Log::info('PayPalController: Access token obtained successfully.');
            } catch (\Exception $e) {
                \Log::error('PayPal API Error: ' . $e->getMessage());
                return redirect()->route('cart.index')->with('error', 'Impossible de se connecter à PayPal. Veuillez réessayer plus tard.');
            }

            $total = 0;
            $cartItems = Cart::where('user_id', auth()->id())->with('book')->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
            }
            
            foreach ($cartItems as $item) {
                $total += $item->price * $item->quantity;
            }

            if ($total <= 0) {
                return redirect()->route('cart.index')->with('error', 'Le montant total doit être supérieur à 0.');
            }

            \Log::info('PayPal Order Creation Data', [
                'total' => number_format($total, 2, '.', ''),
                'currency' => "USD"
            ]);

            \Log::info('PayPalController: Attempting to create order.');
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.success'),
                    "cancel_url" => route('paypal.cancel'),
                    "brand_name" => config('app.name'),
                    "shipping_preference" => "NO_SHIPPING",
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => number_format($total, 2, '.', '')
                        ],
                        "description" => "Achat sur " . config('app.name')
                    ]
                ]
            ]);
            \Log::info('PayPalController: Order creation response received.', ['response' => $response]);

            if (isset($response['id']) && $response['id'] != null) {
                \Log::info('PayPalController: Order created, redirecting to PayPal.');
                // Redirect to PayPal
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
                
                \Log::warning('PayPal redirect link not found', ['response' => $response]);
                return redirect()->route('cart.index')->with('error', 'Lien de redirection PayPal non trouvé. Veuillez réessayer.');
            } else {
                \Log::error('PayPal Error Response', ['response' => $response]);
                $errorMessage = isset($response['error']) ? 'Erreur PayPal: ' . $response['error']['message'] : 
                               (isset($response['message']) ? $response['message'] : 'Une erreur est survenue avec PayPal.');
                return redirect()->route('cart.index')->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            \Log::error('PayPal Exception: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Une erreur est survenue lors du traitement de votre paiement. Veuillez réessayer plus tard.');
        }
    }

    public function success(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            
            try {
                $paypalToken = $provider->getAccessToken();
            } catch (\Exception $e) {
                \Log::error('PayPal API Error on success: ' . $e->getMessage());
                return redirect()->route('cart.index')->with('error', 'Impossible de se connecter à PayPal. Veuillez réessayer plus tard.');
            }
            
            if (!$request->has('token')) {
                \Log::error('PayPal success callback missing token');
                return redirect()->route('cart.index')->with('error', 'Paramètre de paiement manquant.');
            }
            
            $response = $provider->capturePaymentOrder($request->token);
            \Log::info('PayPal capture response', ['response' => $response]);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                // Clear the cart
                Cart::where('user_id', auth()->id())->delete();
                
                // Dummy order data for demonstration
                $orderSummary = [
                    'order_number' => '#123456',
                    'date' => date('d/m/Y'),
                    'total' => '120.00 €',
                    'items' => [
                        ['name' => 'Livre A', 'quantity' => 1, 'price' => '25.00 €'],
                        ['name' => 'Livre B', 'quantity' => 2, 'price' => '70.00 €'],
                        ['name' => 'Frais de port', 'quantity' => 1, 'price' => '5.00 €'],
                    ]
                ];

                return view('paypal.success', compact('orderSummary'));
            } else {
                $errorMessage = 'Le paiement a échoué.';
                
                if (isset($response['error'])) {
                    $errorMessage .= ' Erreur: ' . $response['error']['message'];
                    \Log::error('PayPal capture error', ['error' => $response['error']]);
                } elseif (isset($response['message'])) {
                    $errorMessage .= ' Message: ' . $response['message'];
                }
                
                return redirect()->route('cart.index')->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            \Log::error('PayPal Success Exception: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Une erreur est survenue lors de la finalisation de votre paiement. Veuillez contacter notre service client.');
        }
    }

    public function cancel(Request $request)
    {
        // Enregistrer plus d'informations pour le débogage
        \Log::info('PayPal payment cancelled', [
            'token' => $request->token ?? 'no-token',
            'user_id' => auth()->id() ?? 'not-authenticated',
            'user_agent' => $request->header('User-Agent'),
            'referrer' => $request->header('Referer')
        ]);
        
        // Message plus descriptif pour l'utilisateur
        $message = 'Votre paiement PayPal a été annulé. Si vous avez rencontré des difficultés, vous pouvez essayer une autre méthode de paiement ou réessayer plus tard.';
        
        // Rediriger vers le panier avec le message d'erreur
        return redirect()->route('cart.index')->with('error', $message);
    }
}
<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;

class StripeCheckoutController extends Controller
{
    public function create()
    {
        return Inertia::render('checkout/create');
    }

    //pour envoyer l'intention de paiement
    public function paymentIntent()
    {
        // This is your test secret API key.
        $stripeSecretKey = config('stripe.test_secret_key');

        \Stripe\Stripe::setApiKey($stripeSecretKey);

        $cartTotal = (new CartRepository())->total();

        header('Content-Type: application/json');

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $cartTotal,
                'currency' => 'eur',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [ //on ajoute 'metadata' si on veut ajouter d'autres choses ou informations au paiement
                    'order_items' => (new CartRepository())->getJsonOrderItems()
                ]
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

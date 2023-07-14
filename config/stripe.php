<?php 

return [
    'test_public_key' => env('STRIPE_TEST_PUBLIC_KEY'),
    'test_secret_key' => env('STRIPE_TEST_SECRET_KEY'),
];

//Pour y accéder, on va faire config('stripe.test_secret_key') par exemple 
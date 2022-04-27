<?php
 
namespace App\Service;

use App\Service\Panier;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Payement {

private $cart;

    public function __construct(Panier $cart)
    {
        $this->cart=$cart;
    }
   
    public function creer(){

        $total = $this->cart->voirTotal();
      

        // This is your test secret API key.
        \Stripe\Stripe::setApiKey('sk_test_51KquSXCuWjvU9Nkm8qu8uaG5O1MtVewkHwgJpwREFm9vjcwEA0TJYDEBNjUo3y8BCrYdMro1hpCbgabwawQjIb1Z00BnfdfVPL');

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total * 100,
            'currency' => 'eur',
        ]);

      
        return $paymentIntent;

    }

        public function envoiBd(SessionInterface $session){
        $cart =  $session->get('panier', []);

    }






}

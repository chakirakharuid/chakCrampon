<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\Panier;
use App\Service\Payement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{
    #[Route('/profile/payement', name: 'app_payement')]
    public function index(Payement $paye,Panier $cart): Response
    {
        $total = $cart->voirTotal();
        $paymentIntent=$paye->creer();

        return $this->render('paiement/index.html.twig', [
            'clientSecret' => $paymentIntent->client_secret,
              'total' => $total,

        ]);
    }


    #[Route('/profile/payement_success', name: 'app_payement_success')]
    public function valider(Panier $cart): Response{
        //On entre les commandes en Basse de données




        //On vide le panier après validation du payement et injection des données en basse
        $cart->vider();

        return $this->render('paiement/paiement_success.html.twig', [
           
        ]);

    }
}

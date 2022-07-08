<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\Panier;
use App\Service\Paiement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profil')]
class PaiementController extends AbstractController
{
    #[Route('/paiement', name: 'app_paiement')]
    public function index(Paiement $paye,Panier $cart): Response
    {
        $total = $cart->voirTotal();
        $paymentIntent=$paye->creer();

        return $this->render('paiement/index.html.twig', [
            'clientSecret' => $paymentIntent->client_secret,
              'total' => $total,

        ]);
    }


    #[Route('/paiement_success', name: 'app_paiement_success')]
    public function valider(Paiement $base,Panier $cart ): Response{
// Envoie des données de la commande en basse de donnée grace a la méthode envoiBd() présente dans le service paiement
      $base->envoiBd();
        
 //On vide le panier après validation du paiement et injection des données en basse
        $cart->vider();

        return $this->render('paiement/paiement_success.html.twig', [
           
        ]);

    }
}

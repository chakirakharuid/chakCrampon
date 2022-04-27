<?php

namespace App\Controller;

use App\Service\Panier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierController extends AbstractController
{
    #[Route('/panier/vu', name: 'app_panier_vu')]
    public function panier(SessionInterface $session, Panier $cart): Response
    {
    if (!empty($session->get('panier'))) {
      $cart_full =$cart->lePanier();
      $total=$cart->voirTotal();
        }else{
      //On déclarre nos variables a 0 pour qu'elles soient prise en compte quoi qu'il arrive
      $cart_full=0;
      $total=0;

        }
        return $this->render('panier/index.html.twig', [
            'lepanier' => $cart_full,
            'total' => $total
          
        ]);

    }
    #[Route('/panier/{id}', name: 'app_panier')]
    public function index($id, Panier $cart): Response
    {
        $cart->ajouter($id);

        return $this->redirectToRoute('app_accessoires');;
    }
    #[Route('/vider', name: 'app_vider')]
    public function vider( Panier $cart): Response
    {
        $cart->vider();
        return $this->render('panier/index.html.twig', []);
    }
    #[Route('/supprimer/{id}', name: 'app_supprimer')]
    public function supprimer($id,Panier $cart): Response
    {
        $cart->supprimerUn($id);
        // on redirige
        return $this->redirectToRoute('app_panier_vu'); 
    }
}

<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
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
      $nbrQuantite = $cart->nbrQuantite();
        // }
      // dd($nbrQuantite);
        }else{
      //On déclarre nos variables a 0 pour qu'elles soient prise en compte quoi qu'il arrive
      $cart_full=0;
      $total=0;
      $nbrQuantite=0;
    }
    // dd($cart_full);
        return $this->render('panier/index.html.twig', [
            'lepanier' => $cart_full,
            'total' => $total,
            'nbrPanier'=> $nbrQuantite,
            
          
        ]);

    }
    #[Route('/panier/{id}', name: 'app_panier', methods: ['GET', 'POST'])]
    public function index($id, Panier $cart, ProduitsRepository $produit): Response
    {
        isset($_POST['taille']) ? $taille = $_POST['taille'] : $taille = null;
        $product=$produit->find($id);
        $cart->ajouter($id ,$taille);
        
      
      if (str_contains($product->getNom(), 'Semelle')){
         $this->addFlash(
        'panier',
        'Article ajouté au panier !');
        return $this->redirectToRoute('app_matiere');
      } else if (str_contains($product->getNom(), 'Matière')) {

      $this->addFlash(
        'panier',
        'Article ajouté au panier !'
      );
            return $this->redirectToRoute('app_lacets');
        }

       else{
      $this->addFlash(
        'panier',
        'Article ajouté au panier !'
      ); 
        return $this->redirectToRoute('app_accessoires');

    }
    }
    #[Route('/vider', name: 'app_vider')]
    public function vider( Panier $cart): Response
    {
        $cart->vider();
        return $this->render('panier/index.html.twig', []);
    }
    #[Route('/supprimer/{id}/{pointure}', name: 'app_supprimer')]
    public function supprimer($pointure,$id,Panier $cart): Response
    {
        $cart->supprimerUn($id,$pointure);
        // on redirige
        return $this->redirectToRoute('app_panier_vu'); 
    }
}

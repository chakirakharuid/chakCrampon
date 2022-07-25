<?php
 
namespace App\Service;

use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Panier {

    protected $session;
    protected $produitRepository;

    public function __construct(SessionInterface $session,ProduitsRepository $produitRepository)
    {
        $this->session=$session;
        $this->produitRepository=$produitRepository;
    }


    public function nbrQuantite(){
        $cart =  $this->session->get('panier', []);
        $quant=0;
           foreach ($cart as $id){
                $quant=$quant+$id['quantiteTotal'];
           }
        //    dd($quant);
        return $quant;
    }

    public function ajouter(int $id, int $pointure =NULL){
        // $this->session->remove('panier');

        // dd(1);

        $cart =  $this->session->get('panier' , []);

        if (array_key_exists( $id, $cart) ) {
            $cart[$id] ['quantiteTotal'] = $cart[$id] ['quantiteTotal'] + 1 ;
            
        }
        //Sinon le produit nétait pas encore dans le panier 
        else {
        // Ajouter dans le tableau  [] l'identifiant et la quantité = 1
        // $cart[ identifiant du produit  ] = Quantité 1 par défaut
        $cart[$id] ['quantiteTotal'] = 1;

         $cart[$id]['id'] = $id;
        
        }
        // dd($cart[$id]);
       
       
        if (isset($pointure)){
            // 1)lLe produit  ne figure pas encore dans le panier 
            if (!isset($cart[$id]['pointures'])){
                
                $cart[$id]['pointures'][$pointure] = 1 ;
                
                //2) Si le produit est present dans le panier avec la meme pointure 
            } else if (array_key_exists($pointure, $cart[$id]['pointures'])) {
                $cart[$id]['pointures'][$pointure] = $cart[$id]['pointures'][$pointure] +1;
                //3) On ajoute le même produit avec une taille différente 
            } else{
                $cart[$id]['pointures'][$pointure] = 1;
            }

        } else {
            if(isset($cart[$id]['pointures']['aucune'])){
              $cart[$id]['pointures']['aucune']= $cart[$id]['pointures']['aucune'] + 1;
            }
            else{
              $cart[$id]['pointures']['aucune']=1;
            }
      
        }
 
     $this->session->set('panier',$cart);
   
 
    }

    public function vider(){
        // supprimer la variable cart contenant un tableau enregistré en session
        $this->session->remove('panier');
    }

    public function lePanier():array {
        if ($this->session->get('panier') != null) {
               // Recuperation du panier
       $cart=$this->session->get('panier' , []);
        // boucle sur le tableau : identifiant_produit => quantité
        // Recuperer les données du produits
    
            foreach ($cart as $id){
            $pointureQuantite = [];
                    foreach ($id['pointures'] as $pointure=> $quantitePointure) {
                        
                        $pointureQuantite[$pointure] = $quantitePointure;
                    }
              
                $cart_full[]=[
                    'product'=> $this->produitRepository->find($id['id']) ,
                    'quantite'=>$id['quantiteTotal'],
                    'taille'=>$pointureQuantite
                ];
                // dd($cart_full);

            }
            // dd($cart_full);
        

        }
    return $cart_full;
    }

    public function voirTotal(){

        $cart_full=$this->lePanier();
        $total=0;
        if ($cart_full!=""){
        
            foreach ($cart_full as $couple){
                  
                $total=$total + ($couple['product']->getPrix()*$couple['quantite']);
            }
        }   
        return $total;

    }
    
    public function supprimerUn(int $id, string $pointure = null){
        // on recupere le panier en session
        $cart=$this->session->get('panier' , []);

        if ($pointure == null) { // Si le produit à retirer n'a pas de taille

            // Suppression directement de la clé id du produit dans le panier
            unset($cart[$id]);

        }
        if ($pointure != null) {

            if (array_key_exists($pointure, $cart[$id]['pointures'])) { // Recherche de la taille à retirer

                // Quantité de la taille à retirer de la quantité totale

                $quantitytoremove = $cart[$id]['pointures'][$pointure];

                $cart[$id]['quantiteTotal'] = $cart[$id]['quantiteTotal'] - $quantitytoremove;

                if ($cart[$id]['quantiteTotal'] == 0) { // Si la quantité du produit dans le panier est à zéro

                    // Suppression dans le panier de la clé du produit et des valeurs correspondantes

                    unset($cart[$id]);
                } else {

                    // Suppression de la clé de la taille à retirer

                    unset($cart[$id]['pointures'][$pointure]);
                }
            }
         
        }
        $this->session->set('panier',$cart);
  }
}

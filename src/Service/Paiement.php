<?php
 
namespace App\Service;

use DateTime;
use App\Service\Panier;
use App\Entity\Commandes;
use App\Entity\CommandeLigne;
use App\Repository\ProduitsRepository;
use App\Repository\CommandesRepository;
use App\Repository\CommandeLigneRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Paiement {

private $cart;
private $session;
private $security;
private $commandesRepository;
private $commandeLigneRepository;
private $produitRepository;


    public function __construct(ProduitsRepository $produitRepository, CommandeLigneRepository $commandeLigneRepository,Panier $cart, SessionInterface $session, Security $security, CommandesRepository $commandesRepository)
    {
        $this->cart=$cart;
        $this->session=$session;
        $this->security=$security;
        $this->commandesRepository= $commandesRepository;
        $this->commandeLigneRepository= $commandeLigneRepository;
        $this->produitRepository= $produitRepository;
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

    public function envoiBd()
    {
        $carts =  $this->session->get('panier', []);

        //On entre les commandes en Basse de données
        // dd($cart_s);
        // On instencie les classes
        $ligne = new CommandeLigne();
        $commande = new Commandes();
        // On récupére l'identifiant du user grace a la fonction getUser() qu'on place dans une variable $user
        $user = $this->security->getUser();
        // On ajoute l'id de l'utilisateur dans l'entity commande 
        $commande->setUtilisateur($user);
        // On ajoute la date a laquel la commande s'est faite grace à la classe DateTime dans l'entity commande 
        $commande->setDateCommande(new DateTime());
        // On récupére le prix du pannier total on le mettant dans une variable $total
        $total = $this->cart->voirTotal();
        // On insére le prix total dans l'entity commande avec la fonction setPixTotal()
        $commande->setPrixTotal($total);
        // On ajoute le tout dans l'entity Commande
        $this->commandesRepository->add($commande);

        foreach ($carts as $id ) {
            // mescommandes correspond à ligne commande
            // dd($id['pointures']);
            $ligne = new CommandeLigne();
            
            // stock dans $p le produit correpond à $id issue du panier grace au Repository
            $p = $this->produitRepository->find($id['id']);
            // modifier l'entité et on utiliser setProduits pour inserer le produit dans l'entité commande
            $ligne->setProduits($p);
            foreach ($id['pointures'] as $pointure =>$quantite){
                  $pointureQuant[$pointure] =$quantite;
            }
            $ligne->setPointure($pointureQuant);
            // modifier l'entité et on utiliser setQuantite pour inserer la quantité dans l'entité commande
            $ligne->setQuantite($id['quantiteTotal']);
            $ligne->setPrixTotal($p->getPrix() * $id['quantiteTotal']);

            $ligne->setCommande($commande);

            // Ajout en BD de la la nouvelle ligne issue du panier
            // grâce à entity manager
            $this->commandeLigneRepository->add($ligne);
        }
    }
}

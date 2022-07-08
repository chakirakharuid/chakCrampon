<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChaussuresCramponsController extends AbstractController
{
    #[Route('/chaussures/crampons', name: 'app_chaussures_crampons')]
    public function index(ProduitsRepository $produitRepository): Response
    {
        return $this->render('chaussures_crampons/index.html.twig',[
            'produits' => $produitRepository->findBy(['categories' => 2]),
        ]);
   
    }

     #[Route('/show/{id}', name: 'app_crampons_show')]
    public function cramponShow(Produits $produit): Response
    {
        return $this->render('chaussures_crampons/show.html.twig',[
            'produit' => $produit,
        ]);


    } 
    
    #[Route('/configurer/crampon', name: 'app_configue')]
    public function creerCrampon(ProduitsRepository $produit): Response
    {

        return $this->render('chaussures_crampons/configue.html.twig',[
            'produits' => $produit->findCrampon('Semelle')
        ]);
    }
     #[Route('/configurer/matière', name: 'app_matiere')]
    public function creerMatiere(ProduitsRepository $produit): Response
    {

        return $this->render('chaussures_crampons/matiere.html.twig',[
            'produits' => $produit->findCrampon('Matière')
        ]);
    }  #[Route('/configurer/lacets', name: 'app_lacets')]
    public function creerLacets(ProduitsRepository $produit): Response
    {

        return $this->render('chaussures_crampons/lacets.html.twig',[
            'produits' => $produit->findCrampon('Lacets')
        ]);
    }
}

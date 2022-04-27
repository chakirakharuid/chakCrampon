<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessoiresController extends AbstractController
{
    #[Route('/accessoires', name: 'app_accessoires')]
    public function index(ProduitsRepository $produitRepository): Response
    {
        
        return $this->render('accessoires/index.html.twig', [
          'produits' => $produitRepository->findBy( ['categories' => 1]),
        ]);
    }
  #[Route('accessoires/{id}', name: 'app_accessoires_show', methods: ['GET'])]
  public function show(Produits $produit): Response
  {
    return $this->render('accessoires/show.html.twig', [
      'produit' => $produit,
    ]);
  }
}

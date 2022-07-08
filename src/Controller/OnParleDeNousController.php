<?php

namespace App\Controller;

use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OnParleDeNousController extends AbstractController
{
    #[Route('/onparledenous', name: 'app_on_parle_de_nous')]
    public function index(CommentairesRepository $commentairesRepository): Response
    {
        return $this->render('on_parle_de_nous/index.html.twig', [
            'commentaires' => $commentairesRepository->findAll(),
        ]);
    }
}


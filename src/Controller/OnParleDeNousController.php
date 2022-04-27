<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OnParleDeNousController extends AbstractController
{
    #[Route('/onparledenous', name: 'app_on_parle_de_nous')]
    public function index(): Response
    {
        return $this->render('on_parle_de_nous/index.html.twig', [
            'controller_name' => 'OnParleDeNousController',
        ]);
    }
}

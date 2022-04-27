<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChaussuresCramponsController extends AbstractController
{
    #[Route('/chaussures/crampons', name: 'app_chaussures_crampons')]
    public function index(): Response
    {
        return $this->render('chaussures_crampons/index.html.twig', [
            'controller_name' => 'ChaussuresCramponsController',
        ]);
    }
}

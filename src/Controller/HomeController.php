<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
        ]);
    } #[Route('/Politiques', name: 'app_politiques')]
    public function politique(): Response
    {
        return $this->render('home/politiques.html.twig', [
        ]);
    }#[Route('/Cgv', name: 'app_cgv')]
    public function cgv(): Response
    {
        return $this->render('home/cgv.html.twig', [
        ]);
    }#[Route('/mentions', name: 'app_mentions_legal')]
    public function mentions(): Response
    {
        return $this->render('home/mentionsLegal.html.twig', [
        ]);
    }
}

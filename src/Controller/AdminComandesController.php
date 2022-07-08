<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Form\CommandesType;
use App\Repository\CommandesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/comandes')]
class AdminComandesController extends AbstractController
{
    #[Route('/', name: 'app_admin_comandes_index', methods: ['GET'])]
    public function index(CommandesRepository $commandesRepository): Response
    {
        return $this->render('admin_comandes/index.html.twig', [
            'commandes' => $commandesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_comandes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandesRepository $commandesRepository): Response
    {
        $commande = new Commandes();
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandesRepository->add($commande);
            return $this->redirectToRoute('app_admin_comandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_comandes/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_comandes_show', methods: ['GET'])]
    public function show(Commandes $commande): Response
    {
        return $this->render('admin_comandes/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_comandes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commandes $commande, CommandesRepository $commandesRepository): Response
    {
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandesRepository->add($commande);
            return $this->redirectToRoute('app_admin_comandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_comandes/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_comandes_delete', methods: ['POST'])]
    public function delete(Request $request, Commandes $commande, CommandesRepository $commandesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $commandesRepository->remove($commande);
        }

        return $this->redirectToRoute('app_admin_comandes_index', [], Response::HTTP_SEE_OTHER);
    }
}

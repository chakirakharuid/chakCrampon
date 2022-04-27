<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Service\Telechargement;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/produits')]
class AdminProduitsController extends AbstractController
{
    #[Route('/', name: 'app_admin_produits_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository): Response
    {
        return $this->render('admin_produits/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_produits_new', methods: ['GET', 'POST'])]
    public function new(Telechargement $fileUploader, Request $request, ProduitsRepository $produitsRepository): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // le fichier qu'on recupere depuis le form
            $file = $form->get('image')->getData();
            // Si il existe bien alors
            if ($file) {
                // on l'envoie sur le serveur grace au service
                $FileName = $fileUploader->upload($file); // upload du fichier
                $produit->setImage($FileName); // nom du fichier
            }
            $produitsRepository->add($produit);
            return $this->redirectToRoute('app_admin_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('admin_produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Telechargement $fileUploader,Request $request, Produits $produit, ProduitsRepository $produitsRepository): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // le fichier qu'on recupere depuis le form
            $file = $form->get('image')->getData();
            // Si il existe bien alors
            if ($file) {
                // on l'envoie sur le serveur grace au service
                $FileName = $fileUploader->upload($file); // upload du fichier
                $produit->setImage($FileName); // nom du fichier
            }
            $produitsRepository->add($produit);
            return $this->redirectToRoute('app_admin_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, ProduitsRepository $produitsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitsRepository->remove($produit);
        }

        return $this->redirectToRoute('app_admin_produits_index', [], Response::HTTP_SEE_OTHER);
    }
}

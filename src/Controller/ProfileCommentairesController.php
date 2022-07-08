<?php

namespace App\Controller;

use DateTime;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profil/commentaires')]
class ProfileCommentairesController extends AbstractController
{
 
    #[Route('/new', name: 'app_profile_commentaires_new')]
    public function new(Request $request, CommentairesRepository $commentairesRepository): Response
    {
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        $commentaire->setDateCommentaire(new DateTime());
        
        if ($form->isSubmitted() && $form->isValid()) {
            $commentairesRepository->add($commentaire);
            $this->addFlash(
                'message',
                'Votre commentaire a bien été transmis.'
            ); 
            return $this->redirectToRoute('app_profile_commentaires_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile_commentaires/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }


  
}

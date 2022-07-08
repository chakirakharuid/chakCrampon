<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\CommandeLigne;
use App\Form\UtilisateursType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CommandeLigneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profil')]
class MoncompteController extends AbstractController
{
    #[Route('/moncompte', name: 'app_moncompte')]
    public function index(): Response
    {
        return $this->render('moncompte/index.html.twig');

    }    #[Route('pass', name: 'app_mot_de_passe')]
    public function editPass( Request $request, UserPasswordHasherInterface $passwordEncoder,ManagerRegistry $mana): Response
    {
        if($request->isMethod('POST')){
         $em = $mana->getManager();
         $user = $this->getUser();
         if($request->request->get('pass')==$request->request->get('pass2')){
             $user->setPassword($passwordEncoder->hashPassword($user, $request->request->get('pass')));
             $em->flush();
             $this->addFlash('message', 'Mot de passe mis à jour avec succès');
         }else{
             $this->addFlash('error','Les deux mots de passe ne sont pas identiques');
         }

        }
        return $this->render('moncompte/editpass.html.twig');

    }
      #[Route('/modifier', name: 'app_moncompte_modifier', methods: ['GET', 'POST'])]
    public function modifier(Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        if (!$user){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(UtilisateursType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($user);
            $em->persist($user);
           $em->flush();
            $this->addFlash('message',
                'Vos informations ont été mis à jour avec succès'
            );
            return $this->redirectToRoute('app_moncompte', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->render('moncompte/modifier.html.twig', [
            'form'=>$form->createView(),
            'user'=>  $user ,
        ]);
    }


    #[Route('/supprimer', name: 'app_moncompte_supprimer')]
    public function supprimer( EntityManagerInterface $em, Request $request,SessionInterface $session): Response
    {
     if ($request->isMethod('POST')){
         $user = $this->getUser();
         $this->container->get('security.token_storage')->setToken(null);
         
         $em->remove($user);
         $em->flush();
         $session = new Session();
         $session->invalidate();
        }
        
    $this->addFlash('mess', 'Votre compte utilisateur a bien été supprimé !'); 

return $this->redirectToRoute('app_connexion');
    }

    #[Route('/mescommandes', name: 'app_moncompte_commandes')]
    public function commandes(): Response
    {
        $id = $this->getUser();
        $em = $this->container->get('doctrine')->getManager();
    
            $result = $em->getRepository(CommandeLigne::class)->createQueryBuilder('l')
                ->select('l')
                ->join('l.commande', 'c')
                ->join('c.utilisateur', 'u')
                ->join('l.produits', 'p')
                ->where('c.utilisateur = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getResult();
  

                // dd($result);
        return $this->render('moncompte/mesCommandes.html.twig',[

            'commandes'=>$result
        ]);
    }
}




// public function update(ManagerRegistry $doctrine, int $id): Response
//     {
//         $entityManager = $doctrine->getManager();
//         $product = $entityManager->getRepository(Product::class)->find($id);

//         if (!$product) {
//             throw $this->createNotFoundException(
//                 'No product found for id '.$id
//             );
//         }

//         $product->setName('New product name!');
//         $entityManager->flush();

//         return $this->redirectToRoute('product_show', [
//             'id' => $product->getId()
//         ]);
    // }

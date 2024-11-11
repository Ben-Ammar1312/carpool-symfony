<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;


class ProfilemanagementController extends AbstractController
{
    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    #[Route('/profilemanagement', name: 'app_profilemanagement')]
    public function index(): Response
    {
        $user = $this->utilisateurRepository->findOneBy(['id'=>8]);
        return $this->render('profilemanagement/index.html.twig', [
            'controller_name' => 'ProfilemanagementController',
            'user' => $user,
        ]);
    }


    #[Route('/profile/update', name: 'app_profile_update', methods: ['POST'])]
    public function updateProfile(Request $request, ManagerRegistry $doctrine): Response
    {


        $id = $request->request->get('id');
        //echo $request->request->get('id');
        $entityManager = $doctrine->getManager();

        // Find the user by `id`
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur not found');
        }

        // Update fields only if they were changed in the form
        if ($request->request->get('nom') != NUll){
            $utilisateur->setNom($request->request->get('nom'));
        }
        if ($request->request->get('prenom') != NUll){
            $utilisateur->setPrenom($request->request->get('prenom'));
        }
        if ($request->request->get('email') != NUll){
            $utilisateur->setEmail($request->request->get('email'));
        }
        if ($request->request->get('password') != NUll){
            $utilisateur->setPassword($request->request->get('password'));
        }
        if ($request->request->get('username') != NUll){
            $utilisateur->setUsername($request->request->get('username'));
        }
        if ($request->request->get('profilePic') != NUll){
            $utilisateur->setProfilePic($request->request->get('profilePic'));
        }


        $entityManager->flush();

        return $this->redirectToRoute('app_profilemanagement');
    }


    #[Route('/profile/delete', name: 'app_delete_account', methods: ['POST'])]
    public function deleteAccount(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the user ID from the request
        $data = json_decode($request->getContent(), true);
        $userId = $data['id'];

        // Find the user by ID
        $user = $entityManager->getRepository(Utilisateur::class)->find($userId);

        if (!$user) {
            return new JsonResponse(['status' => 'error', 'message' => 'User not found'], 404);
        }

        // Delete the user
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->render('security/login.html.twig');
    }
}



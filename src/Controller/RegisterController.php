<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Conducteur;
use App\Entity\Passager;
use App\Entity\Utilisateur;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ): Response {
        $form = $this->createForm(RegisterFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les mots de passe
            $plaintextPassword = $form->get('plainPassword')->getData();
            $confirmPassword = $form->get('confirm_password')->getData();

            // Vérifier si les mots de passe correspondent
            if ($plaintextPassword !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('app_register');
            }

            // Gestion des rôles
            $type = $form->get('type')->getData(); // Récupérer la valeur du champ 'type'

            // Instantiate the correct subclass based on type
            switch ($type) {
                case 'conducteur':
                    $user = new Conducteur();
                    break;
                case 'passager':
                    $user = new Passager();
                    break;
                case 'admin':
                    $user = new Admin();
                    break;
                default:
                    $user = new Utilisateur();
                    break;
            }

            // Map form data to user
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setTelephone($form->get('telephone')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setGenre($form->get('genre')->getData());

            // Handle roles
            $roles = [Utilisateur::ROLE_USER]; // Rôle par défaut
            if ($type === 'conducteur') {
                $roles[] = Utilisateur::ROLE_CONDUCTEUR;
            } elseif ($type === 'passager') {
                $roles[] = Utilisateur::ROLE_PASSAGER;
            } elseif ($type === 'admin') {
                $roles[] = Utilisateur::ROLE_ADMIN;
            }
            $user->setRoles($roles);

            // Gestion de l'upload de la photo de profil
            $file = $form->get('profilePic')->getData();
            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/profile_pics',
                        $fileName
                    );
                    $user->setProfilePic('/uploads/profile_pics/' . $fileName);
                } catch (FileException) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('app_register');
                }
            } else {
                // Définir une image par défaut si aucune image n'est fournie
                $user->setProfilePic('/images/default-profile.png');
            }

            // Hashage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($hashedPassword);

            // Enregistrer l'utilisateur
            try {
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Inscription réussie !');

                return $this->redirectToRoute('app_login');
            } catch (Exception $e) {
                $logger->error('Erreur lors de l\'enregistrement: ' . $e->getMessage());
                $this->addFlash('error', 'Erreur lors de l\'enregistrement.');
            }
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
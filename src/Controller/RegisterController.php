<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Conducteur;
use App\Entity\Passager;
use App\Entity\Utilisateur;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
            // Vérification des mots de passe
            $plaintextPassword = $form->get('plainPassword')->getData();
            $confirmPassword = $form->get('confirm_password')->getData();

            if ($plaintextPassword !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('app_register');
            }

            // Récupération du type d'utilisateur et définition des rôles
            $type = $form->get('type')->getData();
            $roles = [Utilisateur::ROLE_USER];

            switch ($type) {
                case 'conducteur':
                    $roles[] = Utilisateur::ROLE_CONDUCTEUR;
                    break;
                case 'passager':
                    $roles[] = Utilisateur::ROLE_PASSAGER;
                    break;
                case 'admin':
                    $roles[] = Utilisateur::ROLE_ADMIN;
                    break;
                default:
                    // Optionnel: gérer les types inattendus
                    $this->addFlash('error', 'Type d\'utilisateur invalide.');
                    return $this->redirectToRoute('app_register');
            }
            $user->setRoles($roles);

            // Gestion de la photo de profil
            $file = $form->get('profilePic')->getData();
            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/profile_pics',
                        $fileName
                    );
                    $user->setProfilePic('/uploads/profile_pics/' . $fileName);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('app_register');
                }
            } else {
                $user->setProfilePic('/images/default-profile.png');
            }

            // Hash du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($hashedPassword);

            // Récupération des autres données
            $user->setGenre($form->get('genre')->getData());
            $user->setCin($form->get('cin')->getData());
            $user->setAdresse($form->get('adresse')->getData());
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setTelephone($form->get('telephone')->getData());

            try {
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Inscription réussie !');

                return $this->redirectToRoute('app_login');
            } catch (\Exception $e) {
                $logger->error('Erreur lors de l\'enregistrement: ' . $e->getMessage());
                $this->addFlash('error', 'Erreur lors de l\'enregistrement.');
            }
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
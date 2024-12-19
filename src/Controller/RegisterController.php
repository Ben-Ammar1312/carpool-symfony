<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RegisterController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/register', name: 'app_register')]
    public function index(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ): Response {
        $user = new Utilisateur();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve passwords from form data
            $plaintextPassword = $form->get('plainPassword')->getData();
            $confirmPassword = $form->get('confirm_password')->getData();

            // Check if passwords match
            if ($plaintextPassword !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('app_register');
            }

            // Profile picture upload
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
                // Set default profile picture if none is provided
                $user->setProfilePic('/images/default-profile.png');
            }

            // Hash password and save user
            $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($hashedPassword);

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

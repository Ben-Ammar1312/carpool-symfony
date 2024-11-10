<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SignupController extends AbstractController
{
    #[Route('/signup', name: 'signup')]
    public function sign(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {

        $user = new Utilisateur();


        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $plaintextPassword = $user->getPassword();

            $confirmPassword = $request->get('confirm_password');

            if ($plaintextPassword !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('signup');
            }
            $file = $form->get('profilePic')->getData();
            if ($file) {

                $fileName = uniqid() . '.' . $file->guessExtension();


                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/profile_pics', //fich dans public
                        $fileName
                    );


                    $user->setProfilePic('/uploads/profile_pics/' . $fileName); //lien fich dans base
                } catch (IOExceptionInterface) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('signup');
                }
            }



            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );



            $user->setPassword($hashedPassword);
            try {
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Inscription réussie !');
                return $this->redirectToRoute('signup');
            } catch (Exception $e) {

                dump($e->getMessage());
                $this->addFlash('error', 'Erreur lors de l\'enregistrement.');
            }



            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('success', 'Inscription réussie !');


            return $this->redirectToRoute('home');
        }


        return $this->render('sign-up.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

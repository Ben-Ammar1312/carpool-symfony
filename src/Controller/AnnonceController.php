<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/annonce')]
final class AnnonceController extends AbstractController
{
    #[Route(name: 'app_annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
<<<<<<< HEAD
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->getPayload()->getString('_token'))) {
=======
        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $request->getPayload()->getString('_token'))) {
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }
<<<<<<< HEAD
    /**
     * Récupère toutes les annonces d'un conducteur donné.
     *
     * @param Conducteur $conducteur
     * @return Annonce[]
     */
    public function getAnnoncesByConducteur(Conducteur $conducteur): array
    {
        return $this->annonceRepository->findBy(['conducteur' => $conducteur]);
    }

    /**
     * Récupère les suggestions de waypoints pour une annonce donnée.
     *
     * @param int $annonceId
     * @return Waypoint[]
     */
    public function getWaypointSuggestionsByAnnonce(int $annonceId): array
    {
        return $this->waypointRepository->findBy(['annonce' => $annonceId]);
    }
    #[Route('/annonces/add', name: 'add_annonce')]
    public function addAnnonce(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            $this->addFlash('success', 'Ride posted successfully!');
            return $this->redirectToRoute('add_annonce');
        }
        $googleApiKey = 'votre_clé_api_google_maps';  // Remplacez par votre clé API réelle

        return $this->render('annonce/add.html.twig', [
            'annonceForm' => $form->createView(),
            'googleApiKey' => $googleApiKey,  // Passer la clé API à Twig
        ]);

    }

=======
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
}

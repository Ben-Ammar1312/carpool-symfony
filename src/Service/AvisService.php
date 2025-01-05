<?php

namespace App\Service;

use App\Entity\Avis;
use App\Entity\Conducteur;
use App\Entity\Passager;
use App\Enum\AvisType;
use App\Repository\AvisRepository;
use App\Repository\ConducteurRepository;
use App\Repository\PassagerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AvisService
{
    private $avisRepository;
    private $conducteurRepository;
    private $passagerRepository;
    private $entityManager;

    public function __construct(
        AvisRepository $avisRepository,
        ConducteurRepository $conducteurRepository,
        PassagerRepository $passagerRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->avisRepository = $avisRepository;
        $this->conducteurRepository = $conducteurRepository;
        $this->passagerRepository = $passagerRepository;
        $this->entityManager = $entityManager;
    }

    public function saveAvis(int $conducteurId, int $passagerId, float $rating, AvisType $type): Avis
    {
        // Récupérer le conducteur et le passager
        $conducteur = $this->conducteurRepository->find($conducteurId);
        if (!$conducteur) {
            throw new NotFoundHttpException("Conducteur not found");
        }

        $passager = $this->passagerRepository->find($passagerId);
        if (!$passager) {
            throw new NotFoundHttpException("Passager not found");
        }

        // Créer un nouvel avis
        $avis = new Avis();
        $avis->setNote($rating);
        $avis->setConducteur($conducteur);
        $avis->setPassager($passager);
        $avis->setAvisType($type);

        // Sauvegarder l'avis
        $this->entityManager->persist($avis);
        $this->entityManager->flush();

        // Recalculer la note moyenne
        if ($type === AvisType::PASSENGER_TO_DRIVER) {
            $newAvg = $this->avisRepository->findAverageRatingForDriver($conducteurId);
            $conducteur->setNote($newAvg);
            $this->entityManager->persist($conducteur);
        } elseif ($type === AvisType::DRIVER_TO_PASSENGER) {
            $newAvg = $this->avisRepository->findAverageRatingForPassenger($passagerId);
            $passager->setNote($newAvg);
            $this->entityManager->persist($passager);
        }

        $this->entityManager->flush();

        return $avis;
    }
}


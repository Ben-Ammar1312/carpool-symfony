<?php

namespace App\Service;

use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;

class ReclamationService
{
    private ReclamationRepository $reclamationRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ReclamationRepository $reclamationRepository, EntityManagerInterface $entityManager)
    {
        $this->reclamationRepository = $reclamationRepository;
        $this->entityManager = $entityManager;
    }

    public function findById(int $idReclamation): ?Reclamation
    {
        return $this->reclamationRepository->find($idReclamation); // Returns null if not found
    }

    public function save(Reclamation $reclamation): void
    {
        $this->entityManager->persist($reclamation);
        $this->entityManager->flush();
    }
}

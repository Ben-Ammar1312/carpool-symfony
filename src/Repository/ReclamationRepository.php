<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    // Fetch complaints, ordered by status (open first)
    public function findAllOrderedByStatus()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.status', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countByStatus(Status $status)
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getSingleScalarResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\WaypointSuggestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class WaypointSuggestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WaypointSuggestion::class);
    }

    public function findByAnnonceId(int $annonceId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.annonce = :annonceId')
            ->setParameter('annonceId', $annonceId)
            ->getQuery()
            ->getResult();
    }
}

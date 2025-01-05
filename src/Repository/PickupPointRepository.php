<?php

namespace App\Repository;

use App\Entity\PickupPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PickupPoint>
 *
 * @method PickupPoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method PickupPoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method PickupPoint[]    findAll()
 * @method PickupPoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PickupPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PickupPoint::class);
    }

    /**
     * @param int $annonceId
     * @return PickupPoint[]
     */
    public function findByAnnonceId(int $annonceId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.annonce = :annonceId')
            ->setParameter('annonceId', $annonceId)
            ->getQuery()
            ->getResult();
    }
}

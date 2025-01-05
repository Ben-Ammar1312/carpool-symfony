<?php

namespace App\Repository;

use App\Entity\Waypoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

<<<<<<< HEAD
/**
 * @extends ServiceEntityRepository<Waypoint>
 *
 * @method Waypoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Waypoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Waypoint[]    findAll()
 * @method Waypoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
=======
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
class WaypointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Waypoint::class);
    }
<<<<<<< HEAD

    /**
     * Exemple de méthode personnalisée
     *
     * @param string $value
     * @return Waypoint[] Returns an array of Waypoint objects
     */
    public function findByExampleField(string $value): array
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
=======
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
}

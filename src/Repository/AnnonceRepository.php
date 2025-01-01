<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annonce>
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

//    /**
//     * @return Annonce[] Returns an array of Annonce objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Annonce
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @param int $conducteurId
     * @return Annonce[] Returns an array of Annonce objects for the given conducteur
     */
    public function findByConducteurId(int $conducteurId): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.conducteur = :conducteurId')
            ->setParameter('conducteurId', $conducteurId)
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    /**
     * @return Annonce[] Returns an array of active Annonce objects
     */
    public function findActiveAnnonces(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->setParameter('status', 'active') // Remplacez 'active' par la valeur utilisée dans votre application
            ->orderBy('a.createdAt', 'DESC') // Tri par date de création
            ->getQuery()
            ->getResult();
    }


}

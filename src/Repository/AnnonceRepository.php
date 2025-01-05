<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\Conducteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function findByConducteur(Conducteur $conducteur): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.pickupPoints', 'p')
            ->leftJoin('a.waypoints', 'w')
            ->leftJoin('a.reservations', 'r')
            ->leftJoin('a.waypointSuggestions', 'ws')
            ->where('a.conducteur = :conducteur')
            ->setParameter('conducteur', $conducteur)
            ->getQuery()
            ->getResult();
    }

<<<<<<< HEAD
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


=======
    public function searchRides(
        ?string $lieuDepart,
        ?string $lieuArrivee,
        ?string $dateDepart,
        ?int $nbrPlaces,
        ?float $maxPrice
    ): array {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.pickupPoints', 'p')
            ->leftJoin('a.waypoints', 'w')
            ->leftJoin('a.reservations', 'r')
            ->leftJoin('a.waypointSuggestions', 'ws')
            ->where('a.lieuDepart LIKE :lieuDepart')
            ->setParameter('lieuDepart', "%$lieuDepart%")
            ->andWhere('a.lieuArrivee LIKE :lieuArrivee')
            ->setParameter('lieuArrivee', "%$lieuArrivee%")
            ->andWhere('a.dateDepart = :dateDepart')
            ->setParameter('dateDepart', $dateDepart)
            ->andWhere('a.nbrPlaces >= :nbrPlaces')
            ->setParameter('nbrPlaces', $nbrPlaces)
            ->andWhere('a.prix <= :maxPrice')
            ->setParameter('maxPrice', $maxPrice);

        return $qb->getQuery()->getResult();
    }
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
}

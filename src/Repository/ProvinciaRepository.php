<?php

namespace App\Repository;

use App\Entity\Pais;
use App\Entity\Provincia;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Provincia>
 */
class ProvinciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Provincia::class);
    }




    public function filtrar(?Pais $pais, ?int $minPoblacion, ?float $maxSuperficie): array
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.pais', 'pais')
            ->addSelect('pais');
    
        if ($pais) {
            $qb->andWhere('p.pais = :pais')
                ->setParameter('pais', $pais);
        }
    
        if ($minPoblacion !== null) {
            $qb->andWhere('p.poblacion >= :minPoblacion')
                ->setParameter('minPoblacion', $minPoblacion);
        }
    
        if ($maxSuperficie !== null) {
            $qb->andWhere('p.superficie <= :maxSuperficie')
                ->setParameter('maxSuperficie', $maxSuperficie);
        }
    
        return $qb->getQuery()->getResult();
    }







    //    /**
    //     * @return Provincia[] Returns an array of Provincia objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Provincia
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

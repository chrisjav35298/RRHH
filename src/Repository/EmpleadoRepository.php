<?php

namespace App\Repository;

use App\Entity\Empleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Empleado>
 */
class EmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empleado::class);
    }


    public function obtenerTodos()
    {
        return $this->createQueryBuilder('e')
            ->select('e.id', 'e.nombre', 'e.apellido', 'p.nombre AS puesto', 'd.nombre AS departamento', 'u.calle AS direccion', 'pr.nombre AS provincia', 'pa.nombre AS pais')
            ->join('e.puesto', 'p')
            ->join('e.departamento', 'd')
            ->join('d.ubicacion', 'u')
            ->join('u.provincia', 'pr')
            ->join('pr.pais', 'pa')
            ->getQuery()
            ->getArrayResult();
    }








    // public function obtenerInfo($value)
    // {
    //     return $this->createQueryBuilder('e')
    //         ->addSelect('p', 'd', 'u', 'pr', 'pa')
    //         ->join('e.puesto', 'p')
    //         ->join('e.departamento', 'd')
    //         ->join('d.ubicacion', 'u')
    //         ->join('u.provincia', 'pr')
    //         ->join('pr.pais', 'pa')
    //         ->where('e.id = :id')
    //         ->setParameter('id', $value)
    //         ->getQuery()
    //         ->getResult();
    // }

    //    /**
    //     * @return Empleado[] Returns an array of Empleado objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Empleado
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

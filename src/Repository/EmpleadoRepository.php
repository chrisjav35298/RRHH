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

    public function contarPorDepartamento()
    {
        return $this->createQueryBuilder('e')
            ->select('d.nombre AS departamento, COUNT(e.id) AS cantidad')
            ->join('e.departamento', 'd')
            ->groupBy('d.nombre')
            ->getQuery()
            ->getArrayResult();
    }

    public function contarPorPais()
    {
        return $this->createQueryBuilder('e')
            ->select('pa.nombre AS pais, COUNT(e.id) AS cantidad')
            ->join('e.departamento', 'd')
            ->join('d.ubicacion', 'u')
            ->join('u.provincia', 'pr')
            ->join('pr.pais', 'pa')
            ->groupBy('pa.nombre')
            ->getQuery()
            ->getArrayResult();
    }


    public function salarioPorPuesto()
    {
        return $this->createQueryBuilder('e')
            ->select('p.nombre AS puesto, AVG(e.salario) AS salario_promedio, COUNT(e.id) AS cantidad')
            ->join('e.puesto', 'p')
            ->groupBy('p.nombre')
            ->orderBy('salario_promedio', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }

}

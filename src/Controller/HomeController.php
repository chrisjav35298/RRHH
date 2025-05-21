<?php

namespace App\Controller;

use App\Entity\Empleado;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/empleados', name: 'empleados_listado')]
    public function listarEmpleados(EntityManagerInterface $em): Response
    {
        $empleados = $em->getRepository(Empleado::class)->obtenerTodos();
    
        return $this->render('empleado/listado.html.twig', [
            'empleados' => $empleados,
        ]);
    }

    

    #[Route('/empleado/{id}', name: 'empleado')]
    public function obtenerEmpleadoId(EntityManagerInterface $em,$id): Response
    {
         $empleadoInfo = $em->getRepository(Empleado::class)->obtenerInfo($id); dd( $empleadoInfo);

         if (!$empleadoInfo) {
             throw $this->createNotFoundException('Empleado no encontrado.');
         }
    
         return $this->render('empleado/empleado.html.twig', [
           'empleadoInfo' => $empleadoInfo,
        ]);
    }

    #[Route('/salario/{value}', name: 'salario')]
    public function obtenerEmp(EntityManagerInterface $em, $value): Response
    {
        $query = $em->createQuery('
            SELECT e.salario, d.nombre AS nombreDepartamento
            FROM App\Entity\Empleado e
            JOIN e.departamento d
            WHERE e.salario < :value
        ');
        $query->setParameter('value', $value);  
        
        $resultado = $query->getResult();  dd($resultado);
    
        if (!$resultado) {
            throw $this->createNotFoundException('Empleado no encontrado.');
        }
    
        return $this->json($resultado);
    }
    

}
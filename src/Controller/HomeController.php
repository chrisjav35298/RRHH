<?php

namespace App\Controller;

use App\Entity\Empleado;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

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

    // graficos
    #[Route('/reporte/departamentos', name: 'reporte_departamentos')]
    public function reporteDepartamentos(EntityManagerInterface $em): Response
    {
        $datos = $em->getRepository(Empleado::class)->contarPorDepartamento();

        $labels = array_column($datos, 'departamento'); //dump($labels);
        $values = array_column($datos, 'cantidad'); //dd($values );

        return $this->render('reportes/departamentos.html.twig', [
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    #[Route('/reporte/paises', name: 'reporte_paises')]
    public function reportePaises(EntityManagerInterface $em): Response
    {
        $datos = $em->getRepository(Empleado::class)->contarPorPais();

        $labels = array_column($datos, 'pais');
        $values = array_column($datos, 'cantidad');

        return $this->render('reportes/paises_grafico.html.twig', [
            'labels' => $labels,
            'values' => $values,
        ]);
    }


    #[Route('/reporte/departamentos', name: 'reporte_departamentos')]
    public function reporteSalariosPorPuesto(EntityManagerInterface $em): Response
    {
        $datos = $em->getRepository(Empleado::class)->contarPorDepartamento();

        $labels = array_column($datos, 'departamento'); //dump($labels);
        $values = array_column($datos, 'cantidad'); //dd($values );

        return $this->render('reportes/departamentos.html.twig', [
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    #[Route('/reporte/salarios', name: 'reporte_salario')]
    public function salarioPorPuesto(EntityManagerInterface $em): Response
    {
        $datos = $em->getRepository(Empleado::class)->salarioPorPuesto(); 
        $labels = array_column($datos, 'puesto');
        $values = array_column($datos, 'salario_promedio');//dd($labels, $values);

        return $this->render('reportes/salario_puesto.html.twig', [
            'labels' => $labels,
            'values' => $values,
        ]);
    }
                

}
<?php

namespace App\Controller;

use App\Entity\Puesto;
use App\Form\PuestoType;
use App\Repository\PuestoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PuestoController extends AbstractController
{
    #[Route('/puestos', name: 'puesto_index', methods: ['GET'])]
    public function index(PuestoRepository $puestoRepository): Response
    {
        return $this->render('puesto/index.html.twig', [
            'puestos' => $puestoRepository->findAll(),
        ]);
    }


    #[Route('/puesto/new', name: 'app_puesto_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $puesto = new Puesto();
        $form = $this->createForm(PuestoType::class, $puesto); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($puesto);
            $entityManager->flush();

            return $this->redirectToRoute('puesto_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('puesto/new.html.twig', [
            'form' => $form->createView(),
            'pais' => $puesto ,

        ]);
    }

    #[Route('/puesto/{id}/edit', name: 'app_puesto_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager,Puesto $puesto): Response
    { 
      
        $form = $this->createForm(PuestoType::class, $puesto); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($puesto);
            $entityManager->flush();

            return $this->redirectToRoute('puesto_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('puesto/edit.html.twig', [
            'form' => $form->createView(),
            'pais' => $puesto ,

        ]);
    }

    #[Route('/puesto/{id}/show', name: 'app_puesto_show')]
    public function show(Puesto $puesto): Response
    {
        return $this->render('puesto/show.html.twig', [
            'puesto' => $puesto,
        ]);
    }

    #[Route('/puesto/resultado', name: 'app_puesto_buscar')]
    public function buscar(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Creamos el formulario directamente
        $form_buscar = $this->createFormBuilder(null)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre del puesto',
                'required' => false,
            ])
            ->getForm();
    
        $form_buscar->handleRequest($request);
    
        $puestos = [];
    
        if ($form_buscar->isSubmitted() && $form_buscar->isValid()) {
            $data = $form_buscar->getData(); // dd($data);
            $nombre = $data['nombre'];
    
            // Hacemos una búsqueda simple por nombre
            $puestos = $entityManager->getRepository(Puesto::class)
                ->createQueryBuilder('p')
                ->where('LOWER(p.nombre) LIKE :nombre')
                ->setParameter('nombre', '%' . strtolower($nombre) . '%')
                ->getQuery()
                ->getResult();
        }
    
        return $this->render('puesto/buscar.html.twig', [
            'form_buscar' => $form_buscar->createView(),
            'puestos' => $puestos,
        ]);
    }
    
}

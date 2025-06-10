<?php

namespace App\Controller;

use App\Form\PaisType;
use App\Repository\PaisRepository;
use App\Repository\ProvinciaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProvinciaController extends AbstractController
{
    #[Route('/provincia', name: 'provincia_index', methods: ['GET'])]
    public function index(ProvinciaRepository $provinciaRepository): Response
    {
        return $this->render('provincia/index.html.twig', [
            'provincias' => $provinciaRepository->findAll(),
        ]);
    }


    // #[Route('/pais/new', name: 'app_pais_new')]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $pais = new Pais();
    //     $pais->addProvincia(new Provincia()); //esta linea la necesitamos por si en la BD no hay prov aún
    //     $form = $this->createForm(PaisType::class, $pais); 
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($pais);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('pais_index', [], Response::HTTP_SEE_OTHER);
    //     }
    //     return $this->render('pais/new.html.twig', [
    //         'form' => $form->createView(),
    //         'pais' => $pais,

    //     ]);
    // }


    // #[Route('/pais/{id}/edit', name: 'app_pais_edit')]
    // public function edit(Request $request, EntityManagerInterface $entityManager, Pais $pais): Response
    // {  
    //     $form = $this->createForm(PaisType::class, $pais);  
    //     $form->handleRequest($request); dd($form->getData());
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($pais);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('pais_index', [], Response::HTTP_SEE_OTHER);
    //     }
        
    //     return $this->render('pais/edit.html.twig', [
    //         'form' => $form->createView(),
    //         'pais' => $pais,

    //     ]);
    // }
    
}

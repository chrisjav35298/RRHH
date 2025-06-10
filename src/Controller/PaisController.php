<?php

namespace App\Controller;

use App\Entity\Pais;
use App\Form\PaisType;
use App\Entity\Provincia;
use App\Repository\PaisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PaisController extends AbstractController
{
    #[Route('/pais', name: 'pais_index', methods: ['GET'])]
    public function index(PaisRepository $paisRepository): Response
    {
        return $this->render('pais/index.html.twig', [
            'paises' => $paisRepository->findAll(),
        ]);
    }


    #[Route('/pais/new', name: 'app_pais_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pais = new Pais();
        $pais->addProvincia(new Provincia()); //esta linea la necesitamos por si en la BD no hay prov aún
        $form = $this->createForm(PaisType::class, $pais); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pais);
            $entityManager->flush();

            return $this->redirectToRoute('pais_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('pais/new.html.twig', [
            'form' => $form->createView(),
            'pais' => $pais,

        ]);
    }


    #[Route('/pais/{id}/edit', name: 'app_pais_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Pais $pais): Response
    {  
        $form = $this->createForm(PaisType::class, $pais);  
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('pais_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('pais/edit.html.twig', [
            'form' => $form->createView(),
            'pais' => $pais,

        ]);
    }

    #[Route('/pais/{id}/show', name: 'app_pais_show')]
    public function show(Pais $pais): Response
    {
        return $this->render('pais/show.html.twig', [
            'pais' => $pais,
        ]);
    }

    //metodo en el controlador para buscar un determinado pais
    #[Route('/pais/resultado', name: 'app_pais_buscar')]
    public function buscar(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Creamos el formulario directamente
        $form_buscar = $this->createFormBuilder(null)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre del país',
                'required' => false,
            ])
            ->getForm();
    
        $form_buscar->handleRequest($request);
    
        $paises = [];
    
        if ($form_buscar->isSubmitted() && $form_buscar->isValid()) {
            $data = $form_buscar->getData(); // dd($data);
            $nombre = $data['nombre'];
    
            // Hacemos una búsqueda simple por nombre
            $paises = $entityManager->getRepository(Pais::class)
                ->createQueryBuilder('p')
                ->where('LOWER(p.nombre) LIKE :nombre')
                ->setParameter('nombre', '%' . strtolower($nombre) . '%')
                ->getQuery()
                ->getResult();
        }
    
        return $this->render('pais/buscar.html.twig', [
            'form_buscar' => $form_buscar->createView(),
            'paises' => $paises,
        ]);
    }
    
}

<?php

namespace App\Controller;

use App\Form\PaisType;
use App\Repository\PaisRepository;
use App\Repository\ProvinciaRepository;
use App\Form\Filtro\ProvinciaFiltroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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


    #[Route('/provincia/reporte', name: 'provincia_reporte')]
    public function reporteProvinciaAction(Request $request, ProvinciaRepository $provinciaRepository): Response
    {
        $form = $this->createForm(ProvinciaFiltroType::class);
        $form->handleRequest($request);
    
        // Se van a obtener todas las provincias por defecto, se tendria que paginar 
        $provincias = $provinciaRepository->findAll();
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
    
            $pais = null;
            $minPoblacion = null;
            $maxSuperficie = null;
    
            if (isset($data['pais'])) {
                $pais = $data['pais'];
            }
    
            if (isset($data['minPoblacion'])) {
                $minPoblacion = $data['minPoblacion'];
            }
    
            if (isset($data['maxSuperficie'])) {
                $maxSuperficie = $data['maxSuperficie'];
            }
    
            // Se modifica la lista solo si se envió el formulario
            $provincias = $provinciaRepository->filtrar($pais, $minPoblacion, $maxSuperficie);
        }
    
        return $this->render('reportes/provinciaReporte.html.twig', [
            'form_filtro' => $form->createView(),
            'provincias' => $provincias,
        ]);
    }
    



    #[Route('/provincia/exportar/excel', name: 'reporte_excel')]
    public function exportarExcel(Request $request, PaisRepository $paisRepository, ProvinciaRepository $provinciaRepository): StreamedResponse
    {
        // Filtros recibidos por GET
        $paisId = $request->query->get('pais');
        $minPoblacion = $request->query->get('minPoblacion');
        $maxSuperficie = $request->query->get('maxSuperficie');

        // Buscar entidades asociadas si hay país
        $pais = null;
        if ($paisId) {
            $pais = $paisRepository->find($paisId);
        }

        // Obtener resultados filtrados
        $provincias = $provinciaRepository->filtrar(
            $pais,
            $minPoblacion ? (int) $minPoblacion : null,
            $maxSuperficie ? (float) $maxSuperficie : null
        );

        // Crear hoja Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Provincias');

        // Cabeceras
        $sheet->fromArray(['Provincia', 'País', 'Población', 'Superficie (km²)'], null, 'A1');

        // Cuerpo
        $row = 2;
        foreach ($provincias as $provincia) {
            $sheet->setCellValue("A$row", $provincia->getNombre());
            $sheet->setCellValue("B$row", $provincia->getPais()?->getNombre() ?? 'Sin país');
            $sheet->setCellValue("C$row", $provincia->getPoblacion());
            $sheet->setCellValue("D$row", $provincia->getSuperficie());
            $row++;
        }

        // Generar archivo Excel como respuesta descargable
        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'reporte_provincias.xlsx'
        );

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }


    
}

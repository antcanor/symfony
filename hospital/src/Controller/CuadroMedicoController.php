<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\PaginatorInterface;
use App\Entity\Medico;
use App\Repository\MedicoRepository;
use App\Entity\Especialidad;
use App\Repository\EspecialidadRepository;

#[Route('/cuadro', name: '')]
class CuadroMedicoController extends AbstractController
{
    #[Route('', name: 'lista_especialidades')] 
    public function listarEspecialidades(EspecialidadRepository $em, Request $request): Response
    {   
        $listaEspecialidad = $em->findBy([], ['id' => 'ASC']);
        
        return $this->render('cuadro_medico/index.html.twig', [
            'listaEspecialidad' => $listaEspecialidad,
        ]);
    }

    #[Route('/especialidad/{id}', name: 'medicos_especialidad')]
    public function mostrarMedicosPorEspecialidad(EspecialidadRepository $emEspe, MedicoRepository $emMed, $id): Response
    {
        $especialidad = $emEspe->find($id);
        $medicos = $especialidad->getMedicos();
        

        return $this->render('cuadro_medico/medicos_por_especialidad.html.twig', [
            'especialidad' => $especialidad,
            'medicos' => $medicos,
        ]);
    }
}

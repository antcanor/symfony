<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Medico;
use App\Repository\MedicoRepository;
use App\Entity\Especialidad;
use App\Repository\EspecialidadRepository;
use App\Entity\Servicio;
use App\Repository\ServicioRepository;

#[Route('/servicios', name: '')] 
class ServiciosController extends AbstractController
{
    #[Route('', name: 'lista_servicios')] 
    public function listarServicios(ServicioRepository $em, Request $request): Response
    {   
        $listaServicios = $em->findBy([], ['id' => 'ASC']);
        
        return $this->render('servicios/index.html.twig', [
            'listaServicios' => $listaServicios,
        ]);
    }

    #[Route('/servicio/{id}', name: 'info_servicio')] 
    public function infoservicio(ServicioRepository $em, Request $request,$id): Response
    {   
        $servicio = $em->find($id);
        
        return $this->render('servicios/servicio.html.twig', [
            'servicio' => $servicio,
        ]);
    }
}

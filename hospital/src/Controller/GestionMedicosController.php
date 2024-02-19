<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MedicoFormType;


use App\Entity\Medico;
use App\Repository\MedicoRepository;
use App\Entity\Especialidad;
use App\Repository\EspecialidadRepository;

#[Route('/gestion', name: '')] 
class GestionMedicosController extends AbstractController
{
    #[Route('', name: 'lista_medicos')] 
    public function listarMedicos(MedicoRepository $em, Request $request): Response
    {   
       
        $listaMedicos=$em->findBy([],['id'=>'ASC']);
        
        return $this->render('gestion_medicos/index.html.twig', [
            'listaMedicos' => $listaMedicos,
        ]);
    }
    #[Route('/borrar/{id}', name: 'borrar_medico')]
    public function borrarMedico($id, MedicoRepository $em,  EntityManagerInterface $entityManager){
        $usuario=$em->find($id);
        $entityManager->remove($usuario);
        $entityManager->flush();
        
        return $this->redirectToRoute('lista_medicos');    
    }  

    #[Route('/actualizar/{id}', name: 'actualizar_medico')]
    public function actualizarMedicos($id, MedicoRepository $em, Request $request, EntityManagerInterface $entityManager){
        $medico=$em->find($id);
        
        $form = $this->createForm(MedicoFormType::class, $medico);
        
        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($medico);
            $entityManager->flush();

            return $this->redirectToRoute('lista_medicos');
        }

        return $this->render('gestion_medicos/actualizar.html.twig', [
            'form' => $form->createView(),
        ]);
        
        
    } 

    #[Route('/crear', name: 'crear_medico')]
    public function crearMedico(MedicoRepository $em, Request $request, EntityManagerInterface $entityManager){
        
        $medico=new Medico();
        $form = $this->createForm(MedicoFormType::class, $medico);

        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($medico);
            $entityManager->flush();

            return $this->redirectToRoute('lista_medicos');
        }

        return $this->render('gestion_medicos/crear-medico.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}

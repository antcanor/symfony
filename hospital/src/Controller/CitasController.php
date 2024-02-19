<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CitasFormType;

use App\Entity\Citas;
use App\Repository\CitasRepository;
use App\Entity\Especialidad;
use App\Repository\EspecialidadRepository;
use App\Entity\Medico;
use App\Repository\MedicoRepository;


#[Route('/citas', name: '')]
class CitasController extends AbstractController
{
    #[Route('', name: 'citas')]
    public function pedirCita(MedicoRepository $em, Request $request, EntityManagerInterface $entityManager){
        
        $cita=new Citas();
        $form = $this->createForm(CitasFormType::class, $cita);

        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cita);
            $entityManager->flush();

            return $this->redirectToRoute('cita_ok');
        }

        return $this->render('citas/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/ok', name: 'cita_ok')]
    public function citaOk(){
        

    return $this->render('citas/cita_ok.html.twig');

    }
}

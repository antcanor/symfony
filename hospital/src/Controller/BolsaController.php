<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\BolsaFormType;

use App\Entity\Puesto;
use App\Repository\PuestoRepository;
use App\Entity\Bolsa;
use App\Repository\BolsaRepository;

#[Route('/bolsa', name: '')]
class BolsaController extends AbstractController
{
    #[Route('', name: 'bolsa')]
    public function bolsa(BolsaRepository $em, Request $request, EntityManagerInterface $entityManager){
        
        $bolsa=new Bolsa();
        $form = $this->createForm(BolsaFormType::class, $bolsa);

        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bolsa);
            $entityManager->flush();

            return $this->render('bolsa/bolsa_ok.html.twig',['bolsa'=>$bolsa]);
        }

        return $this->render('bolsa/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}

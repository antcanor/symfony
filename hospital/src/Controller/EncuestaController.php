<?php


namespace App\Controller;
	
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Medico;
use App\Entity\Encuesta;
use App\Entity\Pregunta;
use App\Entity\Respuesta;
use App\Entity\Resultado;
use App\Twig\Extension;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



#[Route("/encuestas", name:"")]
 
class EncuestaController extends  AbstractController
{

    private $entityManager;
    
    public function __construct( EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }
    #[Route("", name:"encuestas")]
     
	public function encuestas()
	{
	
		$encuestas = $this->entityManager->getRepository(Encuesta::class)->findAll( );
       
		return $this->render( 'encuesta/encuestas.html.twig', array( 'encuestas' => $encuestas ));
	}
	
	
    #[Route("/encuesta/{id}", name:"encuesta")]
     
	public function encuesta(Request $request,$id )
	{
		
		
		$builder = $this->createFormBuilder();
		
		$encuesta = $this->entityManager->getRepository(Encuesta::class)->findOneById( $id );
       
				
		foreach( $encuesta->getPreguntas() as $pregunta   )
		{
			$respuestas = array();
			foreach( $pregunta->getRespuestas() as $respuesta   )
			{
				//$respuestas[$respuesta->getId()] =  $respuesta->getRespuesta();
				$respuestas[$respuesta->getRespuesta()] =  $respuesta->getId();
	
			}
			
			$builder->add("pregunta"  . $pregunta->getId(), ChoiceType::class, array( 'choices'  => $respuestas,'label' => $pregunta->getPregunta(), 'expanded' => true));		
		}
	
		$builder->add('Send', SubmitType::class);
		$form= $builder->getForm();
	 	$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();
			foreach( $data as $key => $value )
			{
				
		
				if(  strpos($key, "pregunta" ) !== false )
				{
								
					$respuesta = $this->entityManager->getRepository(Respuesta::class)->findOneById( $value );			
					$resultado = new Resultado();
					
					$resultado->setRespuesta( $respuesta );
					
					$this->entityManager->persist($resultado);
					$this->entityManager->flush();
				}
								
			}
			
			
			return $this->render('encuesta/encuesta_ok.html.twig');
			
		}
	 	else
			return $this->render('encuesta/encuesta_form.html.twig', array('form' => $form->createView(),));
		
	}
		
}

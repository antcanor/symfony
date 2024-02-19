<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

use App\Entity\Menu;
use App\Repository\MenuRepository;
class MenuController extends AbstractController
{
    private $menuRepository;
	
	public function __construct ( MenuRepository $menuRepository )
    {
			$this->menuRepository = $menuRepository;
	}
	#[Route("/menu_menu", name:"menu_menu")]
    public function menu(Security $security): Response
    {	
		$isAuthenticated = $security->isGranted('IS_AUTHENTICATED_FULLY');
		if($isAuthenticated){
			$menuRol = ['noadmin', 'admin'];
			$menus = $this->menuRepository->findBy(['rol' => $menuRol]);
		}else{
			$menuRol = ['noadmin','login'];
			$menus = $this->menuRepository->findBy(['rol' => $menuRol]);
		}
		
		return $this->render('menu/menu.html.twig',array("menus"=>$menus));
    }   

	#[Route("/menu_footer", name:"menu_footer")]
    public function footer(Security $security): Response
    {	
		$isAuthenticated = $security->isGranted('IS_AUTHENTICATED_FULLY');
		if($isAuthenticated){
			$menuRol = ['noadmin', 'admin'];
			$menus = $this->menuRepository->findBy(['rol' => $menuRol]);
		}else{
			$menuRol = ['noadmin','login'];
			$menus = $this->menuRepository->findBy(['rol' => $menuRol]);
		}
		
		return $this->render('menu/footer.html.twig',array("menus"=>$menus));
    }   
	 
}

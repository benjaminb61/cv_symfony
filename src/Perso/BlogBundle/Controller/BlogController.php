<?php

namespace Perso\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use Perso\BlogBundle\Entity\Comment;
use Perso\BlogBundle\Form\CommentType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BlogController extends Controller
{
    public function indexAction($page)
    {
		if ($page < 1) {
		  throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}
		$nbPerPage = 3;
		// Pour récupérer la liste de toutes les annonces : on utilise findAll()
		$listArticles = $this->getDoctrine()
		  ->getManager()
		  ->getRepository('PersoBlogBundle:Article')
		  ->getArticles($page, $nbPerPage)
		;
		
		$nbPages = ceil(count($listArticles) / $nbPerPage);
		
		// Si la page n'existe pas, on retourne une 404
		if ($page > $nbPages) {
		  throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}
		
        return $this->render('PersoBlogBundle:Default:index.html.twig', array(
			'listArticles' => $listArticles,
			'nbPages' => $nbPages,
			'page' => $page
		));
    }
	
	public function categoryAction($name) {
		$listArticles = $this
			->getDoctrine()
			->getManager()
			->getRepository('PersoBlogBundle:Article')
			->getArticleWithCategories(array($name))
		;
	
		return $this->render('PersoBlogBundle:Default:category.html.twig', array(
		  'listArticles' => $listArticles,
		  'nameCategory' => $name
		));
	}
	
	public function menuAction() {
		$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('PersoBlogBundle:Category')
		;
		
		$listCategories = $repository->findAll();
	
		return $this->render('PersoBlogBundle:Default:menu.html.twig', array(
		  'listCategories' => $listCategories
		));
	
	}

    public function adminAction()
    {
		// Pour récupérer la liste de toutes les annonces : on utilise findAll()
		$listArticles = $this->getDoctrine()
		  ->getManager()
		  ->getRepository('PersoBlogBundle:Article')
		  ->getArticles($page = 1, $nbPerPage = 3)
		;
		
        return $this->render('PersoBlogBundle:Admin:index.html.twig', array(
			'listArticles' => $listArticles
		));
    }
}

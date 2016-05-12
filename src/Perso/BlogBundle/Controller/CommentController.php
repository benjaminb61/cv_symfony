<?php

namespace Perso\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use Perso\BlogBundle\Entity\Article;
use Perso\BlogBundle\Form\CommentType;
use Perso\BlogBundle\Form\ArticleType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentController extends Controller
{
    public function adminAction($page)
    {
		if ($page < 1) {
		  throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}
		$nbPerPage = 20;
		// Pour récupérer la liste de toutes les annonces : on utilise findAll()
		$listComments = $this->getDoctrine()
		  ->getManager()
		  ->getRepository('PersoBlogBundle:Comment')
		  ->getComments($page, $nbPerPage, $admin = true)
		;
		
		$nbPages = ceil(count($listComments) / $nbPerPage);
		
		// Si la page n'existe pas, on retourne une 404
		if ($page > $nbPages) {
		  throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}
		
        return $this->render('PersoBlogBundle:Admin:comments.html.twig', array(
			'listComments' => $listComments,
			'nbPages' => $nbPages,
			'page' => $page
		));
    }
	public function editAction($id, Request $request) {
		$em = $this->getDoctrine()->getManager();
		$comment = $em
			->getRepository('PersoBlogBundle:Comment')
			->find($id)
		;
	
		// On crée le FormBuilder grâce au service form factory
		$form = $this->get('form.factory')->create(new CommentType(), $comment);
	
		$form->handleRequest($request);
		if ($form->isValid()) {
		  // On l'enregistre notre objet $advert dans la base de données, par exemple
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($comment);
		  $em->flush();
	
		  $request->getSession()->getFlashBag()->add('msg_success', 'Le commentaire a bien été modifié !');
	
		  return $this->redirect($this->generateUrl('perso_blog_admin_comments'));
		}
	
		return $this->render('PersoBlogBundle:Admin:edit-comment.html.twig',array(
		'form' => $form->createView()));
	}
	public function deleteAction($id, Request $request) {
		
		$em = $this->getDoctrine()->getManager();
		$comment = $em->getRepository('PersoBlogBundle:Comment')->find($id);
		
		if ($comment == null) {
		  throw $this->createNotFoundException("Le commentaire d'id ".$id." n'existe pas.");
		}
	
		$form = $this->createFormBuilder()->getForm();
	
		if ($form->handleRequest($request)->isValid()) {
		  $em->remove($comment);
		  $em->flush();
	
		  $request->getSession()->getFlashBag()->add('msg_success', 'Le commentaire a correctement été supprimé.');
	
		  // Puis on redirige vers l'accueil admin
		  return $this->redirect($this->generateUrl('perso_blog_admin_comments'));
		}
		return $this->render('PersoBlogBundle:Admin:delete-comment.html.twig', array(
      		'comment' => $comment,
      		'form'   => $form->createView()
    	));
	}
}

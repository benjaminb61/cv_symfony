<?php

namespace Perso\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use Perso\BlogBundle\Entity\Article;
use Perso\BlogBundle\Entity\Comment;
use Perso\BlogBundle\Form\CommentAddType;
use Perso\BlogBundle\Form\ArticleType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ArticleController extends Controller
{

	/**
	 * @ParamConverter("article", options={"mapping": {"slug": "slug"}})
	 */
	public function viewAction(Article $article, Request $request) {
		/*$em = $this->getDoctrine()->getManager();
		$article = $em
			->getRepository('PersoBlogBundle:Article')
			->getArticleBySlug($slug)
		;*/
		
		$comment = new Comment();
		$form = $this->get('form.factory')->create(new CommentAddType(), $comment);

		$form->handleRequest($request);
		// On vérifie que les valeurs entrées sont correctes
		// (Nous verrons la validation des objets en détail dans le prochain chapitre)
		$comment -> setArticle($article);
		if ($form->isValid()) {
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($comment);
		  $em->flush();
	
		  $request->getSession()->getFlashBag()->add('msg_success', 'Votre comment a bien été enregistré');
	
		  return $this->redirect($this->generateUrl('perso_blog_article', array('slug' => $article->getSlug())));
		}
	
		return $this->render('PersoBlogBundle:Default:article.html.twig', array(
		  'article' => $article,
		  'form' => $form->createView()
		));
	}

    public function adminAction($page)
    {
		if ($page < 1) {
		  throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}
		$nbPerPage = 3;
		// Pour récupérer la liste de toutes les annonces : on utilise findAll()
		$listArticles = $this->getDoctrine()
		  ->getManager()
		  ->getRepository('PersoBlogBundle:Article')
		  ->getArticles($page, $nbPerPage, $admin = true)
		;
		
		$nbPages = ceil(count($listArticles) / $nbPerPage);
		
		// Si la page n'existe pas, on retourne une 404
		if ($page > $nbPages) {
		  throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}
		
        return $this->render('PersoBlogBundle:Admin:articles.html.twig', array(
			'listArticles' => $listArticles,
			'nbPages' => $nbPages,
			'page' => $page
		));
    }
	
	
	public function addAction(Request $request) {
		$article = new Article();
	
		// On crée le FormBuilder grâce au service form factory
		$form = $this->get('form.factory')->create(new ArticleType(), $article);
	
		$form->handleRequest($request);
		if ($form->isValid()) {
		  // On l'enregistre notre objet $advert dans la base de données, par exemple
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($article);
		  $em->flush();
	
		  $request->getSession()->getFlashBag()->add('msg_success', 'L\'article a bien été enregistré !');
	
		  // On redirige vers la page de visualisation de l'annonce nouvellement créée
		  return $this->redirect($this->generateUrl('perso_blog_article', array('slug' => $article->getSlug())));
		}
	
		return $this->render('PersoBlogBundle:Admin:add-article.html.twig',array(
		'form' => $form->createView()));
	}
	
	public function editAction(Article $article, Request $request) {
		/*$em = $this->getDoctrine()->getManager();
		$article = $em
			->getRepository('PersoBlogBundle:Article')
			->find($id)
		;*/
	
		// On crée le FormBuilder grâce au service form factory
		$form = $this->get('form.factory')->create(new ArticleType(), $article);
	
		$form->handleRequest($request);
		if ($form->isValid()) {
		  // On l'enregistre notre objet $advert dans la base de données, par exemple
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($article);
		  $em->flush();
	
		  $request->getSession()->getFlashBag()->add('msg_success', 'L\'article a bien été modifié !');
	
		  // On redirige vers la page de visualisation de l'annonce nouvellement créée
		  return $this->redirect($this->generateUrl('perso_blog_article_edit', array('id' => $article->getId())));
		}
	
		return $this->render('PersoBlogBundle:Admin:edit-article.html.twig',array(
		'form' => $form->createView()));
	}
	public function deleteAction(Article $article, Request $request) {
		
		/*$em = $this->getDoctrine()->getManager();
		$article = $em->getRepository('PersoBlogBundle:Article')->find($id);
		
		if ($article == null) {
		  throw $this->createNotFoundException("L'article d'id ".$id." n'existe pas.");
		}*/
	
		$form = $this->createFormBuilder()->getForm();
	
		if ($form->handleRequest($request)->isValid()) {
		  $em->remove($article);
		  $em->flush();
	
		  $request->getSession()->getFlashBag()->add('msg_success', 'L\'article a correctement été supprimé.');
	
		  // Puis on redirige vers l'accueil admin
		  return $this->redirect($this->generateUrl('perso_blog_admin_articles'));
		}
		return $this->render('PersoBlogBundle:Admin:delete-article.html.twig', array(
      		'article' => $article,
      		'form'   => $form->createView()
    	));
	}
}

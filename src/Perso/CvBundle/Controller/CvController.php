<?php

namespace Perso\CvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !

class CvController extends Controller
{
    public function indexAction(Request $request)
    {
		if ($request->isMethod('POST')) {
			$mailer = $this->container->get('perso_cv.contact');
			
			$message = $_POST['message'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			//$mailer -> checkExist();
			$mailer -> send($this -> container -> getParameter('perso_cv.contact.subject'),$email,$message);
			
  		// Un formulaire a été envoyé, on peut le traiter ici
    		$session = $request->getSession();
   			$session->getFlashBag()->add('msg_success', '<strong>Envoyé !</strong> Votre message m\'a bien été envoyé, je vous en remercie ;-)');
		}
		
        return $this->render('PersoCvBundle:Cv:index.html.twig');
    }
    public function pageAction($name)
    {
        return $this->render('PersoCvBundle:Cv:page1.html.twig');
    }
}

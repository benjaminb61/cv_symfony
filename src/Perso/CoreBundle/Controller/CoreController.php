<?php

namespace Perso\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !

class CoreController extends Controller
{
    public function indexAction(Request $request)
    {
		if ($request->isMethod('POST')) {
			$mailer = $this->container->get('perso_core.contact');
			
			$message = $_POST['message'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			//$mailer -> checkExist();
			$mailer -> send($this -> container -> getParameter('perso_core.contact.subject'),$email,$message);
			
  		// Un formulaire a été envoyé, on peut le traiter ici
    		$session = $request->getSession();
   			$session->getFlashBag()->add('msg_success', '<strong>Envoyé !</strong> Votre message m\'a bien été envoyé, je vous en remercie ;-)');
		}
		
        return $this->render('PersoCoreBundle::index.html.twig');
    }
    public function pageAction($name)
    {
        return $this->render('PersoCoreBundle::page1.html.twig');
    }
	/*
	* Permet d'enregistré la source des visiteurs si URL trackée
	*/
	
	public function trackAction($tag)
	{
		$tracking = $this->container->get('perso_core.tracking');
		$tracking -> addTrack($tag);
		
		return $this->redirect($this->generateUrl('perso_core_homepage'));
	}
}

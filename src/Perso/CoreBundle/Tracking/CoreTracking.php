<?php

// src/Perso/CoreBundle/Tracking/CoreTracking.php


namespace Perso\CoreBundle\Tracking;

use Doctrine\ORM\EntityManager;
use Perso\CoreBundle\Entity\Event;

class CoreTracking {
	private $em;
	private $mailer;
	private $to;
	private $name;
	private $date;

	public function __construct(\Swift_Mailer $swiftmailer, EntityManager $entityManager,$to) {
		$this->em = $entityManager;
		$this->mailer = $swiftmailer;
		$this->date = new \Datetime;
		$this->to = $to;
	}
  /**

   * Add tracking event in the database

   *

   * @param string $tag

   * @return bool

   */
	public function addTrack($tag) {
		$event = new Event();
		$event -> setName($tag);
		$event -> setType("Tracking");
	
		$this -> em -> persist($event);
		$this -> em -> flush();
		
		$this -> sendNotification($event);
	}
	
	public function sendNotification(Event $event) {
		$subject = "Nouvelle évènement \"".$event -> getType()."\"";
		$notification = "Bonjour,<br /><br />Un nouvel évènement vient de se produire sur le site :<br /><br /><strong>Date de l'évènement :</strong> ".$event -> getDate() -> format('d-m-Y H:i')."<br /><strong>Type d'évènement :</strong> ".$event -> getType()."<br /><strong>Valeur de l'évènement :</strong> ".$event -> getName()."";
		$name = "Benjamin Barbin";

		$message = \Swift_Message::newInstance()
			->setSubject(''.$subject.'')
			->setFrom(''.$this->to.'')
			->setTo(''.$this->to.'')
			->setBody($notification)
			->setContentType('text/html')
		;
		$this->mailer->send($message);
	}
}
<?php

// src/Perso/CvBundle/Contact/CvContact.php


namespace Perso\CvBundle\Contact;


class CvContact {
	private $mailer;
	private $locale;
	private $to;

	public function __construct(\Swift_Mailer $mailer, $locale, $to) {
		$this->mailer    = $mailer;
		$this->locale    = $locale;
		$this->to    = $to;
	}
  /**

   * Vérifie si le texte est un spam ou non

   *

   * @param string $text

   * @return bool

   */
  public function send($subject,$from,$contenu) {
    $message = \Swift_Message::newInstance()
        ->setSubject(''.$subject.'')
        ->setFrom(''.$from.'')
        ->setTo(''.$this->to.'')
        ->setBody($contenu)
    ;
    $this->get('mailer')->send($message);
  }
}
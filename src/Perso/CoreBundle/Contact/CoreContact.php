<?php

// src/Perso/CoreBundle/Contact/CoreContact.php


namespace Perso\CoreBundle\Contact;


class CoreContact {
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
    $this->mailer->send($message);
  }
}
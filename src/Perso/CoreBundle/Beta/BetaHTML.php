<?php
// src/Perso/CoreBundle/Beta/BetaHTML.php

namespace Perso\CoreBundle\Beta;

use Symfony\Component\HttpFoundation\Response;

class BetaHTML
{
  // Méthode pour ajouter le « bêta » à une réponse
  public function displayBeta(Response $response, $remainingDays)
  {
    $content = $response->getContent();

    // Code à rajouter
    $html = '<span style="color: red; font-size: 0.5em;"> - Beta J-'.(int) $remainingDays.' !</span>';

    // Insertion du code dans la page, dans le premier <h1>
    $content = preg_replace(
      '#<h2>(.*?)</h2>#iU',
      '<h2>$1'.$html.'</h2>',
      $content,
      1
    );

    // Modification du contenu dans la réponse
    $response->setContent($content);

    return $response;
  }
}
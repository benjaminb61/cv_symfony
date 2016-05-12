<?php
// src/Perso/BlogBundle/DataFixtures/ORM/LoadArticle.php

namespace Perso\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Perso\BlogBundle\Entity\Article;

class LoadArticle implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $articles[] = array(
      'title' => 'Et oui c\'est nouveau !',
	  'author' => 'Benjamin',
	  'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    );
	
    $articles[] = array(
      'title' => 'Mon titre 2',
	  'author' => 'Gerard',
	  'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    );
	
    $articles[] = array(
      'title' => 'Mon titre 3',
	  'author' => 'Betrand',
	  'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    );

    foreach ($articles as $detail) {
      // On crée la catégorie
      $article = new Article();
      $article->setTitle($detail['title']);
	  $article->setContent($detail['content']);
	  $article->setAuthor($detail['author']);
      // On la persiste
      $manager->persist($article);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}
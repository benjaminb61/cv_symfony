<?php

namespace Perso\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Comment
 *
 * @ORM\Table(name="blog_comment")
 * @ORM\Entity(repositoryClass="Perso\BlogBundle\Entity\CommentRepository")
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
	 * @Assert\Length(min=3)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
	 * @Assert\NotBlank()
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
	 * @Assert\DateTime()
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

	/**
	* @ORM\ManyToOne(targetEntity="Perso\BlogBundle\Entity\Article")
	* @ORM\JoinColumn(nullable=false)
	*/
	
	private $article;

    /**
     * Get id
     *
     * @return integer 
     */
	 
	 
	public function __construct()
	{
		$this->date = new \Datetime();
		$this->published = true;
	}
	
	
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Comment
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }
	
	public function viewStatut() {
		if ($this->published)
			return "<span style=\"font-weight:bold; color:green;\">Publié</span>";
		return "<span style=\"font-weight:bold; color:orange;\">Non publié</span>";
	}

    /**
     * Set article
     *
     * @param \Perso\BlogBundle\Entity\Article $article
     * @return Comment
     */
    public function setArticle(\Perso\BlogBundle\Entity\Article $article)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return \Perso\BlogBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }
	
	/*
	* @Assert\Callback(methods={"isContentValid"})
	*/
	public function isContentValid(ExecutionContextInterface $context)
	{
		$forbiddenWords = array('connard', 'blaireau');
	
		// On vérifie que le contenu ne contient pas l'un des mots
		if (preg_match('#'.implode('|', $forbiddenWords).'#', $this->getComment())) {
		  // La règle est violée, on définit l'erreur
		  $context
			->buildViolation('Contenu invalide car il contient un mot interdit.') // message
			->atPath('comment')                                                   // attribut de l'objet qui est violé
			->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
		  ;
		}
	}
}
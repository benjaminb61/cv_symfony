<?php

namespace Perso\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="blog_article")
 * @ORM\Entity(repositoryClass="Perso\BlogBundle\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=255)
	 * @Assert\Length(min=6)
     */
    private $title;

    /**
	* @Gedmo\Slug(fields={"title"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;
	
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
	 * @Assert\Length(min=100)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
	 * @Assert\Length(min=3)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreate", type="datetime")
	 * @Assert\DateTime()
     */
    private $datecreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateupdate", type="datetime", nullable=true)
     */
    private $dateupdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="statut", type="boolean")
     */
    private $statut = true;
	
	/**
	* @ORM\ManyToMany(targetEntity="Perso\BlogBundle\Entity\Category", cascade={"persist"})
	*/
	private $categories;
	
	/**
	* @ORM\OneToMany(targetEntity="Perso\BlogBundle\Entity\Comment", mappedBy="article", cascade={"persist", "remove"})
	* @Assert\Valid()
	*/
	private $comments;


	public function __construct()
	{
		$this->datecreate = new \Datetime();
		$this->categories = new ArrayCollection();
		$this->comments = new ArrayCollection();
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Article
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
     * Set datecreate
     *
     * @param \DateTime $datecreate
     * @return Article
     */
    public function setDatecreate($datecreate)
    {
        $this->datecreate = $datecreate;
    
        return $this;
    }

    /**
     * Get datecreate
     *
     * @return \DateTime 
     */
    public function getDatecreate()
    {
        return $this->datecreate;
    }

    /**
     * Set dateupdate
     *
     * @param \DateTime $dateupdate
     * @return Article
     */
    public function setDateupdate($dateupdate)
    {
        $this->dateupdate = $dateupdate;
    
        return $this;
    }

    /**
     * Get dateupdate
     *
     * @return \DateTime 
     */
    public function getDateupdate()
    {
        return $this->dateupdate;
    }

    /**
     * Set statut
     *
     * @param boolean $statut
     * @return Article
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return boolean 
     */
    public function getStatut()
    {
        return $this->statut;
    }
	
	public function viewStatut() {
		if ($this->statut)
			return "<span style=\"font-weight:bold; color:green;\">Publié</span>";
		return "<span style=\"font-weight:bold; color:red;\">Brouillon</span>";
	}

    /**
     * Add categories
     *
     * @param \Perso\BlogBundle\Entity\Category $categories
     * @return Article
     */
    public function addCategorie(\Perso\BlogBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Perso\BlogBundle\Entity\Category $categories
     */
    public function removeCategorie(\Perso\BlogBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
	
	/**
	 * @ORM\PreUpdate
	 */
	public function updateDate()
	{
		$this->setDateupdate(new \Datetime());
	}

    /**
     * Set slug
     *
     * @param string $slug
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add comments
     *
     * @param \Perso\BlogBundle\Entity\Comment $comments
     * @return Article
     */
    public function addComment(\Perso\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Perso\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Perso\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
	
    public function getNbComments()
    {
        return sizeof($this->comments);
    }
}
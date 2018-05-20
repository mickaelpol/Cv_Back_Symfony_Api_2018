<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categorie
 *
 * @ORM\Table(name="cat_categorie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorieRepository")
 * 
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="cat_oid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * One Categorie has Many Contents.
     * @ORM\OneToMany(targetEntity="Content", mappedBy="categorie", cascade={"persist", "remove"})
     */
    private $contents;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
    }



    public function __toString()
    {
        return $this->title;
    }
    

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Categorie
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
     * Add content
     *
     * @param \AppBundle\Entity\Content $content
     *
     * @return Categorie
     */
    public function addContent(\AppBundle\Entity\Content $content)
    {
        $this->contents[] = $content;

        return $this;
    }

    /**
     * Remove content
     *
     * @param \AppBundle\Entity\Content $content
     */
    public function removeContent(\AppBundle\Entity\Content $content)
    {
        $this->contents->removeElement($content);
    }

    /**
     * Get contents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContents()
    {
        return $this->contents;
    }
}

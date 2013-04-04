<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chapitre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\ChapitreRepository")
 */
class Chapitre
{
    /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Niveau", inversedBy="chapitres")
    * @ORM\JoinColumn(nullable=false)
    */
    private $niveau;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\ExerciceCorrige", mappedBy="chapitre")
    */
    private $excerciceCorriges;
    
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
     * @ORM\Column(name="libelle", type="text")
     */
    private $libelle;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * Set libelle
     *
     * @param string $libelle
     * @return Chapitre
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Chapitre
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
     * Constructor
     */
    public function __construct()
    {
        $this->excerciceCorriges = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \Datetime();
    }
    
    
     /**
     * toString
     */
    public function __toString()
    {
        return $this->libelle;
    }
    
    /**
     * Set niveau
     *
     * @param \Msp\FrontendBundle\Entity\Niveau $niveau
     * @return Chapitre
     */
    public function setNiveau(\Msp\FrontendBundle\Entity\Niveau $niveau)
    {
        $this->niveau = $niveau;
    
        return $this;
    }

    /**
     * Get niveau
     *
     * @return \Msp\FrontendBundle\Entity\Niveau 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Add excerciceCorriges
     *
     * @param \Msp\FrontendBundle\Entity\ExerciceCorrige $excerciceCorriges
     * @return Chapitre
     */
    public function addExcerciceCorrige(\Msp\FrontendBundle\Entity\ExerciceCorrige $excerciceCorriges)
    {
        $this->excerciceCorriges[] = $excerciceCorriges;
    
        return $this;
    }

    /**
     * Remove excerciceCorriges
     *
     * @param \Msp\FrontendBundle\Entity\ExerciceCorrige $excerciceCorriges
     */
    public function removeExcerciceCorrige(\Msp\FrontendBundle\Entity\ExerciceCorrige $excerciceCorriges)
    {
        $this->excerciceCorriges->removeElement($excerciceCorriges);
    }

    /**
     * Get excerciceCorriges
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExcerciceCorriges()
    {
        return $this->excerciceCorriges;
    }
}
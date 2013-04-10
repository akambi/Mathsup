<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

//  Pour utiliser ArrrayCollection de doctrine
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\QuestionRepository")
 */
class Question
{
    /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Qcm", inversedBy="questions")
    * @ORM\JoinColumn(nullable=false)
    */
    private $qcm;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Reponse", mappedBy="question")
    */
    private $reponses;
    
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
     * @var string
     *
     * @ORM\Column(name="illustration", type="text")
     */
    private $illustration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duree", type="time")
     */
    private $duree;

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
     * @return Question
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
     * Set illustration
     *
     * @param string $illustration
     * @return Question
     */
    public function setIllustration($illustration)
    {
        $this->illustration = $illustration;
    
        return $this;
    }

    /**
     * Get illustration
     *
     * @return string 
     */
    public function getIllustration()
    {
        return $this->illustration;
    }

    /**
     * Set duree
     *
     * @param \DateTime $duree
     * @return Question
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    
        return $this;
    }

    /**
     * Get duree
     *
     * @return \DateTime 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Question
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
        $this->reponses = new ArrayCollection();
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
     * Set qcm
     *
     * @param \Msp\FrontendBundle\Entity\Qcm $qcm
     * @return Question
     */
    public function setQcm(\Msp\FrontendBundle\Entity\Qcm $qcm)
    {
        $this->qcm = $qcm;
    
        return $this;
    }

    /**
     * Get qcm
     *
     * @return \Msp\FrontendBundle\Entity\Qcm 
     */
    public function getQcm()
    {
        return $this->qcm;
    }

    /**
     * Add reponses
     *
     * @param \Msp\FrontendBundle\Entity\Reponse $reponses
     * @return Question
     */
    public function addReponse(\Msp\FrontendBundle\Entity\Reponse $reponses)
    {
        $this->reponses[] = $reponses;
    
        return $this;
    }

    /**
     * Remove reponses
     *
     * @param \Msp\FrontendBundle\Entity\Reponse $reponses
     */
    public function removeReponse(\Msp\FrontendBundle\Entity\Reponse $reponses)
    {
        $this->reponses->removeElement($reponses);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReponses()
    {
        return $this->reponses;
    }
}
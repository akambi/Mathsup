<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Qcm
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\QcmRepository")
 */
class Qcm
{
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserQcm", mappedBy="qcm")
    */
    private $userQcms;
    
    /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Niveau", inversedBy="qcms")
    * @ORM\JoinColumn(nullable=false)
    */
    private $niveau;
    
    /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Difficulter", inversedBy="qcms")
    * @ORM\JoinColumn(nullable=false)
    */
    private $difficulter;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Question", mappedBy="qcm")
    */
    private $questions;
    
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
     * @return Qcm
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
     * Set duree
     *
     * @param \DateTime $duree
     * @return Qcm
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
     * @return Qcm
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
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \Datetime();
    }
    
    /**
     * Set niveau
     *
     * @param \Msp\FrontendBundle\Entity\Niveau $niveau
     * @return Qcm
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
     * Set difficulter
     *
     * @param \Msp\FrontendBundle\Entity\Difficulter $difficulter
     * @return Qcm
     */
    public function setDifficulter(\Msp\FrontendBundle\Entity\Difficulter $difficulter)
    {
        $this->difficulter = $difficulter;
    
        return $this;
    }

    /**
     * Get difficulter
     *
     * @return \Msp\FrontendBundle\Entity\Difficulter 
     */
    public function getDifficulter()
    {
        return $this->difficulter;
    }

    /**
     * Add questions
     *
     * @param \Msp\FrontendBundle\Entity\Question $questions
     * @return Qcm
     */
    public function addQuestion(\Msp\FrontendBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;
    
        return $this;
    }

    /**
     * Remove questions
     *
     * @param \Msp\FrontendBundle\Entity\Question $questions
     */
    public function removeQuestion(\Msp\FrontendBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Add userQcms
     *
     * @param \Msp\FrontendBundle\Entity\UserQcm $userQcms
     * @return Qcm
     */
    public function addUserQcm(\Msp\FrontendBundle\Entity\UserQcm $userQcms)
    {
        $this->userQcms[] = $userQcms;
    
        return $this;
    }

    /**
     * Remove userQcms
     *
     * @param \Msp\FrontendBundle\Entity\UserQcm $userQcms
     */
    public function removeUserQcm(\Msp\FrontendBundle\Entity\UserQcm $userQcms)
    {
        $this->userQcms->removeElement($userQcms);
    }

    /**
     * Get userQcms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserQcms()
    {
        return $this->userQcms;
    }
}
<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\ReponseRepository")
 */
class Reponse
{
    /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Question", inversedBy="reponses")
    * @ORM\JoinColumn(nullable=false)
    */
    private $question;
    
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
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;  

    public function __construct()
    {
               
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->libelle;
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
     * Set libelle
     *
     * @param string $libelle
     * @return Reponse
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
     * Set etat
     *
     * @param boolean $etat
     * @return Reponse
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    
        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set question
     *
     * @param \Msp\FrontendBundle\Entity\Question $question
     * @return Reponse
     */
    public function setQuestion(\Msp\FrontendBundle\Entity\Question $question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Msp\FrontendBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
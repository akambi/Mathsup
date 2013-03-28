<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\QuestionRepository")
 */
class Question
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
}

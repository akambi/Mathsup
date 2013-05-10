<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\CoursRepository")
 */
class Cours
{
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserHourlyRate", mappedBy="cours")
    */
    private $userHourlyRates;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserAvailability", mappedBy="cours")
    */
    private $userAvailabilities;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Ticket", mappedBy="cours")
    */
    private $tickets;
    
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
     * @ORM\Column(name="libelle", type="string", length=45)
     */
    private $libelle;


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
     * @return Cours
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
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
     /**
     * toString
     */
    public function __toString()
    {
        return $this->libelle;
    }
    
    
    /**
     * Add tickets
     *
     * @param \Msp\FrontendBundle\Entity\Ticket $tickets
     * @return Cours
     */
    public function addTicket(\Msp\FrontendBundle\Entity\Ticket $tickets)
    {
        $this->tickets[] = $tickets;
    
        return $this;
    }

    /**
     * Remove tickets
     *
     * @param \Msp\FrontendBundle\Entity\Ticket $tickets
     */
    public function removeTicket(\Msp\FrontendBundle\Entity\Ticket $tickets)
    {
        $this->tickets->removeElement($tickets);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Add userHourlyRates
     *
     * @param \Msp\FrontendBundle\Entity\UserHourlyRate $userHourlyRates
     * @return Cours
     */
    public function addUserHourlyRate(\Msp\FrontendBundle\Entity\UserHourlyRate $userHourlyRates)
    {
        $this->userHourlyRates[] = $userHourlyRates;
    
        return $this;
    }

    /**
     * Remove userHourlyRates
     *
     * @param \Msp\FrontendBundle\Entity\UserHourlyRate $userHourlyRates
     */
    public function removeUserHourlyRate(\Msp\FrontendBundle\Entity\UserHourlyRate $userHourlyRates)
    {
        $this->userHourlyRates->removeElement($userHourlyRates);
    }

    /**
     * Get userHourlyRates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserHourlyRates()
    {
        return $this->userHourlyRates;
    }

    /**
     * Add userAvailabilities
     *
     * @param \Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities
     * @return Cours
     */
    public function addUserAvailabilitie(\Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities)
    {
        $this->userAvailabilities[] = $userAvailabilities;
    
        return $this;
    }

    /**
     * Remove userAvailabilities
     *
     * @param \Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities
     */
    public function removeUserAvailabilitie(\Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities)
    {
        $this->userAvailabilities->removeElement($userAvailabilities);
    }

    /**
     * Get userAvailabilities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserAvailabilities()
    {
        return $this->userAvailabilities;
    }
}
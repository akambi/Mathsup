<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceLog
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\ConferenceLogRepository")
 */
class ConferenceLog
{
    /**
    * @ORM\OneToOne(targetEntity="Msp\FrontendBundle\Entity\Conference")
    * @ORM\JoinColumn(nullable=false)
    */
    private $conference;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="recorded", type="boolean")
     */
    private $recorded;

    /**
     * @var integer
     *
     * @ORM\Column(name="timetamp", type="integer")
     */
    private $timetamp;

    /**
     * @var string
     *
     * @ORM\Column(name="event", type="text")
     */
    private $event;


    /**
     * Constructor
     */
    public function __construct()
    {        
        $this->timetamp = time();
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
     * Set recorded
     *
     * @param boolean $recorded
     * @return ConferenceLog
     */
    public function setRecorded($recorded)
    {
        $this->recorded = $recorded;
    
        return $this;
    }

    /**
     * Get recorded
     *
     * @return boolean 
     */
    public function getRecorded()
    {
        return $this->recorded;
    }

    /**
     * Set timetamp
     *
     * @param integer $timetamp
     * @return ConferenceLog
     */
    public function setTimetamp($timetamp)
    {
        $this->timetamp = $timetamp;
    
        return $this;
    }

    /**
     * Get timetamp
     *
     * @return integer 
     */
    public function getTimetamp()
    {
        return $this->timetamp;
    }

    /**
     * Set event
     *
     * @param string $event
     * @return ConferenceLog
     */
    public function setEvent($event)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return string 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set conference
     *
     * @param \Msp\FrontendBundle\Entity\Conference $conference
     * @return ConferenceLog
     */
    public function setConference(\Msp\FrontendBundle\Entity\Conference $conference = null)
    {
        $this->conference = $conference;
    
        return $this;
    }

    /**
     * Get conference
     *
     * @return \Msp\FrontendBundle\Entity\Conference 
     */
    public function getConference()
    {
        return $this->conference;
    }
}
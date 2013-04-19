<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

//  Pour utiliser ArrrayCollection de doctrine
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Conference
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\ConferenceRepository")
 */
class Conference
{
     /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserGoConference", mappedBy="conference")
    */
    private $userGoConferences;
    
    /**
    * @ORM\ManyToOne(targetEntity="Msp\UserBundle\Entity\User", inversedBy="conferences")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;
    
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
     * @ORM\Column(name="meetingID", type="text")
     */
    private $meetingID;

    /**
     * @var string
     *
     * @ORM\Column(name="meetingName", type="string", length=255, unique=true)
     */
    private $meetingName;

    /**
     * @var integer
     *
     * @ORM\Column(name="meetingVersion", type="integer")
     */
    private $meetingVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="moderatorPW", type="text")
     */
    private $moderatorPW;

    /**
     * @var string
     *
     * @ORM\Column(name="attendeePW", type="text")
     */
    private $attendeePW;

    /**
     * @var boolean
     *
     * @ORM\Column(name="WaitForModerator", type="boolean")
     */
    private $waitForModerator;

    /**
     * @var boolean
     *
     * @ORM\Column(name="recorded", type="boolean")
     */
    private $recorded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="meetingDate", type="datetime")
     */
    private $meetingDate;


    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userGoConferences = new ArrayCollection();
        $this->meetingDate = new \Datetime();
        $this->recorded = false;
        $this->waitForModerator = false;
        $this->meetingVersion = time();
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
     * Set meetingID
     *
     * @param string $meetingID
     * @return Conference
     */
    public function setMeetingID($meetingID)
    {
        $this->meetingID = $meetingID;
    
        return $this;
    }

    /**
     * Get meetingID
     *
     * @return string 
     */
    public function getMeetingID()
    {
        return $this->meetingID;
    }

    /**
     * Set meetingName
     *
     * @param string $meetingName
     * @return Conference
     */
    public function setMeetingName($meetingName)
    {
        $this->meetingName = $meetingName;
    
        return $this;
    }

    /**
     * Get meetingName
     *
     * @return string 
     */
    public function getMeetingName()
    {
        return $this->meetingName;
    }

    /**
     * Set meetingVersion
     *
     * @param integer $meetingVersion
     * @return Conference
     */
    public function setMeetingVersion($meetingVersion)
    {
        $this->meetingVersion = $meetingVersion;
    
        return $this;
    }

    /**
     * Get meetingVersion
     *
     * @return integer 
     */
    public function getMeetingVersion()
    {
        return $this->meetingVersion;
    }

    /**
     * Set moderatorPW
     *
     * @param string $moderatorPW
     * @return Conference
     */
    public function setModeratorPW($moderatorPW)
    {
        $this->moderatorPW = $moderatorPW;
    
        return $this;
    }

    /**
     * Get moderatorPW
     *
     * @return string 
     */
    public function getModeratorPW()
    {
        return $this->moderatorPW;
    }

    /**
     * Set attendeePW
     *
     * @param string $attendeePW
     * @return Conference
     */
    public function setAttendeePW($attendeePW)
    {
        $this->attendeePW = $attendeePW;
    
        return $this;
    }

    /**
     * Get attendeePW
     *
     * @return string 
     */
    public function getAttendeePW()
    {
        return $this->attendeePW;
    }

    /**
     * Set waitForModerator
     *
     * @param boolean $waitForModerator
     * @return Conference
     */
    public function setWaitForModerator($waitForModerator)
    {
        $this->waitForModerator = $waitForModerator;
    
        return $this;
    }

    /**
     * Get waitForModerator
     *
     * @return boolean 
     */
    public function getWaitForModerator()
    {
        return $this->waitForModerator;
    }

    /**
     * Set recorded
     *
     * @param boolean $recorded
     * @return Conference
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
     * Set meetingDate
     *
     * @param \DateTime $meetingDate
     * @return Conference
     */
    public function setMeetingDate($meetingDate)
    {
        $this->meetingDate = $meetingDate;
    
        return $this;
    }

    /**
     * Get meetingDate
     *
     * @return \DateTime 
     */
    public function getMeetingDate()
    {
        return $this->meetingDate;
    }

    /**
     * Add userGoConferences
     *
     * @param \Msp\FrontendBundle\Entity\UserGoConference $userGoConferences
     * @return Conference
     */
    public function addUserGoConference(\Msp\FrontendBundle\Entity\UserGoConference $userGoConferences)
    {
        $this->userGoConferences[] = $userGoConferences;
    
        return $this;
    }

    /**
     * Remove userGoConferences
     *
     * @param \Msp\FrontendBundle\Entity\UserGoConference $userGoConferences
     */
    public function removeUserGoConference(\Msp\FrontendBundle\Entity\UserGoConference $userGoConferences)
    {
        $this->userGoConferences->removeElement($userGoConferences);
    }

    /**
     * Get userGoConferences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserGoConferences()
    {
        return $this->userGoConferences;
    }

    /**
     * Set user
     *
     * @param \Msp\UserBundle\Entity\User $user
     * @return Conference
     */
    public function setUser(\Msp\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Msp\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
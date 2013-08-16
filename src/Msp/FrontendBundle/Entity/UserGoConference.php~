<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserGoConference 
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserGoConference
{
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\UserBundle\Entity\User", inversedBy="userGoConferences")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;
    
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Conference", inversedBy="userGoConferences")
    * @ORM\JoinColumn(nullable=false)
    */
    private $conference;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \Datetime();
    }
    
    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserGoConference
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
     * Set user
     *
     * @param \Msp\UserBundle\Entity\User $user
     * @return UserGoConference
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

    /**
     * Set conference
     *
     * @param \Msp\FrontendBundle\Entity\Conference $conference
     * @return UserGoConference
     */
    public function setConference(\Msp\FrontendBundle\Entity\Conference $conference)
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

    /**
     * Set message
     *
     * @param string $message
     * @return UserGoConference
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }
}

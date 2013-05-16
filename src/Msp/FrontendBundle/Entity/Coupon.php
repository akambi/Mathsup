<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coupon
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\CouponRepository")
 */
class Coupon
{
    /**
    * @ORM\ManyToOne(targetEntity="Msp\UserBundle\Entity\User", inversedBy="coupons")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;
    
    /**
    * @ORM\OneToOne(targetEntity="Msp\FrontendBundle\Entity\Ticket", mappedBy="coupon")
    */
    private $ticket;
    
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
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * Constructor
     */
    public function __construct()
    {        
        $this->date = new \Datetime();
        $this->token = sha1( time()."Mathsup_Coupon");
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
     * Set token
     *
     * @param string $token
     * @return Coupon
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Coupon
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
     * @return Coupon
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
     * Set ticket
     *
     * @param \Msp\FrontendBundle\Entity\Ticket $ticket
     * @return Coupon
     */
    public function setTicket(\Msp\FrontendBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;
    
        return $this;
    }

    /**
     * Get ticket
     *
     * @return \Msp\FrontendBundle\Entity\Ticket 
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
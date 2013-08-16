<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\TicketRepository")
 */
class Ticket
{
    /**
    * @ORM\ManyToOne(targetEntity="Msp\UserBundle\Entity\User", inversedBy="tickets")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;  
    
    /**
    * @ORM\OneToOne(targetEntity="Msp\FrontendBundle\Entity\Coupon", inversedBy="ticket")
    */
    private $coupon;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \Datetime();        
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
     * Set date
     *
     * @param \DateTime $date
     * @return Ticket
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
     * Set coupon
     *
     * @param \Msp\FrontendBundle\Entity\Coupon $coupon
     * @return Ticket
     */
    public function setCoupon(\Msp\FrontendBundle\Entity\Coupon $coupon = null)
    {
        $this->coupon = $coupon;
    
        return $this;
    }

    /**
     * Get coupon
     *
     * @return \Msp\FrontendBundle\Entity\Coupon 
     */
    public function getCoupon()
    {
        return $this->coupon;
    }
    

    /**
     * Set user
     *
     * @param \Msp\UserBundle\Entity\User $user
     * @return Ticket
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

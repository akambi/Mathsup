<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAvailability 
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserAvailability
{
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\UserBundle\Entity\User", inversedBy="userAvailabilities")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;
    
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Cours", inversedBy="userAvailabilities")
    * @ORM\JoinColumn(nullable=false)
    */
    private $cours;
    
    /**
     * @var \DateTime
     *
     * @ORM\Id
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="disponible", type="boolean")
     */
    private $disponible;

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserAvailability
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
     * Set disponible
     *
     * @param boolean $disponible
     * @return UserAvailability
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;
    
        return $this;
    }

    /**
     * Get disponible
     *
     * @return boolean 
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set user
     *
     * @param \Msp\UserBundle\Entity\User $user
     * @return UserAvailability
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
     * Set cours
     *
     * @param \Msp\FrontendBundle\Entity\Cours $cours
     * @return UserAvailability
     */
    public function setCours(\Msp\FrontendBundle\Entity\Cours $cours)
    {
        $this->cours = $cours;
    
        return $this;
    }

    /**
     * Get cours
     *
     * @return \Msp\FrontendBundle\Entity\Cours 
     */
    public function getCours()
    {
        return $this->cours;
    }
}
<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserQcm
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserQcm
{
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\UserBundle\Entity\User", inversedBy="userQcms")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;
    
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Qcm", inversedBy="userQcms")
    * @ORM\JoinColumn(nullable=false)
    */
    private $qcm;
    
    /**
     * @var \DateTime
     *
     * @ORM\Id
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserQcm
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
     * Set note
     *
     * @param integer $note
     * @return UserQcm
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set user
     *
     * @param \Msp\UserBundle\Entity\User $user
     * @return UserQcm
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
     * Set qcm
     *
     * @param \Msp\FrontendBundle\Entity\Qcm $qcm
     * @return UserQcm
     */
    public function setQcm(\Msp\FrontendBundle\Entity\Qcm $qcm)
    {
        $this->qcm = $qcm;
    
        return $this;
    }

    /**
     * Get qcm
     *
     * @return \Msp\FrontendBundle\Entity\Qcm 
     */
    public function getQcm()
    {
        return $this->qcm;
    }
}
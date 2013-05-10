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
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        
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
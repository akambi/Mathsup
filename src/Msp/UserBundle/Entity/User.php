<?php

namespace Msp\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table()
*/
class User extends BaseUser
{
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserAvailability", mappedBy="user")
    */
    private $userAvailabilities;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserQcm", mappedBy="user")
    */
    private $userQcms;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserHourlyRate", mappedBy="user")
    */
    private $userHourlyRates;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Coupon", mappedBy="user")
    */
    private $coupons;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Ticket", mappedBy="user")
    */
    private $tickets;
    
    /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Classe", inversedBy="users")
    * @ORM\JoinColumn(nullable=true)
    */
    private $classe;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=true)
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=45, nullable=true)
     */
    protected $prenom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="departement", type="string", length=45, nullable=true)
     */
    protected $departement;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set departement
     *
     * @param string $departement
     * @return User
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
    
        return $this;
    }

    /**
     * Get departement
     *
     * @return string 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Add userAvailabilities
     *
     * @param \Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities
     * @return User
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

    /**
     * Add userQcms
     *
     * @param \Msp\FrontendBundle\Entity\UserQcm $userQcms
     * @return User
     */
    public function addUserQcm(\Msp\FrontendBundle\Entity\UserQcm $userQcms)
    {
        $this->userQcms[] = $userQcms;
    
        return $this;
    }

    /**
     * Remove userQcms
     *
     * @param \Msp\FrontendBundle\Entity\UserQcm $userQcms
     */
    public function removeUserQcm(\Msp\FrontendBundle\Entity\UserQcm $userQcms)
    {
        $this->userQcms->removeElement($userQcms);
    }

    /**
     * Get userQcms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserQcms()
    {
        return $this->userQcms;
    }

    /**
     * Add userHourlyRates
     *
     * @param \Msp\FrontendBundle\Entity\UserHourlyRate $userHourlyRates
     * @return User
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
     * Add coupons
     *
     * @param \Msp\FrontendBundle\Entity\Coupon $coupons
     * @return User
     */
    public function addCoupon(\Msp\FrontendBundle\Entity\Coupon $coupons)
    {
        $this->coupons[] = $coupons;
    
        return $this;
    }

    /**
     * Remove coupons
     *
     * @param \Msp\FrontendBundle\Entity\Coupon $coupons
     */
    public function removeCoupon(\Msp\FrontendBundle\Entity\Coupon $coupons)
    {
        $this->coupons->removeElement($coupons);
    }

    /**
     * Get coupons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCoupons()
    {
        return $this->coupons;
    }

    /**
     * Add tickets
     *
     * @param \Msp\FrontendBundle\Entity\Ticket $tickets
     * @return User
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
     * Set classe
     *
     * @param \Msp\FrontendBundle\Entity\Classe $classe
     * @return User
     */
    public function setClasse(\Msp\FrontendBundle\Entity\Classe $classe = null)
    {
        $this->classe = $classe;
    
        return $this;
    }

    /**
     * Get classe
     *
     * @return \Msp\FrontendBundle\Entity\Classe 
     */
    public function getClasse()
    {
        return $this->classe;
    }
}
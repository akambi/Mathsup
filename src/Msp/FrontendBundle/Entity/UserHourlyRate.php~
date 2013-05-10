<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserHourlyRate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\UserHourlyRateRepository")
 */
class UserHourlyRate
{
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\UserBundle\Entity\User", inversedBy="userHourlyRates")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;
    
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Cours", inversedBy="userHourlyRates")
    * @ORM\JoinColumn(nullable=false)
    */
    private $cours;
        
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Niveau", inversedBy="userHourlyRates")
    * @ORM\JoinColumn(nullable=false)
    */
    private $niveau;
    
    /**
     * @var interger
     *
     * @ORM\Column(name="taux_horaire", type="integer")
     */
    private $tauxHoraire;

    /**
     * Set tauxHoraire
     *
     * @param integer $tauxHoraire
     * @return UserHourlyRate
     */
    public function setTauxHoraire($tauxHoraire)
    {
        $this->tauxHoraire = $tauxHoraire;
    
        return $this;
    }

    /**
     * Get tauxHoraire
     *
     * @return integer 
     */
    public function getTauxHoraire()
    {
        return $this->tauxHoraire;
    }

    /**
     * Set user
     *
     * @param \Msp\UserBundle\Entity\User $user
     * @return UserHourlyRate
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
     * @return UserHourlyRate
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

    /**
     * Set niveau
     *
     * @param \Msp\FrontendBundle\Entity\Niveau $niveau
     * @return UserHourlyRate
     */
    public function setNiveau(\Msp\FrontendBundle\Entity\Niveau $niveau)
    {
        $this->niveau = $niveau;
    
        return $this;
    }

    /**
     * Get niveau
     *
     * @return \Msp\FrontendBundle\Entity\Niveau 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }
}
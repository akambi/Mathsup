<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Niveau
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\NiveauRepository")
 */
class Niveau
{
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserHourlyRate", mappedBy="niveau")
    */
    private $userHourlyRates;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Classe", mappedBy="niveau")
    */
    private $classes;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Chapitre", mappedBy="niveau")
    */
    private $chapitres;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Qcm", mappedBy="niveau")
    */
    private $qcms;
    
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
     * @ORM\Column(name="libelle", type="string", length=20)
     */
    private $libelle;


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
     * Set libelle
     *
     * @param string $libelle
     * @return Niveau
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chapitres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->qcms = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add chapitres
     *
     * @param \Msp\FrontendBundle\Entity\Chapitre $chapitres
     * @return Niveau
     */
    public function addChapitre(\Msp\FrontendBundle\Entity\Chapitre $chapitres)
    {
        $this->chapitres[] = $chapitres;
    
        return $this;
    }

    /**
     * Remove chapitres
     *
     * @param \Msp\FrontendBundle\Entity\Chapitre $chapitres
     */
    public function removeChapitre(\Msp\FrontendBundle\Entity\Chapitre $chapitres)
    {
        $this->chapitres->removeElement($chapitres);
    }

    /**
     * Get chapitres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChapitres()
    {
        return $this->chapitres;
    }

    /**
     * Add qcms
     *
     * @param \Msp\FrontendBundle\Entity\Qcm $qcms
     * @return Niveau
     */
    public function addQcm(\Msp\FrontendBundle\Entity\Qcm $qcms)
    {
        $this->qcms[] = $qcms;
    
        return $this;
    }

    /**
     * Remove qcms
     *
     * @param \Msp\FrontendBundle\Entity\Qcm $qcms
     */
    public function removeQcm(\Msp\FrontendBundle\Entity\Qcm $qcms)
    {
        $this->qcms->removeElement($qcms);
    }

    /**
     * Get qcms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQcms()
    {
        return $this->qcms;
    }

    /**
     * Add classes
     *
     * @param \Msp\FrontendBundle\Entity\Classe $classes
     * @return Niveau
     */
    public function addClasse(\Msp\FrontendBundle\Entity\Classe $classes)
    {
        $this->classes[] = $classes;
    
        return $this;
    }

    /**
     * Remove classes
     *
     * @param \Msp\FrontendBundle\Entity\Classe $classes
     */
    public function removeClasse(\Msp\FrontendBundle\Entity\Classe $classes)
    {
        $this->classes->removeElement($classes);
    }

    /**
     * Get classes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Add userHourlyRates
     *
     * @param \Msp\FrontendBundle\Entity\UserHourlyRate $userHourlyRates
     * @return Niveau
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
}
<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\ClasseRepository")
 */
class Classe
{
    /**
    * @ORM\OneToMany(targetEntity="Msp\UserBundle\Entity\User", mappedBy="classe")
    */
    private $users;
    
    /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Niveau", inversedBy="classes")
    * @ORM\JoinColumn(nullable=false)
    */
    private $niveau;
    
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
     * @ORM\Column(name="libelle", type="string", length=10)
     */
    private $libelle;
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->libelle;
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
     * Set libelle
     *
     * @param string $libelle
     * @return Classe
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
     * Set niveau
     *
     * @param \Msp\FrontendBundle\Entity\Niveau $niveau
     * @return Classe
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add users
     *
     * @param \Msp\UserBundle\Entity\User $users
     * @return Classe
     */
    public function addUser(\Msp\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Msp\UserBundle\Entity\User $users
     */
    public function removeUser(\Msp\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
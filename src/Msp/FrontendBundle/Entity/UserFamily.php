<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserFamily
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\UserFamilyRepository")
 */
class UserFamily
{
     /**
    * @ORM\OneToOne(targetEntity="Msp\UserBundle\Entity\User", inversedBy="userFamily", cascade={"persist"} )
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;
    
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
     * @ORM\Column(name="nom", type="string", length=45)
     * @Assert\Length(min="2", groups={"flow_RegistrationEleve_step2"})
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=45)
     * @Assert\Length(min="2", groups={"flow_RegistrationEleve_step2"})
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_fixe", type="string", length=20, nullable=true)
     */
    private $numeroFixe;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_portable", type="string", length=20, nullable=true)
     */
    private $numeroPortable;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * toString
     */
    public function __toString()
    {
        return $this->nom.' '.$this->prenom;
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
     * @return UserFamily
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
     * @return UserFamily
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
     * Set sexe
     *
     * @param string $sexe
     * @return UserFamily
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set numeroFixe
     *
     * @param string $numeroFixe
     * @return UserFamily
     */
    public function setNumeroFixe($numeroFixe)
    {
        $this->numeroFixe = $numeroFixe;

        return $this;
    }

    /**
     * Get numeroFixe
     *
     * @return string 
     */
    public function getNumeroFixe()
    {
        return $this->numeroFixe;
    }

    /**
     * Set numeroPortable
     *
     * @param string $numeroPortable
     * @return UserFamily
     */
    public function setNumeroPortable($numeroPortable)
    {
        $this->numeroPortable = $numeroPortable;

        return $this;
    }

    /**
     * Get numeroPortable
     *
     * @return string 
     */
    public function getNumeroPortable()
    {
        return $this->numeroPortable;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return UserFamily
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set user
     *
     * @param \Msp\UserBundle\Entity\User $user
     * @return UserFamily
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

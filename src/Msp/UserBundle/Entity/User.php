<?php

namespace Msp\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use \Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Msp\UserBundle\Entity\UserRepository")
 * @ORM\Table()
 * @UniqueEntity("email")
 * @UniqueEntity("username") 
 * 
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="username",
 *          column=@ORM\Column(
 *              name     = "username",
 *              type = "string",
 *              nullable = true,
 *              length   = 255
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="usernameCanonical",
 *          column=@ORM\Column(
 *              name     = "username_canonical",
 *              type = "string",
 *              nullable = true,
 *              unique   = true,
 *              length   = 255
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              name     = "email",
 *              type = "string",
 *              length   = 255
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name     = "email_canonical",
 *              type = "string",
 *              unique   = true,
 *              length   = 255
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="password",
 *          column=@ORM\Column(
 *              name     = "password",
 *              nullable = true,
 *              type = "string"
 *          )
 *      )
 * })
 * 
 */
class User extends BaseUser
{
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Log", mappedBy="user")
    */
    private $logs;
    
    /**
    * @ORM\OneToOne(targetEntity="Msp\FrontendBundle\Entity\UserFamily", mappedBy="user", cascade={"persist"})
    */
    private $userFamily;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\UserGoConference", mappedBy="user")
    */
    private $userGoConferences;
    
    /**
    * @ORM\OneToMany(targetEntity="Msp\FrontendBundle\Entity\Conference", mappedBy="user")
    */
    private $conferences;
    
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
     * @ORM\Column(name="nom", type="string", length=45)
     * @Assert\Length(min="2")
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=45)
     * @Assert\Length(min="2")
     */
    protected $prenom;
    
   /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Departement", inversedBy="users")
    * @ORM\JoinColumn(nullable=true)
    */
    protected $departement;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    protected $ville;
    
     /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    protected $sexe;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero_fixe", type="string", length=20, nullable=true)
     */
    protected $numeroFixe;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero_portable", type="string", length=20, nullable=true)
     */
    protected $numeroPortable;
    
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text")
     * @Assert\NotBlank()
     */
    private $adresse;
    
    /**
     * @var string
     *
     * @ORM\Column(name="etablissement", type="string", length=255, nullable=true)
     */
    protected $etablissement;
    
    /**
     * @var string
     *
     * @ORM\Column(name="objectifs", type="text", nullable=true)
     * @Assert\Length(min="10")
     */
    private $objectifs;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_naissance", type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateDeNaissance;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscription", type="datetime")
     * @Assert\DateTime()
     */
    private $dateInscription;
    
    /**
    * @Gedmo\Slug(fields={"nom", "prenom"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;
    
    /**
     * Cette variable sert à conserver temporairement le choix du cours pour le pack
     */
    public $cours;
    
    /**
     * Cette variable sert à conserver temporairement le choix du pack
     */
    public $pack;
    
    public function __construct()
    {
        parent::__construct();
        $this->dateInscription = new \Datetime();       
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

    /**
     * Set departement
     *
     * @param \Msp\FrontendBundle\Entity\Departement $departement
     * @return User
     */
    public function setDepartement(\Msp\FrontendBundle\Entity\Departement $departement = null)
    {
        $this->departement = $departement;
    
        return $this;
    }

    /**
     * Get departement
     *
     * @return \Msp\FrontendBundle\Entity\Departement 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    
        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     * @return User
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;
    
        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime 
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }
    
    /**
     * Set $dateDeNaissance
     *
     * @param \DateTime $dateDeNaissance
     * @return User
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;
    
        return $this;
    }

    /**
     * Get datedeNaissance
     *
     * @return \DateTime 
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }
    
    /**
     * Add userGoConferences
     *
     * @param \Msp\FrontendBundle\Entity\UserGoConference $userGoConferences
     * @return User
     */
    public function addUserGoConference(\Msp\FrontendBundle\Entity\UserGoConference $userGoConferences)
    {
        $this->userGoConferences[] = $userGoConferences;
    
        return $this;
    }

    /**
     * Remove userGoConferences
     *
     * @param \Msp\FrontendBundle\Entity\UserGoConference $userGoConferences
     */
    public function removeUserGoConference(\Msp\FrontendBundle\Entity\UserGoConference $userGoConferences)
    {
        $this->userGoConferences->removeElement($userGoConferences);
    }

    /**
     * Get userGoConferences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserGoConferences()
    {
        return $this->userGoConferences;
    }

    /**
     * Add conferences
     *
     * @param \Msp\FrontendBundle\Entity\Conference $conferences
     * @return User
     */
    public function addConference(\Msp\FrontendBundle\Entity\Conference $conferences)
    {
        $this->conferences[] = $conferences;
    
        return $this;
    }

    /**
     * Remove conferences
     *
     * @param \Msp\FrontendBundle\Entity\Conference $conferences
     */
    public function removeConference(\Msp\FrontendBundle\Entity\Conference $conferences)
    {
        $this->conferences->removeElement($conferences);
    }

    /**
     * Get conferences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConferences()
    {
        return $this->conferences;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return User
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
     * @return User
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
     * @return User
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
     * Set adresse
     *
     * @param string $adresse
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
    
     /**
     * Set objectifs
     *
     * @param string $objectifs
     * @return User
     */
    public function setObjectifs($objectifs)
    {
        $this->objectifs = $objectifs;

        return $this;
    }

    /**
     * Get objectifs
     *
     * @return string 
     */
    public function getObjectifs()
    {
        return $this->objectifs;
    }
    
    /**
     * Set etablissement
     *
     * @param string $etablissement
     * @return User
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement
     *
     * @return string 
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }    

    /**
     * Get userFamily
     *
     * @return \Msp\FrontendBundle\Entity\UserFamily
     */
    public function getUserFamily()
    {
        return $this->userFamily;
    }
    
    /**
     * Set userFamily
     *
     * @return \Msp\UserBundle\Entity\User
     */
    public function setUserFamily(\Msp\FrontendBundle\Entity\UserFamily $userFamily){
        $userFamily->setUser($this);        
        $this->userFamily = $userFamily;        
        
        return $this;
    }
    
    /**
     * Add userAvailabilities
     *
     * @param \Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities
     * @return User
     */
    public function addUserAvailability(\Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities)
    {
        $this->userAvailabilities[] = $userAvailabilities;

        return $this;
    }

    /**
     * Remove userAvailabilities
     *
     * @param \Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities
     */
    public function removeUserAvailability(\Msp\FrontendBundle\Entity\UserAvailability $userAvailabilities)
    {
        $this->userAvailabilities->removeElement($userAvailabilities);
    }
    
    /**
     * Add logs
     *
     * @param \Msp\FrontendBundle\Entity\Log $logs
     * @return User
     */
    public function addLog(\Msp\FrontendBundle\Entity\Log $logs)
    {
        $this->logs[] = $logs;
    
        return $this;
    }

    /**
     * Remove logs
     *
     * @param \Msp\FrontendBundle\Entity\Log $logs
     */
    public function removeLog(\Msp\FrontendBundle\Entity\Log $logs)
    {
        $this->logs->removeElement($logs);
    }

    /**
     * Get logs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLogs()
    {
        return $this->logs;
    }
}

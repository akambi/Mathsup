<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ExerciceCorrige
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\ExerciceCorrigeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ExerciceCorrige
{
    /**
    * @ORM\ManyToOne(targetEntity="Msp\FrontendBundle\Entity\Chapitre", inversedBy="excerciceCorriges")
    * @ORM\JoinColumn(nullable=false)
    */
    private $chapitre;
    
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
     * @ORM\Column(name="exercice", type="text")
     */
    private $exercice;

    /**
     * @var string
     *
     * @ORM\Column(name="corrige", type="text")
     */
    private $corrige;

    /**
     * @var string
     *
     * @ORM\Column(name="url_pdf", type="string", length=255, nullable=true)
     */
    private $urlPdf;

    /**
     * @var string
     *
     * @ORM\Column(name="url_video", type="string", length=255, unique=true)
     */
    private $urlVideo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", unique=true)
     */
    private $date;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {        
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->urlPdf = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {        
        if (null === $this->file) {
            return;
        }

        // s'il y a une erreur lors du déplacement du fichier, une exception
        // va automatiquement être lancée par la méthode move(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a
        $this->file->move($this->getUploadRootDir(), $this->urlPdf);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsoluteUrlPdf()) {
            unlink($file);
        }
    }    

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
     * Set exercice
     *
     * @param string $exercice
     * @return ExerciceCorrige
     */
    public function setExercice($exercice)
    {
        $this->exercice = $exercice;
    
        return $this;
    }

    /**
     * Get exercice
     *
     * @return string 
     */
    public function getExercice()
    {
        return $this->exercice;
    }

    /**
     * Set corrige
     *
     * @param string $corrige
     * @return ExerciceCorrige
     */
    public function setCorrige($corrige)
    {
        $this->corrige = $corrige;
    
        return $this;
    }

    /**
     * Get corrige
     *
     * @return string 
     */
    public function getCorrige()
    {
        return $this->corrige;
    }

    /**
     * Set urlPdf
     *
     * @param string $urlPdf
     * @return ExerciceCorrige
     */
    public function setUrlPdf($urlPdf)
    {
        $this->urlPdf = $urlPdf;
    
        return $this;
    }

    /**
     * Get urlPdf
     *
     * @return string 
     */
    public function getUrlPdf()
    {
        return $this->urlPdf;
    }

    /**
     * Set urlVideo
     *
     * @param string $urlVideo
     * @return ExerciceCorrige
     */
    public function setUrlVideo($urlVideo)
    {
        $this->urlVideo = $urlVideo;
    
        return $this;
    }

    /**
     * Get urlVideo
     *
     * @return string 
     */
    public function getUrlVideo()
    {
        return $this->urlVideo;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ExerciceCorrige
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
     * Set chapitre
     *
     * @param \Msp\FrontendBundle\Entity\Chapitre $chapitre
     * @return ExerciceCorrige
     */
    public function setChapitre(\Msp\FrontendBundle\Entity\Chapitre $chapitre)
    {
        $this->chapitre = $chapitre;
    
        return $this;
    }

    /**
     * Get chapitre
     *
     * @return \Msp\FrontendBundle\Entity\Chapitre 
     */
    public function getChapitre()
    {
        return $this->chapitre;
    } 
    
    /**
     * get Absolute UrlPdf
     *
     * @return string 
     */
    public function getAbsoluteUrlPdf()
    {
        return null === $this->urlPdf ? null : $this->getUploadRootDir().'/'.$this->urlPdf;
    }
    
    /**
     * get Web  UrlPdf
     *
     * @return string 
     */
    public function getWebUrlPdf()
    {
        return null === $this->urlPdf ? null : $this->getUploadDir().'/'.$this->urlPdf;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/exercicescorriges';
    }
}
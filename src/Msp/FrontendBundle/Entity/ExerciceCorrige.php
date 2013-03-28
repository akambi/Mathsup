<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciceCorrige
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Msp\FrontendBundle\Entity\ExerciceCorrigeRepository")
 */
class ExerciceCorrige
{
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
     * @ORM\Column(name="url_pdf", type="string", length=255)
     */
    private $urlPdf;

    /**
     * @var string
     *
     * @ORM\Column(name="url_video", type="string", length=255)
     */
    private $urlVideo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
}

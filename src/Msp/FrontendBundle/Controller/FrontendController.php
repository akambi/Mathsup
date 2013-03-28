<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
    public function indexAction()
    {
        return $this->render('MspFrontendBundle:Page:index.html.twig');
    }
    
    public function quiSommesNousAction()
    {
        return $this->render('MspFrontendBundle:Page:qui_sommes_nous.html.twig');
    }
    
    public function contactAction()
    {
        return $this->render('MspFrontendBundle:Page:contact.html.twig');
    }
    
    public function mathPlusAction()
    {
        return $this->render('MspFrontendBundle:Page:math_plus.html.twig');
    }
    
    public function faqAction()
    {
        return $this->render('MspFrontendBundle:Page:faq.html.twig');
    }
    
    public function primaireAction()
    {
        return $this->render('MspFrontendBundle:Page:primaire.html.twig');
    }
    
    public function collegeAction( $page = 0 )
    {
        $page_disponible = array( 0, "6ieme", "5ieme", "4ieme", "3ieme");
        
        if( in_array($page, $page_disponible) ):
            if( $page === 0 ):
                return $this->render('MspFrontendBundle:Page:college.html.twig');
            elseif($page === "6ieme"):
                return $this->collegeSixiemeAction();
            elseif($page === "5ieme"):    
                return $this->collegeCinquiemeAction();
            elseif($page === "4ieme"):
                return $this->collegeQuatriemeAction();
            else:
                return $this->collegeTroisiemeAction();
            endif;
        else:
            throw $this->createNotFoundException("Page introuvable !");
        endif;
    }
    
    public function collegeSixiemeAction()
    {
        return $this->render('MspFrontendBundle:Page:college_sixieme.html.twig');
    }
    
    public function collegeCinquiemeAction()
    {
        return $this->render('MspFrontendBundle:Page:college_cinquieme.html.twig');
    }
 
    public function collegeQuatriemeAction()
    {
        return $this->render('MspFrontendBundle:Page:college_quatrieme.html.twig');
    }
 
     public function collegeTroisiemeAction()
    {
        return $this->render('MspFrontendBundle:Page:college_troisieme.html.twig');
    }
 
    public function lyceeAction( $page = 0 )
    {
        $page_disponible = array( 0, "2nde", "1ere", "tle");
        
        if( in_array($page, $page_disponible) ):
            if( $page === 0 ):
                return $this->render('MspFrontendBundle:Page:lycee.html.twig');
            elseif($page === "2nde"):
                return $this->lyceeSecondeAction();
            elseif($page === "1ere"):    
                return $this->lyceePremiereAction();
            else:
                return $this->lyceeTerminaleAction();
            endif;
        else:
            throw $this->createNotFoundException("Page introuvable !");
        endif;
    }
 
    public function lyceeSecondeAction()
    {
        return $this->render('MspFrontendBundle:Page:lycee_seconde.html.twig');
    }
 
    public function lyceePremiereAction()
    {
        return $this->render('MspFrontendBundle:Page:lycee_premiere.html.twig');
    }
 
    public function lyceeTerminaleAction()
    {
        return $this->render('MspFrontendBundle:Page:lycee_terminale.html.twig');
    }
 
    public function universiteAction( $page = 0 )
    {
        $page_disponible = array( 0, "licence", "prepa");
        
        if( in_array($page, $page_disponible) ):
            if( $page === 0 ):
                return $this->render('MspFrontendBundle:Page:universite.html.twig');
            elseif($page === "licence"):
                return $this->universiteLicenceAction();            
            else:
                return $this->universitePrepaAction();
            endif;
        else:
            throw $this->createNotFoundException("Page introuvable !");
        endif;
    }
 
    public function universiteLicenceAction()
    {
        return $this->render('MspFrontendBundle:Page:universite_licence.html.twig');
    }
 
    public function universitePrepaAction()
    {
        return $this->render('MspFrontendBundle:Page:universite_prepa.html.twig');
    }    
 
    public function institutionAction( $page = 0 )
    {
        $page_disponible = array( 0, "remise-a-niveau", "comite-entreprise", "preparation-concours");
        
        if( in_array($page, $page_disponible) ):
            if( $page === 0 ):
                return $this->render('MspFrontendBundle:Page:institution.html.twig');
            elseif($page === "remise-a-niveau"):
                return $this->institutionRemiseNiveauAction();
            elseif($page === "comite-entreprise"):    
                return $this->institutionComiteEntrepriseAction();
            else:
                return $this->institutionPreparationConcoursAction();
            endif;
        else:
            throw $this->createNotFoundException("Page introuvable !");
        endif;
        
        
    }
 
    public function institutionRemiseNiveauAction()
    {
        return $this->render('MspFrontendBundle:Page:institution_remise_niveau.html.twig');
    }
    
    public function institutionComiteEntrepriseAction()
    {
        return $this->render('MspFrontendBundle:Page:institution_comite_entreprise.html.twig');
    }
    
    public function institutionPreparationConcoursAction()
    {
        return $this->render('MspFrontendBundle:Page:institution_preparation_concours.html.twig');
    }
    
    public function tarifsAction()
    {
        return $this->render('MspFrontendBundle:Page:tarifs.html.twig');
    }
    
    public function partenariatsAction()
    {
        return $this->render('MspFrontendBundle:Page:partenariats.html.twig');
    }
    
    public function nosEngagementsAction()
    {
        return $this->render('MspFrontendBundle:Page:nos_engagements.html.twig');
    }
    
    public function cgsAction()
    {
        return $this->render('MspFrontendBundle:Page:cgs.html.twig');
    }
    
    public function planDuSiteAction()
    {
        return $this->render('MspFrontendBundle:Page:plan_du_site.html.twig');
    }
    
    public function liensAction()
    {
        return $this->render('MspFrontendBundle:Page:liens.html.twig');
    }
}

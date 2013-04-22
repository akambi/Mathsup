<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Msp\FrontendBundle\Form\BigBlueButtonType As BBBType;
use Msp\FrontendBundle\Form\BigBlueButtonHandler As BBBHandler;

use Msp\FrontendBundle\Entity\Conference;
use Msp\FrontendBundle\Entity\UserGoConference;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Collection;

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
    
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function eleveAction( $slug)
    {
        return $this->render('MspFrontendBundle:User:eleve.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_PROFESSEUR")
     */
    public function professeurAction( $slug )
    {
        return $this->render('MspFrontendBundle:User:professeur.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function adminAction( $slug )
    {
        return $this->render('MspFrontendBundle:User:admin.html.twig');
    }
    
    
    /**
     * @Secure(roles="ROLE_ELEVE, ROLE_PROFESSEUR")
     */
    public function connexionConferenceAction()
    {
        $msg = "";
        $form = $this->createForm(new BBBType);
    
        $formHandler = new BBBHandler($form, $this->get('request'), $this->getDoctrine()->getEntityManager(), $this->container);
    //  On exécute le traitement du formulaire. S'il retourne true, alors le formulaire a bien été traité
        if( $formHandler->process() )
        {
            $msg = $formHandler->getError();
        }
        
        return $this->render('MspFrontendBundle:User:conf_connect.html.twig', array( 'form' => $form->createView(), 'msg' => $msg ) );
    }
    
    /**
     * @Secure(roles="ROLE_ELEVE, ROLE_PROFESSEUR")
     */
    public function connexionConferenceFormAction()
    {        
        $form = $this->createForm(new BBBType);
        return $this->render('MspFrontendBundle:User:conf_connect_form.html.twig', array( 'form' => $form->createView()) );
    }
    
    /**
     * @Secure(roles="ROLE_ELEVE, ROLE_PROFESSEUR")
     */
    public function conferenceAvisAction( Conference $conference )
    {        
    //  Gestion des erreurs ou confirmation
        $error = "";
        $msg = "";
    //  Les contraintres sur le formulaire
        $collectionConstraint = new Collection(array(
            'message' => new Length(array("min" => 5)),
        ));
    //  Le formulaire
        $form = $this->createFormBuilder( null, array( 'constraints' => $collectionConstraint ) )
                ->add('message','textarea', array('label'=>"Message"))        
                ->getForm();
    //  On valide le formulaire
        $request = $this->getRequest();
        if ( $request->isMethod('POST') ) {
            $form->bind($request);
            
            if ($form->isValid()) {               
                $data = $form->getData();
                $message = $data["message"];
            //  On enregistre le message
                $user = $this->container->get('security.context')->getToken()->getUser();
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('MspFrontendBundle:UserGoConference');
                $user_go_conference = $repository->findOneBy( array( "user" => $user, "conference" => $conference) );
                
                if ($user_go_conference) {                    
                    $user_go_conference->setMessage( $message );

                    $em->persist($user_go_conference);
                    $em->flush();
                    $msg = "Votre Message a bien été pris en compte. Merci !";
                }else{
                    $error = "Désolé, vous n'avez pas assisté à cette conférence";
                }
            }            
        }
        
        return $this->render('MspFrontendBundle:User:conf_avis.html.twig', array( 'form' => $form->createView(), 'error' => $error, 'msg' => $msg) );
    }
    
}

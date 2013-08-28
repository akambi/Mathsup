<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Msp\FrontendBundle\Form\BigBlueButtonType As BBBType;
use Msp\FrontendBundle\Form\BigBlueButtonHandler As BBBHandler;
//  Introduction des entités
use Msp\FrontendBundle\Entity\Conference;
use Msp\FrontendBundle\Entity\UserAvailability;
use Msp\FrontendBundle\Entity\UserQcm;
use Msp\FrontendBundle\Entity\Coupon;
use Msp\FrontendBundle\Entity\Ticket;
use Msp\FrontendBundle\Entity\Newsletter;
//  Introduction des form type
use Msp\FrontendBundle\Form\CouponType;
use Msp\FrontendBundle\Form\ContactType;
use Msp\FrontendBundle\Form\ContactHandler;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Collection;

use Msp\FrontendBundle\Service\FPDF;

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
        $msg="";
        $form = $this->createForm(new ContactType);
    
        $formHandler = new ContactHandler($form, $this->get('request'), $this->container);
    //  On exécute le traitement du formulaire. S'il retourne true, alors le formulaire a bien été traité
        if( $formHandler->process() )
        {
            $msg = "Merci, nous prenons en compte votre demande.";
        }
        
        return $this->render('MspFrontendBundle:Page:contact.html.twig', array( 'form' => $form->createView(), 'msg' => $msg ));
    }
    
    public function newsletterAction()
    {
        $request = $this->getRequest();
        if( $request->getMethod() == 'POST' )
        {
            $user_email = $request->get('user_email');
            $user_name = $request->get('user_name');
            $em = $this->getDoctrine()->getManager();
            $newsletter = $em->getRepository('MspFrontendBundle:Newsletter')->findByEmail($user_email);
            if(!$newsletter):
                $newsletter = new Newsletter();
                $newsletter->setNom($user_name);
                $newsletter->setEmail($user_email);
                $em->persist($newsletter);
                $em->flush();
                $msg="Merci pour votre inscription à la newsletter !";
            else:
                $msg="Vous êtes déjà inscrit à notre newsletter. Merci !";
            endif;
        }else{
            $referer_url = $this->get('request')->headers->get('referer');
            if ($referer_url != null) {
                return $this->redirect($referer_url);
            }else{
                return $this->redirect($this->generateUrl('msp_frontend_homepage'));
            }
        }
        
        return $this->render('MspFrontendBundle:Page:newsletter.html.twig', array( 'msg' => $msg ) );
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
    
    public function collegeAction()
    {        
        return $this->render('MspFrontendBundle:Page:college.html.twig');            
    }
         
    public function lyceeAction()
    {        
        return $this->render('MspFrontendBundle:Page:lycee.html.twig');           
    }
    
    public function universiteAction()
    {          
        return $this->render('MspFrontendBundle:Page:universite.html.twig');            
    }
    
    public function institutionAction( $page = 0 )
    {       
        return $this->render('MspFrontendBundle:Page:institution.html.twig');
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
     * @Secure(roles="ROLE_ELEVE")
     */
    public function eleveCorrigesAction( $page )
    {
    //  On récupère l'utilisateur et son niveau
        $user = $this->container->get('security.context')->getToken()->getUser();
        $classe = $user->getClasse();
        $niveau = $classe->getNiveau();
    //  Message si aucun exercices corrigés disponible
        $msg = "";
    //  On récupère les exercices corrigés de son niveau
        $em = $this->getDoctrine()->getManager();        
        $repository = $em->getRepository('MspFrontendBundle:ExerciceCorrige');
        
        $total = $repository->getTotalForNiveau( $niveau );
        $nb_par_page = $this->container->getParameter('excerccice_corrige');
        $nb_pages = (ceil($total/$nb_par_page))? ceil($total/$nb_par_page): 1;    
        $offset = ($page-1) * $nb_par_page;
        
        if( $page < 1 OR $page > $nb_pages )
        {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        }
        
        $entities = $repository->getByNiveau($niveau, $nb_par_page, $offset);
        
        if( !$entities ) $msg = "Aucun Exercice Corrigé est disponible pour le moment!";
        
        return $this->render('MspFrontendBundle:User:eleve_corriges.html.twig', array( 'entities' => $entities, 'msg' => $msg, 'page' => $page, 'nb_pages' => $nb_pages) );
    }
    
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function eleveCorrigesShowAction( $id )
    {   
    //  On récupère les exercices corrigés de son niveau
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MspFrontendBundle:ExerciceCorrige');
        $entity = $repository->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExerciceCorrige entity.');
        }
        
        return $this->render('MspFrontendBundle:User:eleve_corriges_show.html.twig', array( 'entity' => $entity) );
    }
    
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function eleveQcmAction()
    {
    //  On récupère l'utilisateur et son niveau
        $user = $this->container->get('security.context')->getToken()->getUser();
        $classe = $user->getClasse();
        $niveau = $classe->getNiveau();
    //  Message si aucun qcm disponible
        $msg = "";
    //  On récupère les qcm de son niveau
        $em = $this->getDoctrine()->getManager();        
        $repository = $em->getRepository('MspFrontendBundle:Qcm');
        $repository_assoc = $em->getRepository('MspFrontendBundle:UserQcm');
        
        $nb_qcm_to_show = 1;
        $userQcms = $repository_assoc->findBy( array( 'user' => $user ), array());
        if( $userQcms ):
            foreach ( $userQcms as $userQcm ) :
                if( $userQcm->getNote() >= $this->container->getParameter('note') ):
                    $nb_qcm_to_show++;
                endif;
            endforeach;
        endif;
        
        $entities = $repository->getByNiveauOrderByDifficulter( $niveau, $nb_qcm_to_show, 0);
        
        if( !$entities ) $msg = "Aucun QCM est disponible pour le moment!";
        
        return $this->render('MspFrontendBundle:User:eleve_qcm.html.twig', array( 'entities' => $entities, 'msg' => $msg) );
    }
    
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function eleveQcmTestAction( $qcm_id, $question_id )
    {
    //  On récupère l'utilisateur
        $user = $this->container->get('security.context')->getToken()->getUser();        
        $msg = "";
    //  On definie les repository
        $request = $this->getRequest();
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();        
        $repository_qcm = $em->getRepository('MspFrontendBundle:Qcm');
        $repository_question = $em->getRepository('MspFrontendBundle:Question');
        $repository_reponse = $em->getRepository('MspFrontendBundle:Reponse');
        $repository_userqcm = $em->getRepository('MspFrontendBundle:UserQcm');
    //  on supprime la variable session note à chaque début de questionnaire
        if( $question_id == 1 ):
            if($session->get('note')):
                $session->remove('note');
            endif;
        endif;
    //  on récupère le qcm et ses questions
        $qcm = $repository_qcm->find( $qcm_id );        
        $questions = $qcm->getQuestions();        
    //  On récupère la durée globale en seconde
        $time = $qcm->getDuree();
        $time = $time->format('H:i:s');        
        $time = $this->getSecondeByHourFormat($time) ;
        
        $question_id_suiv = "end";
        $question = "";
        $question_time = "";
        $reponses = "";
        if( $question_id !== "end"): 
        //  on récupère la question à afficher dont l"index est $question_id - 1
            $question = $questions[$question_id - 1];
            $question_time = $question->getDuree();
            $question_time = $question_time->format('H:i:s');        
            $question_time = $this->getSecondeByHourFormat($question_time);
            $reponses = $question->getReponses();
        // on définit l'index de la question suivante; end pour sigifier que c'est la dernière question
            if( count($questions) == $question_id ):
                $question_id_suiv = "end";
            else:
                $question_id_suiv = $question_id + 1;
            endif;
        endif;        
    //  on vérifie si des variables ont été envoyé par poste
        if( $request->getMethod() == "POST"):
        //  on récupère l'id de la réponse, l'id de la question et le temps globale restant
            $reponse_id = $request->request->get("reponse");
            $quest_id = $request->request->get("question");
            $time = $request->request->get("time");             
            $reponse = ( $reponse_id )? $repository_reponse->find($reponse_id): "";
        //  Si la réponse est bonne on attribue la note de 1
            if( !empty($reponse) and $reponse->getEtat() === true):
                if($session->get('note')):
                    $array_note = $session->get('note');
                    $array_note[$quest_id] =  1;
                    $session->set('note', $array_note );
                else:
                    $session->set('note', array( $quest_id => 1) );
                endif;                
            else:
                if($session->get('note')):
                    $array_note = $session->get('note');
                    $array_note[$quest_id] =  0;
                    $session->set('note', $array_note );
                else:
                    $session->set('note', array( $quest_id => 0) );
                endif;
            endif;
        //  si aucune question restante, on enregistre la note de l'élève, on supprime la variable session
            if( $question_id == "end"):                
                $array_note = $session->get('note');                
                $note = 0;
                foreach ($array_note as $value):
                    $note += $value;
                endforeach;                
                //$session->remove('note');
                $userQcm = $repository_userqcm->findOneBy( array( 'user' => $user, 'qcm' => $qcm ));                
                if( !$userQcm):
                    $userQcm = new UserQcm();
                    $userQcm->setUser($user);
                    $userQcm->setQcm($qcm);
                endif;                
                                
                $userQcm->setNote($note);                
                $em->persist($userQcm);
                $em->flush();
                
            //  si la note est supérieur ou égale à celle requise on le félicite                
                if( $note >= $this->container->getParameter('note') ):
                    $msg = "Félicitations vous accédez au niveau supérieur.";
                else:
                    $msg = "Dommage vous pouvez mieux faire, relisez votre cours.";
                endif;
                $msg .= "Votre note est: ".$note;
            endif;  
        endif;
        
        return $this->render('MspFrontendBundle:User:eleve_qcm_test.html.twig', 
                array( 'qcm' => $qcm, 'question' => $question, 'reponses' => $reponses, 'time' => $time, 'question_time' => $question_time,
                    'question_id_suiv' => $question_id_suiv, 'msg' => $msg ) );
    }
    
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function eleveTicketAction()
    {
    //  On récupère l'utilisateur
        $user = $this->container->get('security.context')->getToken()->getUser();        
    //  On définit ici les repository
        $em = $this->getDoctrine()->getManager();        
        $repository = $em->getRepository('MspFrontendBundle:Coupon');        
    //  On récupère le total des coupons de l'utilisateur et ceux restants
        $ticket_total = $repository->getAllForUser( $user );
        $ticket_utiliser = $repository->getAllIsUseForUser( $user );
    //  On récupère les tickets restants
        $entities = $repository->getAllIsNotUseForUser( $user );        
        
        return $this->render('MspFrontendBundle:User:eleve_ticket.html.twig', 
                array( "ticket_total" => $ticket_total, "ticket_utiliser" => $ticket_utiliser, 'entities' => $entities ) );
    }
    
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function eleveTicketAjouterAction()
    {
    //  On récupère l'utilisateur et son niveau
        $user = $this->container->get('security.context')->getToken()->getUser();        
    //  on crée le formulaire
        $entity = new Coupon();
        $entity->setUser($user);
        $form   = $this->createForm(new CouponType(), $entity);
    //  on contrôle le formulaire et on enregistre
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        
        if( $request->getMethod() == 'POST' ):
            $form->bind($request);            
            
            if ( $form->isValid() ) {
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('msp_eleve_ticket_show', array( 'id' => $entity->getId() ) ) );
            }
        endif;
        
        return  $this->render('MspFrontendBundle:User:eleve_ticket_ajouter.html.twig', 
                array( 'entity' => $entity, 'form'   => $form->createView()) );
    }
    
    /**
     * @Secure(roles="ROLE_ELEVE")
     */
    public function eleveTicketShowAction( $id )
    {
    //  on récupère le coupon
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Coupon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Coupon entity.');
        }
        
        if( ! $this->isAuthorised( $entity->getUser()->getId() ) )
        {        
            throw new AccessDeniedHttpException('Accès limité aux propriétaires');
        }
        
        return  $this->render('MspFrontendBundle:User:eleve_ticket_show.html.twig', 
                array( 'entity' => $entity) );
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
        $em = $this->getDoctrine()->getManager();
        
        $repositoryUser = $em->getRepository('MspUserBundle:User');
        $repositoryCoupon = $em->getRepository('MspFrontendBundle:Coupon');
        $repositoryTicket = $em->getRepository('MspFrontendBundle:Ticket');
        
        $total_ticket = $repositoryCoupon->getTotal();
        $ticket_entrer = $repositoryTicket->getTotal();
        
        $professeurs_alert = $repositoryUser->getUserTicketAlert();
        $eleves_alert = $repositoryUser->getUserCouponAlert();   
        
        return $this->render('MspFrontendBundle:User:admin.html.twig', 
            array(  'eleves_alert' => $eleves_alert, 'professeurs_alert' => $professeurs_alert, 
                    'total_ticket' => $total_ticket, 'ticket_entrer' => $ticket_entrer));
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
    
    /**
     * @Secure(roles="ROLE_PROFESSEUR")
     */
    public function planningAction( $slug )
    {
    //  On recupère la date du lundi puis son timetamp
        $lundi = "2013-04-29";        
        $timetamp_lundi = $this->getTimeTampForDate($lundi);
    //  On définit les jours de la semaine
        $semaine = array();
        $semaine[0] = $lundi;
        for( $i=1; $i<=6; $i++):
            $semaine[$i] = Date("Y-m-d",$timetamp_lundi + 24*60*60*$i);
        endfor;
    //  On définie les repositories
        $em = $this->getDoctrine()->getManager();
        $repository_assoc = $em->getRepository('MspFrontendBundle:UserAvailability');
        $repository_cours = $em->getRepository('MspFrontendBundle:Cours');
    //  On récupère les informations sur le professeur et les cours
        $user = $em->getRepository('MspUserBundle:User')->findOneBy( array( "slug" => $slug ) );
        $cours = $repository_cours->findAll();
    //  On récupère le planning du professeur ou on l'instancie
        $userAvalaibility = array();
        $userAvalaibility = $repository_assoc->getAllForUserByDateAndCours( $user, $lundi. " 00:00:00" );
        if(!$userAvalaibility):            
            $s = 0;
            foreach ($cours as $cours_val):
                foreach ($semaine as $semaine_val ):
                    $userAvalaibility[$s] = new UserAvailability();                    
                    $userAvalaibility[$s]->setCours($cours_val);
                    $userAvalaibility[$s]->setUser($user);                    
                    $userAvalaibility[$s]->setDate( new \DateTime($semaine_val) );
                    $userAvalaibility[$s]->setTimetamp( $this->getTimeTampForDate($semaine_val) );
                    $userAvalaibility[$s]->setDisponible(false);                    
                    $em->persist($userAvalaibility[$s]);                   
                    $s++;
                endforeach;
            endforeach;
            $em->flush();
        endif;
    //  On définit ici les disponibilités de la semaine par cours (UA=UserAvailability)
        $UA_cours1 = array();
        $UA_cours2 = array();
        $UA_cours3 = array();
        foreach ( $userAvalaibility as $key => $value):
            if( $key < 7 ):
                $UA_cours1[] = $value;
            elseif( $key < 14 ):
                $UA_cours2[] = $value;               
            else:
                $UA_cours3[] = $value;
            endif;
        endforeach;
        
        return  $this->render( 'MspFrontendBundle:User:professeur_planning.html.twig', 
                array( 'UA_cours1' => $UA_cours1,  'UA_cours2' => $UA_cours2, 'UA_cours3' => $UA_cours3, 'cours' => $cours, 'user' => $user) );
    }
    
    /**
     * @Secure(roles="ROLE_PROFESSEUR")
     */
    public function planningEditAction( $user_slug, $cours_id, $timetamp, $disponibilite )
    {    
    //  On définie les repositories
        $em = $this->getDoctrine()->getManager();
        $repository_assoc = $em->getRepository('MspFrontendBundle:UserAvailability');
        $repository_cours = $em->getRepository('MspFrontendBundle:Cours');
    //  On récupère les informations sur le professeur et les cours
        $user = $em->getRepository('MspUserBundle:User')->findOneBy( array( "slug" => $user_slug ) );
        $cours = $repository_cours->find($cours_id);
    //  On récupère le planning        
        $userAvailability = $repository_assoc->findOneBy( array( 'user' => $user, 'cours' => $cours, 'timetamp' => $timetamp) );
        if( $this->isAuthorised( $userAvailability->getUser()->getId() ) ):
            $disponibilite = ( $disponibilite ) ? true : false;
            $userAvailability->setDisponible( $disponibilite );
            $em->persist($userAvailability);
            $em->flush();
        endif;
        return $this->redirect($this->generateUrl('msp_professeur_planning', array('slug' => $user_slug)));
    }
    
    /**
     * @Secure(roles="ROLE_PROFESSEUR")
     */
    public function professeurTicketAction()
    {    
    //  On récupère l'utilisateur
        $user = $this->container->get('security.context')->getToken()->getUser();
    //  on crée le formulaire d'entrée du ticket
        $form = $this->createFormBuilder()
                ->add('token', 'textarea', array( 'label' => 'Numéro du ticket') )                
                ->getForm();
    //  message d'erreur ou de confirmation
        $error = "";
        $msg = "";
    //  les repository
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        
        $repository_coupon = $em->getRepository('MspFrontendBundle:Coupon');
        $repository_ticket = $em->getRepository('MspFrontendBundle:Ticket');        
    //  on contrôle l'envoie du formulaire
        if( $request->getMethod() == 'POST' ):
            $form->bind($request);            
            
            if ( $form->isValid() ) {
            //  On récupère les infos du formulaire
               $form_data = $request->request->get('form');
               $token = $form_data["token"];               
            //  on récupère le coupon et s'il existe on contrôle l'existance du ticket
               $coupon = $repository_coupon->findOneByToken( $token );
               if( !$coupon ):
                    $error = "Ce numéro correspont à aucun ticket";
                else:
                    $ticket = $repository_ticket->findOneByCoupon( $coupon );                    
                    if( $ticket ):
                        $error = "Ce numéro de ticket a déjà été entré.";
                    else:        
                        
                        $ticket = new Ticket();
                        $ticket->setCoupon($coupon);
                        $ticket->setCours($coupon->getCours());
                        $ticket->setUser($user);
                    //  on enregistre
                        $em->persist($ticket);
                        $em->flush();
                        
                        $msg = "Le ticket a bien été enregistré avec succès. Merci!";
                    endif;
                    
               endif;
            }
            
        endif;
        
        return  $this->render( 'MspFrontendBundle:User:professeur_ticket.html.twig', 
                array( 'form'   => $form->createView(), 'error' => $error, 'msg' => $msg ) );
    }
    
    /**
     * @Secure(roles="ROLE_PROFESSEUR")
     */
    public function professeurBilanMensuelAction()
    {    
    //  On récupère l'utilisateur
        $user = $this->container->get('security.context')->getToken()->getUser();
    //  la date du début du mois
        $date = date('Y-m').'-01';
    //  Les repository
        $em = $this->getDoctrine()->getManager();
        $repositoryTicket = $em->getRepository('MspFrontendBundle:Ticket');
        $repositoryUserHourlyRate = $em->getRepository('MspFrontendBundle:UserHourlyRate');
        
        $tikets = $repositoryTicket->getAllForUser( $user, $date );
        
        $coupons = array();
        $cours = array();
        $niveaux = array();
        $eleves = array();
        $tauxhoraires = array();
        $total = 0;
        
        foreach ($tikets as $key => $value):
            $coupons[] = $value->getCoupon();
            $cours[] = $value->getCours();
            $niveaux[] = $value->getCoupon()->getUser()->getClasse()->getNiveau();
            $eleves[] = $value->getCoupon()->getUser()->getPrenom().' '.$value->getCoupon()->getUser()->getNom();            
            $tauxhoraire = $repositoryUserHourlyRate->findOneBy(array('user' => $user, 'cours' => $value->getCours(), 'niveau' => $value->getCoupon()->getUser()->getClasse()->getNiveau()));
            $tauxhoraires[] = ($tauxhoraire)? $tauxhoraire->getTauxHoraire() : 0;
            $total += $tauxhoraires[$key];
        endforeach;
        
        return  $this->render( 'MspFrontendBundle:User:professeur_bilan_mensuel.html.twig', 
                array( 'coupons' => $coupons, 'eleves' => $eleves, 'tauxhoraires' => $tauxhoraires, 'total' => $total, 'cours' => $cours, 'niveaux' => $niveaux) );
    }
    
    /**
     * @Secure(roles="ROLE_PROFESSEUR")
     */
    public function professeurFichePaieAction()
    {    
    //  On récupère l'utilisateur
        $user = $this->container->get('security.context')->getToken()->getUser();
    //  la date du début du mois
        $date = date('Y-m').'-01';
    //  Les repository
        $em = $this->getDoctrine()->getManager();
        $repositoryTicket = $em->getRepository('MspFrontendBundle:Ticket');
        $repositoryUserHourlyRate = $em->getRepository('MspFrontendBundle:UserHourlyRate');

        $tikets = $repositoryTicket->getAllForUser( $user, $date );
        
        $coupons = array();
        $cours = array();
        $niveaux = array();
        $eleves = array();
        $tauxhoraires = array();
        $total = 0;
        
        foreach ($tikets as $key => $value):
            $coupons[] = $value->getCoupon();
            $cours[] = $value->getCours();
            $niveaux[] = $value->getCoupon()->getUser()->getClasse()->getNiveau();
            $eleves[] = $value->getCoupon()->getUser()->getPrenom().' '.$value->getCoupon()->getUser()->getNom();            
            $tauxhoraire = $repositoryUserHourlyRate->findOneBy(array('user' => $user, 'cours' => $value->getCours(), 'niveau' => $value->getCoupon()->getUser()->getClasse()->getNiveau()));
            $tauxhoraires[] = ($tauxhoraire)? $tauxhoraire->getTauxHoraire() : 0;
            $total += $tauxhoraires[$key];
        endforeach;
        
        return  $this->render( 'MspFrontendBundle:User:professeur_fiche_paie.html.twig', 
                array( 'coupons' => $coupons, 'eleves' => $eleves, 'tauxhoraires' => $tauxhoraires, 'total' => $total, 'cours' => $cours, 'niveaux' => $niveaux) );
    }
              
    public function barcodeAction($code) 
    {        
    //  On crée une instance de fpdf
        $pdf = new FPDF('P', 'pt');
    //  on definit le nom de l'auteur et le titre du document
        $pdf->SetAuthor('MathSup');
        $pdf->SetTitle('Barcode '.$code ); 
        $pdf->AddPage();               
        $fontSize = 12;
    //  on ajoute l'image du parcode
        $pdf->Image($this->getRequest()->server->get('DOCUMENT_ROOT').'/img/barcode.jpg');
    //  on ajoute le code
        $pdf->SetFont('Arial','B',$fontSize);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(65, 110);
        $len = $pdf->GetStringWidth($code);
        $pdf->Cell($len, 10, $code);        
    //  on affiche le pdf
        return new Response($pdf->Output(), 200,
                        array(
                            'Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'inline; filename="doc.pdf"'
                        )
        );
        
    }
    
    /**
     * Es-il autorisé à faire une action
     */
    public function isAuthorised($id){
    //  Si c'est l'administrateur il a accès
        if( $this->get('security.context')->isGranted('ROLE_ADMIN') ):
            return true;
        endif;
    //  Si les identifiants sont différents alors il n'a pas accès
        if( $this->container->get('security.context')->getToken()->getUser()->getId() != $id ):
            return false;
        endif;
        
        return true;
    }
    
    
    public function getTimeTampForDate( $date ){
        $array_date = explode('-', $date);
        return mktime("00", "00", "00", $array_date[1], $array_date[2], $array_date[0]);
    }
    
    public function getSecondeByHourFormat( $hourFormat ){
        $time_array = explode(':', $hourFormat );
        return $time_array[0] * 3600 + $time_array[1] * 60 + $time_array[2] ;
    }
}

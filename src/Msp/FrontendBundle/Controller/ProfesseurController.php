<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Form\ProfesseurType As UserType;

use Msp\FrontendBundle\Entity\UserHourlyRate;
use Msp\FrontendBundle\Form\UserHourlyRateType;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;

use Swift_Attachment;

/**
 * User controller.
 *
 * @Route("/professeur")
 */
class ProfesseurController extends Controller
{
    /**
     * @Secure(roles="ROLE_ADMIN")
     * Lists all User entities.
     *
     * @Route("/", name="professeur")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MspUserBundle:User')->getUserByRole("ROLE_PROFESSEUR");

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="professeur_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="professeur_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="professeur_update")
     * @Method("PUT")
     * @Template("MspUserBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('professeur_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * Deletes a User entity.
     *
     * @Route("/{id}", name="professeur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspUserBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('professeur'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     * Manage Taux of User entity.
     *
     */
    public function tauxAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository_assoc = $em->getRepository('MspFrontendBundle:UserHourlyRate');
        $repository_cours = $em->getRepository('MspFrontendBundle:Cours');
        $repository_niveau = $em->getRepository('MspFrontendBundle:Niveau');
    //  On récupère les informations sur le professeur, les cours et les niveaux
        $user = $em->getRepository('MspUserBundle:User')->find( $id );
        $cours = $repository_cours->findAll();
        $niveaux = $repository_niveau->findAll();
    //  On récupère le planning du professeur ou on l'instancie
        $userHourlyRates = array();
        $userHourlyRates = $repository_assoc->getAllForUser( $user );
        if(!$userHourlyRates):            
            $s = 0;
            foreach ($cours as $cours_val):
                foreach ($niveaux as $niveau_val ):
                    $userHourlyRates[$s] = new UserHourlyRate();                    
                    $userHourlyRates[$s]->setCours($cours_val);
                    $userHourlyRates[$s]->setUser($user);                    
                    $userHourlyRates[$s]->setNiveau( $niveau_val );
                    $userHourlyRates[$s]->setTauxHoraire( 00.00 );                                   
                    $em->persist($userHourlyRates[$s]);                
                    $s++;
                endforeach;
            endforeach;
            $em->flush();
        endif;
    //  On définit ici les taux pour chaque colonne du tableau (UHR=UserHourlyRate)
        $UHR_cours1 = array();
        $UHR_cours2 = array();
        $UHR_cours3 = array();
        foreach ( $userHourlyRates as $key => $value):
            if( $key < 4 ):
                $UHR_cours1[] = $value;
            elseif( $key < 8 ):
                $UHR_cours2[] = $value;               
            else:
                $UHR_cours3[] = $value;
            endif;
        endforeach;        
        
        return  $this->render( 'MspFrontendBundle:Professeur:taux.html.twig', 
                array( 'UHR_cours1' => $UHR_cours1,  'UHR_cours2' => $UHR_cours2, 'UHR_cours3' => $UHR_cours3, 'cours' => $cours, 'user' => $user, 'niveau' => $niveaux ));
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     * Edit Taux of User entity.
     *
     */
    public function tauxEditAction( $user_id, $cours_id, $niveau_id )
    {    
    //  On définie les repositories
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $repository_assoc = $em->getRepository('MspFrontendBundle:UserHourlyRate');
        $repository_cours = $em->getRepository('MspFrontendBundle:Cours');
        $repository_niveau = $em->getRepository('MspFrontendBundle:Niveau');
    //  On récupère les informations sur le professeur et les cours
        $user = $em->getRepository('MspUserBundle:User')->find( $user_id );
        $cours = $repository_cours->find( $cours_id );
        $niveau = $repository_niveau->find( $niveau_id );
        
    //  On récupère l'instance de UserHourlyRate
        $userHourlyRate = $repository_assoc->findOneBy( array( 'user' => $user, 'cours' => $cours, 'niveau' => $niveau ) );
        
        if (!$userHourlyRate) {
            throw $this->createNotFoundException('Unable to find UserHourlyRate entity.');
        }

        $form = $this->createForm(new UserHourlyRateType(), $userHourlyRate);
        
        if( $request->getMethod() == 'POST' ):
            $form->bind($request);            
            
            if ( $form->isValid() ) {
                $em->persist($userHourlyRate);
                $em->flush();

                return $this->redirect($this->generateUrl('professeur_taux', array( 'id' => $user->getId() ) ) );
            }
        endif;

        
        return  $this->render( 'MspFrontendBundle:Professeur:taux_edit.html.twig', 
                array( 'user' => $user, 'form' => $form->createView() ));
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function professeurBilanMensuelAction( $id )
    {    
        $em = $this->getDoctrine()->getManager();
    //  On récupère l'utilisateur
        $user = $em->getRepository('MspUserBundle:User')->find($id); 
    //  la date du début du mois
        $date = date('Y-m').'-01';
    //  Les repository        
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
        
        return  $this->render( 'MspFrontendBundle:Professeur:bilan_mensuel.html.twig', 
                array( 'coupons' => $coupons, 'eleves' => $eleves, 'tauxhoraires' => $tauxhoraires, 'total' => $total, 'cours' => $cours, 'niveaux' => $niveaux, 'user' => $user) );
    }
    
    /**
     * Fiche de paie pdf
     */
    public function professeurFichePaieAction( $id, $type )
    {
        $em = $this->getDoctrine()->getManager();
    //  On récupère l'utilisateur
        $user = $em->getRepository('MspUserBundle:User')->find($id); 
    //  la date du début du mois
        $date = date('Y-m').'-01';
    //  Les repository        
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
        
        if( $type == "html" ):
            return  $this->render( 'MspFrontendBundle:Professeur:fiche_paie.html.twig', 
                array( 'coupons' => $coupons, 'eleves' => $eleves, 'tauxhoraires' => $tauxhoraires, 'total' => $total, 'cours' => $cours, 'niveaux' => $niveaux, 'user' => $user) );
        else:
            return  $this->render( 'MspFrontendBundle:Professeur:fiche_paie_pdf.html.twig', 
                array( 'coupons' => $coupons, 'eleves' => $eleves, 'tauxhoraires' => $tauxhoraires, 'total' => $total, 'cours' => $cours, 'niveaux' => $niveaux, 'user' => $user) );
        endif;        
    }
    
    /**
     * pdf fiche de paie
     */
    public function pdfFichePaieAction( $id, $action )
    {
    //  Erreur si l'utilisateur n'a pas accès    
        if( !$this->isAuthorised( $id ) )
        {        
            throw new AccessDeniedHttpException('Accès limité aux propriétaires');
        }
    //  On récupère le html de la fiche de paie
        $html = $this->professeurFichePaieAction( $id, 'pdf');
        $html = $html->getContent();
        //echo $html; exit();
    //  on récupère le services pdf
        $pdfGenerator = $this->get('spraed.pdf.generator');
    //  On affiche le pdf
        if( $action == "print"):
             return new Response($pdfGenerator->generatePDF($html),
                            200,
                            array(
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'inline; filename="out.pdf"'
                            )
            );
        else:
            $em = $this->getDoctrine()->getManager();
        //  On récupère l'utilisateur
            $user = $em->getRepository('MspUserBundle:User')->find($id); 
        //  on donne le chemin et le nom du fichier pdf
            $array_month = array('', 'Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre', 'Novembre', 'Decembre');
            $uploads_dir = $this->getRequest()->server->get('DOCUMENT_ROOT').'/uploads/fiche-paie/';
            $name = $uploads_dir.'Facture-'.$user->getUsername().'-'.$array_month[date('n')].'-'.date('Y').'.pdf';
        //  on sauvegarde le fichier pdf
            $f=fopen($name,'wb');
            if(!$f) throw $this->createNotFoundException('Unable to create output file: '.$name); 
            fwrite($f,$pdfGenerator->generatePDF($html),strlen($pdfGenerator->generatePDF($html)));
            fclose($f);
        //  Récupération du service pour l'envoi du mail
            $mailer = $this->get('mailer');
        //  Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message
            $webmaster_name = $this->container->getParameter('webmaster_name');
            $webmaster_email = $this->container->getParameter('webmaster_email');
            
            $message = \Swift_Message::newInstance()
            ->setSubject('Votre fiche de paie de '.$array_month[date('n')].'-'.date('Y').' !')
            ->setFrom( array( $webmaster_email => $webmaster_name ) )
            ->setTo( array( $user->getEmail() => $user->getNom().' '.$user->getPrenom() ) )
            ->setBody('Bonjour Monsieur')
            ->attach(Swift_Attachment::fromPath($name));
        // Retour au service mailer, nous utilisons sa méthode « send()» pour envoyer notre $message
            $mailer->send($message);
            return new Response('Email bien envoyé');
        endif;
       
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
}

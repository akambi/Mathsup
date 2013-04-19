<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;


use Msp\FrontendBundle\Entity\Conference;
use Msp\FrontendBundle\Entity\ConferenceLog;
use Msp\FrontendBundle\Entity\UserGoConference;

use Symfony\Component\HttpFoundation\Session\Session;

class BigBlueButtonHandler 
{
    protected $form;
    protected $request;
    protected $em;
    protected $container;    
    protected $error;
    
    public function __construct(Form $form, Request $request, EntityManager $em, $container)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
        $this->container = $container;        
    }
    
    public function process()
    {
        if( $this->request->getMethod() == 'POST' )
        {
            $this->form->bindRequest($this->request);
            if( $this->form->isValid() )
            {
                $this->onSuccess($this->form->getData());
                return true;
            }
        }
        return false;
    }
    
    public function onSuccess( $data )
    {
    //  On définit ici les services qu'on va utiliser
        $container = $this->container;
        $BigBlueButton = $container->get('msp_frontend.bigbluebutton');
        $router = $container->get('router');
        $user = $container->get('security.context')->getToken()->getUser();
    //  On défini ici les variables
        $userName = $user->getPrenom()." ".$user->getNom();        
        $titre = $data["titre"];
        $password = $data["motdepasse"];
    //  On défini ici les repositories
        $repository = $this->em->getRepository('MspFrontendBundle:Conference');
        $repositoryLog = $this->em->getRepository('MspFrontendBundle:ConferenceLog');
        $conference = $repository->findOneByMeetingName( $titre );
        
        if (!$conference) {
            return $this->error = "Aucune conférence pour ce titre";
        }
        
        if (!$this->hasGiveCorrectPassword( $password, array( $conference->getModeratorPW(), $conference->getAttendeePW()) ) ) {
            return $this->error = "Le mot de passe est incorrecte";
        }
        
        define('BIGBLUEBUTTON_STRING_WELCOME', '<br>Bienvenu <b>%%CONFNAME%%</b>!<br><br>Pour comprendre comment fonctionne BigBlueButton voir les <a href="event:http://www.bigbluebutton.org/content/videos"><u>tutoriaux videos</u></a>.<br><br>Pour rejoindre le pont audio cliquez sur l\'icône du casque (coin supérieur gauche). <b>Veuillez utiliser un casque pour éviter de causer du bruit pour les autres.</b>');
        
        $url_val =  $container->getParameter('bigbluebutton_url');
        $salt_val = $container->getParameter('bigbluebutton_salt');
        $website_name = $container->getParameter('website_name');
        
        $welcome = BIGBLUEBUTTON_STRING_WELCOME;
        $recorded = $conference->getRecorded();
        $duration = 0;
        $voicebridge = 0;
        $logouturl = $router->generate("msp_frontend_homepage", array(), true);

        //Metadata for tagging recordings
        $metadata = Array(
            'meta_origin' => 'WordPress',
            'meta_originversion' => '3.5',
            'meta_origintag' => 'wp_plugin-bigbluebutton '.'1.3.3',
            'meta_originservername' => $logouturl,
            'meta_originservercommonname' => $website_name,
            'meta_originurl' => $logouturl
        );        
        //  On crée la conférence
        $response = $BigBlueButton->createMeetingArray($userName, $conference->getMeetingID(), $conference->getMeetingName(), $welcome, $conference->getModeratorPW(), $conference->getAttendeePW(), $salt_val, $url_val, $logouturl, $recorded? 'true':'false', $duration, $voicebridge, $metadata );
        if(!$response || $response['returncode'] == 'FAILED' )
        {//Si le serveur est inaccessible, ou une erreur est survenue           
            return $this->error = "Désolé, un problème est survenu lors de la connexion à la conférence";
        } else{
            if( !isset($response['messageKey']) || $response['messageKey'] == '' ){
                // La conférence vient juste d'être créée, insérez l'événement créez le journal
                $conferenceLog = $repositoryLog->findOneByConference( $conference );
                if (!$conferenceLog) {
                    $conferenceLog = new ConferenceLog();
                    $conferenceLog->setRecorded( $recorded );
                    $conferenceLog->setTimetamp( time() );
                    $conferenceLog->setEvent("Create");
                    $conferenceLog->setConference($conference);

                    $this->em->persist($conferenceLog);
                    $this->em->flush();
                }
            } 
            
            $bigbluebutton_joinURL = $BigBlueButton->getJoinURL($conference->getMeetingID(), $userName, $password, $salt_val, $url_val );
            //Si l'option d'attente du modérateur est à false, redirigé l'utilisateur vers la vidéoconférence            
            if ( ($BigBlueButton->isMeetingRunning( $conference->getMeetingID(), $url_val, $salt_val ) && ($conference->getModeratorPW() == $password || $conference->getAttendeePW() == $password ) )
                    || $response['moderatorPW'] == $password
                    || ($response['attendeePW'] == $password && !$conference->getWaitForModerator())  ){
                //Si le mot de passe est exact, l'utilisateur est redirigé
                echo '<script type="text/javascript">window.location = "'.$bigbluebutton_joinURL.'";</script>'."\n";
                return;
            }
            //Si le spectateur a le mot de passe correct, mais la réunion n'a pas encore commencé, ils doivent 
            //attendre le modérateur pour commencer la séance
            else if ($conference->getAttendeePW() == $password){
            //On stocke les configuration du serveur bigblubutton  en session                
                $session = new Session();
                $session->start();

                $session->set('mt_bbb_url', $url_val);
                $session->set('mt_salt', $salt_val);                
            //Affiche le javascript pour rediriger automatiquement l'utilisateur lorsque la conférence commence
                $BigBlueButton->bigbluebutton_display_redirect_script($bigbluebutton_joinURL, $conference->getMeetingID(), $conference->getMeetingName(), $userName);
                return;
            }            
        }        
        
    }
    
    public function getError()
    {
        return $this->error;
    }
    
    public function hasGiveCorrectPassword( $pass, $refered = array() )
    {
        foreach ($refered as $value) {
            if( $pass === $value):
                return true;
            endif;
        }
        return false;
    }
}

?>
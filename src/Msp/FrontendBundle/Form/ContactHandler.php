<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class ContactHandler 
{
    protected $form;
    protected $request;
    protected $container;
    
    public function __construct(Form $form, Request $request, $container)
    {
        $this->form = $form;
        $this->request = $request;
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
    
    public function onSuccess( $data)
    {      
    //  Récupération du service pour l'envoi du mail
        $mailer = $this->container->get('mailer');
    //  Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message
        $webmaster_name = $this->container->getParameter('webmaster_name');
        $webmaster_email = $this->container->getParameter('webmaster_email');
        
        $message = \Swift_Message::newInstance()
        ->setSubject($data["objet"])
        ->setFrom( array( $data["email"] => $data["nom"]) )
        ->setTo( array( $webmaster_email => $webmaster_name ) )
        ->setBody( nl2br($data["message"]).'<br/>Téléphone: '.$data["telephone"] )
        ->setContentType( 'text/html' );
    // Retour au service mailer, nous utilisons sa méthode « send()» pour envoyer notre $message
        $mailer->send($message);
        
        return true;
    }
}

?>
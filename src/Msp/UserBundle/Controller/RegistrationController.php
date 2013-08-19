<?php

namespace Msp\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserInterface;
use Msp\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationController extends BaseController
{   
    public function registerEleveAction()
    {
        $eleve = new User(); // Your form data class. Has to be an object, won't work properly with an array.

        $flow = $this->container->get('msp_frontend.form.flow.registrationEleve'); // must match the flow's service id
        $flow->bind($eleve);     
        
        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->container->get('doctrine')->getManager();            
            //  On définit le rôle de l'agent
                $roles = array('ROLE_ELEVE');
                $eleve->setRoles($roles);
            //  On autorise l'utilisateur à se connecter
                $eleve->setConfirmationToken(null);
                $eleve->setEnabled(true);
                $eleve->setLastLogin(new \DateTime());
                //var_dump($eleve);
                //exit();
            //  On enregistre l'utilisateur
                $em->persist($eleve);
                $em->flush();

                $authUser = true;
                $route = 'fos_user_registration_confirmed';
                $this->setFlash('fos_user_success', 'registration.flash.user_created');
                $url = $this->container->get('router')->generate($route);
                $response = new RedirectResponse($url);

                if ($authUser) {
                    $this->authenticateUser($eleve, $response);
                }
            //  On supprime les variables sessions
                $flow->reset();
                
                return $response;
            }
        }        

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register_eleve.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }
    
    /*public function authenticateUser(UserInterface $user, Response $response)
    {
        return;
    } */
}

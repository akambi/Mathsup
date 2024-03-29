<?php

namespace Msp\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserInterface;
use Msp\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Msp\FrontendBundle\Entity\Log;

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
            //  On enregistre le choix du pack et du cours dans le log
                $cours = $em->getRepository('MspFrontendBundle:Cours')->find($eleve->cours);
                $log = new Log();
                $log->setUser($eleve);
                $log->setInfo('Pack '.$eleve->pack.'H - '.$cours);
                //var_dump($log);
                //exit();
            //  On enregistre l'utilisateur
                $em->persist($eleve);
                $em->persist($log);
                $em->flush();

                $authUser = false;
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
    
     public function registerProfesseurAction()
    {
        $professeur = new User(); // Your form data class. Has to be an object, won't work properly with an array.

        $flow = $this->container->get('msp_frontend.form.flow.registrationProfesseur'); // must match the flow's service id
        $flow->bind($professeur);     
        
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
                $roles = array('ROLE_PROFESSEUR');
                $professeur->setRoles($roles);
            //  On autorise l'utilisateur à se connecter
                $professeur->setConfirmationToken(null);
                $professeur->setEnabled(true);
                $professeur->setLastLogin(new \DateTime());            
                //var_dump($log);
                //exit();
            //  On enregistre l'utilisateur
                $em->persist($professeur);                
                $em->flush();

                $authUser = false;
                $route = 'fos_user_registration_confirmed';
                $this->setFlash('fos_user_success', 'registration.flash.user_created');
                $url = $this->container->get('router')->generate($route);
                $response = new RedirectResponse($url);

                if ($authUser) {
                    $this->authenticateUser($professeur, $response);
                }
            //  On supprime les variables sessions
                $flow->reset();
                
                return $response;
            }
        }        

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register_professeur.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }
    
    /*public function authenticateUser(UserInterface $user, Response $response)
    {
        return;
    } */
}

<?php

namespace Msp\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserInterface;

class RegistrationController extends BaseController
{   
    public function authenticateUser(UserInterface $user, Response $response)
    {
        return;
    }    
}

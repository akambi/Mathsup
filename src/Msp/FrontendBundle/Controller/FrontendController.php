<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
    public function indexAction()
    {
        return $this->render('MspFrontendBundle:Default:index.html.twig');
    }
}

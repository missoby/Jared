<?php

namespace Nzo\JaredBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;

class FrontController extends Controller
{    
    public function indexAction()
    {    
        $user = $this->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
             return $this->render('NzoJaredBundle:Front:index.html.twig');
        }
        else
        {
            return $this->render('NzoJaredBundle:Users:index.html.twig');
        }       
           
    }
}

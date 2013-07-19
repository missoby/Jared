<?php

namespace Nzo\JaredBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException(); // route et pas template 
        }        
        else if ($this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->render('NzoJaredBundle:Users:index.html.twig');
        }
        else
            return $this->redirect($this->generateUrl('fos_user_security_login')); 
    }
}

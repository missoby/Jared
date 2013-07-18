<?php

namespace Nzo\JaredBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {
        return $this->render('NzoJaredBundle:Users:index.html.twig');
    }
}

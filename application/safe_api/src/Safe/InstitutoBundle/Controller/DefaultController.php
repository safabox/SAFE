<?php

namespace Safe\InstitutoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeInstitutoBundle:Default:index.html.twig');
    }
}

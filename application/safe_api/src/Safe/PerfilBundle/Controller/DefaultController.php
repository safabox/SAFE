<?php

namespace Safe\PerfilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafePerfilBundle:Default:index.html.twig');
    }
}

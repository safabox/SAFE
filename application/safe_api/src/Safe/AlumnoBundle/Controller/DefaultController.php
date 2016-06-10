<?php

namespace Safe\AlumnoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeAlumnoBundle:Default:index.html.twig');
    }
}

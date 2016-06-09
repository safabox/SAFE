<?php

namespace Safe\EstudianteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeEstudianteBundle:Default:index.html.twig');
    }
}

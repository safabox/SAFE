<?php

namespace Safe\CursoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeCursoBundle:Default:index.html.twig');
    }
}

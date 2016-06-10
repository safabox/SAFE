<?php

namespace Safe\DocenteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeDocenteBundle:Default:index.html.twig');
    }
}

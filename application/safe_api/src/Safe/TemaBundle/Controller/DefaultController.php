<?php

namespace Safe\TemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeTemaBundle:Default:index.html.twig');
    }
}

<?php

namespace Safe\CatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeCatBundle:Default:index.html.twig');
    }
}

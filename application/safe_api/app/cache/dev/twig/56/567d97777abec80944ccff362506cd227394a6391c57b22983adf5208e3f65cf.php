<?php

/* @Twig/Exception/error.atom.twig */
class __TwigTemplate_48b1da02ea868f684ef170d63defeae108bf2d8f6964578e1022022bfca9badd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_eb8b2500d01b612573e09eb6d8b38a52c85a844976aeae7c7ce8d51edf96a548 = $this->env->getExtension("native_profiler");
        $__internal_eb8b2500d01b612573e09eb6d8b38a52c85a844976aeae7c7ce8d51edf96a548->enter($__internal_eb8b2500d01b612573e09eb6d8b38a52c85a844976aeae7c7ce8d51edf96a548_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/error.atom.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/error.xml.twig", "@Twig/Exception/error.atom.twig", 1)->display($context);
        
        $__internal_eb8b2500d01b612573e09eb6d8b38a52c85a844976aeae7c7ce8d51edf96a548->leave($__internal_eb8b2500d01b612573e09eb6d8b38a52c85a844976aeae7c7ce8d51edf96a548_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/error.atom.twig";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* {% include '@Twig/Exception/error.xml.twig' %}*/
/* */

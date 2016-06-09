<?php

/* TwigBundle:Exception:error.rdf.twig */
class __TwigTemplate_bc1e2a8d5ca41db997b2fa54ae02e19646396528d0abf214dcc6852909767cda extends Twig_Template
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
        $__internal_97e4b95c8f778187569c27171bfc480d4e1637ea2bcc1077972bca510d24d82d = $this->env->getExtension("native_profiler");
        $__internal_97e4b95c8f778187569c27171bfc480d4e1637ea2bcc1077972bca510d24d82d->enter($__internal_97e4b95c8f778187569c27171bfc480d4e1637ea2bcc1077972bca510d24d82d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:error.rdf.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/error.xml.twig", "TwigBundle:Exception:error.rdf.twig", 1)->display($context);
        
        $__internal_97e4b95c8f778187569c27171bfc480d4e1637ea2bcc1077972bca510d24d82d->leave($__internal_97e4b95c8f778187569c27171bfc480d4e1637ea2bcc1077972bca510d24d82d_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.rdf.twig";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* {% include '@Twig/Exception/error.xml.twig' %}*/
/* */

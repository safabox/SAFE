<?php

/* TwigBundle:Exception:exception.atom.twig */
class __TwigTemplate_ea5c5e6119bcbadcceea981f4f73490d657da898622fc878d1be8f6d45b5e83e extends Twig_Template
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
        $__internal_0d15ceac1596c6d5e49ed5d6063f886c8fe0fb6857739969e8250d8f0ea2d798 = $this->env->getExtension("native_profiler");
        $__internal_0d15ceac1596c6d5e49ed5d6063f886c8fe0fb6857739969e8250d8f0ea2d798->enter($__internal_0d15ceac1596c6d5e49ed5d6063f886c8fe0fb6857739969e8250d8f0ea2d798_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception.atom.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/exception.xml.twig", "TwigBundle:Exception:exception.atom.twig", 1)->display(array_merge($context, array("exception" => (isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")))));
        
        $__internal_0d15ceac1596c6d5e49ed5d6063f886c8fe0fb6857739969e8250d8f0ea2d798->leave($__internal_0d15ceac1596c6d5e49ed5d6063f886c8fe0fb6857739969e8250d8f0ea2d798_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception.atom.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* {% include '@Twig/Exception/exception.xml.twig' with { 'exception': exception } %}*/
/* */

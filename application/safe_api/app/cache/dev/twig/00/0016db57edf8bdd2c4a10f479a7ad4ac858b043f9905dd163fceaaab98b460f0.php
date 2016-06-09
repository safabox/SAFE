<?php

/* TwigBundle:Exception:exception.rdf.twig */
class __TwigTemplate_f728743c5b9b68a72ac22f9f9d16ec6707bb251d1d8b3261769dca3a76385315 extends Twig_Template
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
        $__internal_25a12bae5467cee5d1664c731b556851c01079cb2bcf47969f5d888be002aaf0 = $this->env->getExtension("native_profiler");
        $__internal_25a12bae5467cee5d1664c731b556851c01079cb2bcf47969f5d888be002aaf0->enter($__internal_25a12bae5467cee5d1664c731b556851c01079cb2bcf47969f5d888be002aaf0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception.rdf.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/exception.xml.twig", "TwigBundle:Exception:exception.rdf.twig", 1)->display(array_merge($context, array("exception" => (isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")))));
        
        $__internal_25a12bae5467cee5d1664c731b556851c01079cb2bcf47969f5d888be002aaf0->leave($__internal_25a12bae5467cee5d1664c731b556851c01079cb2bcf47969f5d888be002aaf0_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception.rdf.twig";
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

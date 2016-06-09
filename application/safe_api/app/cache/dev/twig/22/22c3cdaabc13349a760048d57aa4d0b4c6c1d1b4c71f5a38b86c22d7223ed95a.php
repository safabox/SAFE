<?php

/* TwigBundle:Exception:exception.css.twig */
class __TwigTemplate_92ae1cde28969f20b909a6c55f2b331e9f69f44aa75ab3dfe7fc68850ec8315d extends Twig_Template
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
        $__internal_b4d209e48643e5d50e1caf9b8d8d582e480d27f864d4fb1606c800a9c13534dc = $this->env->getExtension("native_profiler");
        $__internal_b4d209e48643e5d50e1caf9b8d8d582e480d27f864d4fb1606c800a9c13534dc->enter($__internal_b4d209e48643e5d50e1caf9b8d8d582e480d27f864d4fb1606c800a9c13534dc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception.css.twig"));

        // line 1
        echo "/*
";
        // line 2
        $this->loadTemplate("@Twig/Exception/exception.txt.twig", "TwigBundle:Exception:exception.css.twig", 2)->display(array_merge($context, array("exception" => (isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")))));
        // line 3
        echo "*/
";
        
        $__internal_b4d209e48643e5d50e1caf9b8d8d582e480d27f864d4fb1606c800a9c13534dc->leave($__internal_b4d209e48643e5d50e1caf9b8d8d582e480d27f864d4fb1606c800a9c13534dc_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception.css.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 3,  25 => 2,  22 => 1,);
    }
}
/* /**/
/* {% include '@Twig/Exception/exception.txt.twig' with { 'exception': exception } %}*/
/* *//* */
/* */

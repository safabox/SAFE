<?php

/* @Twig/Exception/exception.css.twig */
class __TwigTemplate_542ddb2731e5d2d849f82c2de8add604d04aeb83fe173186619404da208faa0d extends Twig_Template
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
        $__internal_45338d18d1b5d87de711209e8c16fedc4c2ca6622726c24727aa67a67d14d7fc = $this->env->getExtension("native_profiler");
        $__internal_45338d18d1b5d87de711209e8c16fedc4c2ca6622726c24727aa67a67d14d7fc->enter($__internal_45338d18d1b5d87de711209e8c16fedc4c2ca6622726c24727aa67a67d14d7fc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.css.twig"));

        // line 1
        echo "/*
";
        // line 2
        $this->loadTemplate("@Twig/Exception/exception.txt.twig", "@Twig/Exception/exception.css.twig", 2)->display(array_merge($context, array("exception" => (isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")))));
        // line 3
        echo "*/
";
        
        $__internal_45338d18d1b5d87de711209e8c16fedc4c2ca6622726c24727aa67a67d14d7fc->leave($__internal_45338d18d1b5d87de711209e8c16fedc4c2ca6622726c24727aa67a67d14d7fc_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception.css.twig";
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

<?php

/* @Twig/Exception/exception.js.twig */
class __TwigTemplate_d9e6b2b26f36b609648c863160604fedb85e266ccfd712ea7fbb8f200ae59ce2 extends Twig_Template
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
        $__internal_f9de0980ac496ae47828cc3835e59ed020ab03819b9b2876d6fae0e667e18326 = $this->env->getExtension("native_profiler");
        $__internal_f9de0980ac496ae47828cc3835e59ed020ab03819b9b2876d6fae0e667e18326->enter($__internal_f9de0980ac496ae47828cc3835e59ed020ab03819b9b2876d6fae0e667e18326_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.js.twig"));

        // line 1
        echo "/*
";
        // line 2
        $this->loadTemplate("@Twig/Exception/exception.txt.twig", "@Twig/Exception/exception.js.twig", 2)->display(array_merge($context, array("exception" => (isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")))));
        // line 3
        echo "*/
";
        
        $__internal_f9de0980ac496ae47828cc3835e59ed020ab03819b9b2876d6fae0e667e18326->leave($__internal_f9de0980ac496ae47828cc3835e59ed020ab03819b9b2876d6fae0e667e18326_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception.js.twig";
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

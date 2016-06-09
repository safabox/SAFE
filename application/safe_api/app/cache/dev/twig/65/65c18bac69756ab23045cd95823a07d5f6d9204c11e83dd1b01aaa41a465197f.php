<?php

/* @Twig/Exception/exception.atom.twig */
class __TwigTemplate_7c4514c1301634dd428e6ef092a4e10de8535d4049f1fcf418631d58284ec3ca extends Twig_Template
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
        $__internal_97f843a03b7d16013338db9a76deb89b5e65751026cfe833756eaf057ef19a92 = $this->env->getExtension("native_profiler");
        $__internal_97f843a03b7d16013338db9a76deb89b5e65751026cfe833756eaf057ef19a92->enter($__internal_97f843a03b7d16013338db9a76deb89b5e65751026cfe833756eaf057ef19a92_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.atom.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/exception.xml.twig", "@Twig/Exception/exception.atom.twig", 1)->display(array_merge($context, array("exception" => (isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")))));
        
        $__internal_97f843a03b7d16013338db9a76deb89b5e65751026cfe833756eaf057ef19a92->leave($__internal_97f843a03b7d16013338db9a76deb89b5e65751026cfe833756eaf057ef19a92_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception.atom.twig";
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

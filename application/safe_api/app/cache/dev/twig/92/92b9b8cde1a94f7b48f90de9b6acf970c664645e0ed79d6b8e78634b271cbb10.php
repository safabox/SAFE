<?php

/* @Twig/Exception/error.js.twig */
class __TwigTemplate_da56c268ec19d21cf4bd878efb08563c301a4fba3bd78abe55cadd284f489bba extends Twig_Template
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
        $__internal_410d75de0397a3881fb0c50154d3edb535033251d3d9a3ca8121bc2f1710c140 = $this->env->getExtension("native_profiler");
        $__internal_410d75de0397a3881fb0c50154d3edb535033251d3d9a3ca8121bc2f1710c140->enter($__internal_410d75de0397a3881fb0c50154d3edb535033251d3d9a3ca8121bc2f1710c140_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/error.js.twig"));

        // line 1
        echo "/*
";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "js", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "js", null, true);
        echo "

*/
";
        
        $__internal_410d75de0397a3881fb0c50154d3edb535033251d3d9a3ca8121bc2f1710c140->leave($__internal_410d75de0397a3881fb0c50154d3edb535033251d3d9a3ca8121bc2f1710c140_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/error.js.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  25 => 2,  22 => 1,);
    }
}
/* /**/
/* {{ status_code }} {{ status_text }}*/
/* */
/* *//* */
/* */

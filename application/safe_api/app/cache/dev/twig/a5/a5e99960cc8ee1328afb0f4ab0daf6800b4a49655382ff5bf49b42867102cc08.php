<?php

/* @Twig/Exception/exception.rdf.twig */
class __TwigTemplate_53b20ca83a73d326e0f9180bc2d3a9461ae841ec1fce40e30f2f9264edff43f9 extends Twig_Template
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
        $__internal_dc0ba93e52551bbeb560534247ef4a69a7ebdf5f409d918ebbcd80c8f16777f4 = $this->env->getExtension("native_profiler");
        $__internal_dc0ba93e52551bbeb560534247ef4a69a7ebdf5f409d918ebbcd80c8f16777f4->enter($__internal_dc0ba93e52551bbeb560534247ef4a69a7ebdf5f409d918ebbcd80c8f16777f4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.rdf.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/exception.xml.twig", "@Twig/Exception/exception.rdf.twig", 1)->display(array_merge($context, array("exception" => (isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")))));
        
        $__internal_dc0ba93e52551bbeb560534247ef4a69a7ebdf5f409d918ebbcd80c8f16777f4->leave($__internal_dc0ba93e52551bbeb560534247ef4a69a7ebdf5f409d918ebbcd80c8f16777f4_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception.rdf.twig";
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

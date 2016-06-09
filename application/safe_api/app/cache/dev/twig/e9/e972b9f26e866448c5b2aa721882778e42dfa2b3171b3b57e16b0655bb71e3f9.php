<?php

/* @Twig/Exception/error.rdf.twig */
class __TwigTemplate_81c1a04d37614ecf025966df7069a11845feb2cdb42926af2e44065e378ea717 extends Twig_Template
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
        $__internal_21553a9395fdbb3a33fa13ac7648fa446e7108fa11e6afacd637cf927f7eac75 = $this->env->getExtension("native_profiler");
        $__internal_21553a9395fdbb3a33fa13ac7648fa446e7108fa11e6afacd637cf927f7eac75->enter($__internal_21553a9395fdbb3a33fa13ac7648fa446e7108fa11e6afacd637cf927f7eac75_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/error.rdf.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/error.xml.twig", "@Twig/Exception/error.rdf.twig", 1)->display($context);
        
        $__internal_21553a9395fdbb3a33fa13ac7648fa446e7108fa11e6afacd637cf927f7eac75->leave($__internal_21553a9395fdbb3a33fa13ac7648fa446e7108fa11e6afacd637cf927f7eac75_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/error.rdf.twig";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* {% include '@Twig/Exception/error.xml.twig' %}*/
/* */

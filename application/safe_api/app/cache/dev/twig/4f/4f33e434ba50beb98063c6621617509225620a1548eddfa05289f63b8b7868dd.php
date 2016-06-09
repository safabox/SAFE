<?php

/* @Twig/Exception/error.json.twig */
class __TwigTemplate_4fb3fb6d9288c9213fb6852c385ecd5e7778f2b3dba2b75c845aae74e5c6b250 extends Twig_Template
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
        $__internal_ac63659009be96ddf1473d61767311e5bf0b051b942f8ff9ed598598ad656b74 = $this->env->getExtension("native_profiler");
        $__internal_ac63659009be96ddf1473d61767311e5bf0b051b942f8ff9ed598598ad656b74->enter($__internal_ac63659009be96ddf1473d61767311e5bf0b051b942f8ff9ed598598ad656b74_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/error.json.twig"));

        // line 1
        echo twig_jsonencode_filter(array("error" => array("code" => (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "message" => (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")))));
        echo "
";
        
        $__internal_ac63659009be96ddf1473d61767311e5bf0b051b942f8ff9ed598598ad656b74->leave($__internal_ac63659009be96ddf1473d61767311e5bf0b051b942f8ff9ed598598ad656b74_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/error.json.twig";
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
/* {{ { 'error': { 'code': status_code, 'message': status_text } }|json_encode|raw }}*/
/* */

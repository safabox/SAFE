<?php

/* TwigBundle:Exception:exception.json.twig */
class __TwigTemplate_e5722a496a6208570797379c2901bb30cd5b71a8883d1c0dc68f19eff06c1f4d extends Twig_Template
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
        $__internal_2b7894daf4c4fda7bb91440dd3ead86cfc52620f0657e1138b426682da0283ad = $this->env->getExtension("native_profiler");
        $__internal_2b7894daf4c4fda7bb91440dd3ead86cfc52620f0657e1138b426682da0283ad->enter($__internal_2b7894daf4c4fda7bb91440dd3ead86cfc52620f0657e1138b426682da0283ad_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception.json.twig"));

        // line 1
        echo twig_jsonencode_filter(array("error" => array("code" => (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "message" => (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "exception" => $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "toarray", array()))));
        echo "
";
        
        $__internal_2b7894daf4c4fda7bb91440dd3ead86cfc52620f0657e1138b426682da0283ad->leave($__internal_2b7894daf4c4fda7bb91440dd3ead86cfc52620f0657e1138b426682da0283ad_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception.json.twig";
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
/* {{ { 'error': { 'code': status_code, 'message': status_text, 'exception': exception.toarray } }|json_encode|raw }}*/
/* */

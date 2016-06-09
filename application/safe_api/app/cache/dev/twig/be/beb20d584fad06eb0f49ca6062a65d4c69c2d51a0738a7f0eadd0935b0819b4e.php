<?php

/* TwigBundle:Exception:error.json.twig */
class __TwigTemplate_b265db2f63dfff11215d9bb9c654ca8ea99320bd2e63216edea43ee83da814b6 extends Twig_Template
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
        $__internal_4f800066ca84ae8962e6498db714c13d86d0bfe52398b42063f84f644e35f7a4 = $this->env->getExtension("native_profiler");
        $__internal_4f800066ca84ae8962e6498db714c13d86d0bfe52398b42063f84f644e35f7a4->enter($__internal_4f800066ca84ae8962e6498db714c13d86d0bfe52398b42063f84f644e35f7a4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:error.json.twig"));

        // line 1
        echo twig_jsonencode_filter(array("error" => array("code" => (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "message" => (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")))));
        echo "
";
        
        $__internal_4f800066ca84ae8962e6498db714c13d86d0bfe52398b42063f84f644e35f7a4->leave($__internal_4f800066ca84ae8962e6498db714c13d86d0bfe52398b42063f84f644e35f7a4_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.json.twig";
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

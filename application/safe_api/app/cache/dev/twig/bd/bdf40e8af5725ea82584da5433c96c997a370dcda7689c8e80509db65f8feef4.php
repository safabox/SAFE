<?php

/* TwigBundle:Exception:error.js.twig */
class __TwigTemplate_2fe20defbd0c191246f2548908097a70898c777714809814bd62e21db71ad06a extends Twig_Template
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
        $__internal_7a89e4fb53d6b7686116e0d056f817402d564cba8dbeafcd6d20ea641668cd1c = $this->env->getExtension("native_profiler");
        $__internal_7a89e4fb53d6b7686116e0d056f817402d564cba8dbeafcd6d20ea641668cd1c->enter($__internal_7a89e4fb53d6b7686116e0d056f817402d564cba8dbeafcd6d20ea641668cd1c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:error.js.twig"));

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
        
        $__internal_7a89e4fb53d6b7686116e0d056f817402d564cba8dbeafcd6d20ea641668cd1c->leave($__internal_7a89e4fb53d6b7686116e0d056f817402d564cba8dbeafcd6d20ea641668cd1c_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.js.twig";
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

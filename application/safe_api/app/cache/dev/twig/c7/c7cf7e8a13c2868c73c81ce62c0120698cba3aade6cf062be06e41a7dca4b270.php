<?php

/* @NelmioApiDoc/Components/version.html.twig */
class __TwigTemplate_5bb9cdd16d750a64289cca04334fd20730e0a616b879a78a6fd7ec68155de380 extends Twig_Template
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
        $__internal_99535508ded60941ab0c7917de06615e761c207846107f2ba60917484384a2ca = $this->env->getExtension("native_profiler");
        $__internal_99535508ded60941ab0c7917de06615e761c207846107f2ba60917484384a2ca->enter($__internal_99535508ded60941ab0c7917de06615e761c207846107f2ba60917484384a2ca_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@NelmioApiDoc/Components/version.html.twig"));

        // line 1
        if ((twig_test_empty((isset($context["sinceVersion"]) ? $context["sinceVersion"] : $this->getContext($context, "sinceVersion"))) && twig_test_empty((isset($context["untilVersion"]) ? $context["untilVersion"] : $this->getContext($context, "untilVersion"))))) {
            // line 2
            echo "*
";
        } else {
            // line 4
            echo "    ";
            if ( !twig_test_empty((isset($context["sinceVersion"]) ? $context["sinceVersion"] : $this->getContext($context, "sinceVersion")))) {
                echo "&gt;=";
                echo twig_escape_filter($this->env, (isset($context["sinceVersion"]) ? $context["sinceVersion"] : $this->getContext($context, "sinceVersion")), "html", null, true);
            }
            // line 5
            echo "    ";
            if ( !twig_test_empty((isset($context["untilVersion"]) ? $context["untilVersion"] : $this->getContext($context, "untilVersion")))) {
                // line 6
                echo "        ";
                if ( !twig_test_empty((isset($context["sinceVersion"]) ? $context["sinceVersion"] : $this->getContext($context, "sinceVersion")))) {
                    echo ",";
                }
                echo "&lt;=";
                echo twig_escape_filter($this->env, (isset($context["untilVersion"]) ? $context["untilVersion"] : $this->getContext($context, "untilVersion")), "html", null, true);
                echo "
    ";
            }
        }
        
        $__internal_99535508ded60941ab0c7917de06615e761c207846107f2ba60917484384a2ca->leave($__internal_99535508ded60941ab0c7917de06615e761c207846107f2ba60917484384a2ca_prof);

    }

    public function getTemplateName()
    {
        return "@NelmioApiDoc/Components/version.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  37 => 6,  34 => 5,  28 => 4,  24 => 2,  22 => 1,);
    }
}
/* {% if sinceVersion is empty and untilVersion is empty %}*/
/* **/
/* {% else %}*/
/*     {% if sinceVersion is not empty %}&gt;={{ sinceVersion }}{% endif %}*/
/*     {% if untilVersion is not empty %}*/
/*         {% if sinceVersion is not empty %},{% endif %}&lt;={{ untilVersion }}*/
/*     {% endif %}*/
/* {% endif %}*/
/* */

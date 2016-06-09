<?php

/* TwigBundle:Exception:exception.js.twig */
class __TwigTemplate_293e9a11c0da1c42a7ce3adae3f2366d11c882daec85e8af9644fec113a003cf extends Twig_Template
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
        $__internal_1c7b1b4b1de02be7bb4e61e69b094ed63348da28e03d6b6a945b4c6a3e91d39a = $this->env->getExtension("native_profiler");
        $__internal_1c7b1b4b1de02be7bb4e61e69b094ed63348da28e03d6b6a945b4c6a3e91d39a->enter($__internal_1c7b1b4b1de02be7bb4e61e69b094ed63348da28e03d6b6a945b4c6a3e91d39a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception.js.twig"));

        // line 1
        echo "/*
";
        // line 2
        $this->loadTemplate("@Twig/Exception/exception.txt.twig", "TwigBundle:Exception:exception.js.twig", 2)->display(array_merge($context, array("exception" => (isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")))));
        // line 3
        echo "*/
";
        
        $__internal_1c7b1b4b1de02be7bb4e61e69b094ed63348da28e03d6b6a945b4c6a3e91d39a->leave($__internal_1c7b1b4b1de02be7bb4e61e69b094ed63348da28e03d6b6a945b4c6a3e91d39a_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception.js.twig";
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

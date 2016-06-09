<?php

/* @Twig/Exception/error.css.twig */
class __TwigTemplate_1490a8f6c5f2ab4b1cd63fead2df3917339afd0e76800f773c5d3ef0794d2276 extends Twig_Template
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
        $__internal_a4ae71064aceb30743dfbbb3a3b96d0288803498ad3951e90a81e2f4180fa4b0 = $this->env->getExtension("native_profiler");
        $__internal_a4ae71064aceb30743dfbbb3a3b96d0288803498ad3951e90a81e2f4180fa4b0->enter($__internal_a4ae71064aceb30743dfbbb3a3b96d0288803498ad3951e90a81e2f4180fa4b0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/error.css.twig"));

        // line 1
        echo "/*
";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "css", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "css", null, true);
        echo "

*/
";
        
        $__internal_a4ae71064aceb30743dfbbb3a3b96d0288803498ad3951e90a81e2f4180fa4b0->leave($__internal_a4ae71064aceb30743dfbbb3a3b96d0288803498ad3951e90a81e2f4180fa4b0_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/error.css.twig";
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

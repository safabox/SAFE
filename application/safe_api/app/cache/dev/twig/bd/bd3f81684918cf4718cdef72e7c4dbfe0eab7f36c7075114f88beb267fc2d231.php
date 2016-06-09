<?php

/* TwigBundle:Exception:error.css.twig */
class __TwigTemplate_a6820699f066fdd5d2775b53d4e4d8423eaf2f7235eac47c9d9037cfb73acc51 extends Twig_Template
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
        $__internal_300ffacf864d6df2a0fb3b598ed48879c82e2fce871871152736af2f87f759a9 = $this->env->getExtension("native_profiler");
        $__internal_300ffacf864d6df2a0fb3b598ed48879c82e2fce871871152736af2f87f759a9->enter($__internal_300ffacf864d6df2a0fb3b598ed48879c82e2fce871871152736af2f87f759a9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:error.css.twig"));

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
        
        $__internal_300ffacf864d6df2a0fb3b598ed48879c82e2fce871871152736af2f87f759a9->leave($__internal_300ffacf864d6df2a0fb3b598ed48879c82e2fce871871152736af2f87f759a9_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.css.twig";
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

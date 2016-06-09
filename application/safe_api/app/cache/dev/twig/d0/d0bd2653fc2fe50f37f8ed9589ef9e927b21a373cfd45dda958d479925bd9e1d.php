<?php

/* @Twig/Exception/error.txt.twig */
class __TwigTemplate_1bf9f824a5b0eb9864b63e9f574a51044b6b21bba1b8566dcb9c298e6afe2493 extends Twig_Template
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
        $__internal_f2ae36c5e137ffd8c66cf4561c52a2f5e0c3733fafd59ec2ca4b0b826c2f7a1a = $this->env->getExtension("native_profiler");
        $__internal_f2ae36c5e137ffd8c66cf4561c52a2f5e0c3733fafd59ec2ca4b0b826c2f7a1a->enter($__internal_f2ae36c5e137ffd8c66cf4561c52a2f5e0c3733fafd59ec2ca4b0b826c2f7a1a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/error.txt.twig"));

        // line 1
        echo "Oops! An Error Occurred
=======================

The server returned a \"";
        // line 4
        echo (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code"));
        echo " ";
        echo (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text"));
        echo "\".

Something is broken. Please let us know what you were doing when this error occurred.
We will fix it as soon as possible. Sorry for any inconvenience caused.
";
        
        $__internal_f2ae36c5e137ffd8c66cf4561c52a2f5e0c3733fafd59ec2ca4b0b826c2f7a1a->leave($__internal_f2ae36c5e137ffd8c66cf4561c52a2f5e0c3733fafd59ec2ca4b0b826c2f7a1a_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/error.txt.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 4,  22 => 1,);
    }
}
/* Oops! An Error Occurred*/
/* =======================*/
/* */
/* The server returned a "{{ status_code }} {{ status_text }}".*/
/* */
/* Something is broken. Please let us know what you were doing when this error occurred.*/
/* We will fix it as soon as possible. Sorry for any inconvenience caused.*/
/* */

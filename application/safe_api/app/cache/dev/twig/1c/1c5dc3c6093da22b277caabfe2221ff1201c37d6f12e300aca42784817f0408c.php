<?php

/* TwigBundle:Exception:error.txt.twig */
class __TwigTemplate_8866ef40ca2b4bf96838780d0d65a55d7e1d39716a0cde098466b5ac3fe48b91 extends Twig_Template
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
        $__internal_a3143c1387000048c194aad0ba25a4beb02460347e05a0a28e8460a45c9ae9bb = $this->env->getExtension("native_profiler");
        $__internal_a3143c1387000048c194aad0ba25a4beb02460347e05a0a28e8460a45c9ae9bb->enter($__internal_a3143c1387000048c194aad0ba25a4beb02460347e05a0a28e8460a45c9ae9bb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:error.txt.twig"));

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
        
        $__internal_a3143c1387000048c194aad0ba25a4beb02460347e05a0a28e8460a45c9ae9bb->leave($__internal_a3143c1387000048c194aad0ba25a4beb02460347e05a0a28e8460a45c9ae9bb_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.txt.twig";
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

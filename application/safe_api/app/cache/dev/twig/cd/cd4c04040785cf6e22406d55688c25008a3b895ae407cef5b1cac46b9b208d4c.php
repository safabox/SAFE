<?php

/* NelmioApiDocBundle::resource.html.twig */
class __TwigTemplate_7c9bcdb1bd561bc8d2f89c80f5b6e27ca9aa13b45fdfcb837c333052d73dfc85 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("NelmioApiDocBundle::layout.html.twig", "NelmioApiDocBundle::resource.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "NelmioApiDocBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_4af064cab6649981d08f14ccfb454b8d0100db5c3f65193d29996b2331c0f447 = $this->env->getExtension("native_profiler");
        $__internal_4af064cab6649981d08f14ccfb454b8d0100db5c3f65193d29996b2331c0f447->enter($__internal_4af064cab6649981d08f14ccfb454b8d0100db5c3f65193d29996b2331c0f447_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "NelmioApiDocBundle::resource.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_4af064cab6649981d08f14ccfb454b8d0100db5c3f65193d29996b2331c0f447->leave($__internal_4af064cab6649981d08f14ccfb454b8d0100db5c3f65193d29996b2331c0f447_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_52a3f2ede1d452149913360d2a598ce38772ed4cdf2c184fa73798ae7c30a231 = $this->env->getExtension("native_profiler");
        $__internal_52a3f2ede1d452149913360d2a598ce38772ed4cdf2c184fa73798ae7c30a231->enter($__internal_52a3f2ede1d452149913360d2a598ce38772ed4cdf2c184fa73798ae7c30a231_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <li class=\"resource\">
        <ul class=\"endpoints\">
            <li class=\"endpoint\">
                <ul class=\"operations\">
                    ";
        // line 8
        $this->loadTemplate("NelmioApiDocBundle::method.html.twig", "NelmioApiDocBundle::resource.html.twig", 8)->display($context);
        // line 9
        echo "                </ul>
            </li>
        </ul>
    </li>
";
        
        $__internal_52a3f2ede1d452149913360d2a598ce38772ed4cdf2c184fa73798ae7c30a231->leave($__internal_52a3f2ede1d452149913360d2a598ce38772ed4cdf2c184fa73798ae7c30a231_prof);

    }

    public function getTemplateName()
    {
        return "NelmioApiDocBundle::resource.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 9,  46 => 8,  40 => 4,  34 => 3,  11 => 1,);
    }
}
/* {% extends "NelmioApiDocBundle::layout.html.twig" %}*/
/* */
/* {% block content %}*/
/*     <li class="resource">*/
/*         <ul class="endpoints">*/
/*             <li class="endpoint">*/
/*                 <ul class="operations">*/
/*                     {% include 'NelmioApiDocBundle::method.html.twig' %}*/
/*                 </ul>*/
/*             </li>*/
/*         </ul>*/
/*     </li>*/
/* {% endblock content %}*/
/* */

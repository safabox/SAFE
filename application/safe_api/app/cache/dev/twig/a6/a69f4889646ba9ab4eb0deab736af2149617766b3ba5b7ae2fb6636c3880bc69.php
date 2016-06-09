<?php

/* @NelmioApiDoc/resource.html.twig */
class __TwigTemplate_0561edd530ce9c72a19987c685b272beae1968d64eca02c580a5da19f95f5f8f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("NelmioApiDocBundle::layout.html.twig", "@NelmioApiDoc/resource.html.twig", 1);
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
        $__internal_2231f28cf4d1ebe394e645ef7b822619a25f872433338a155b33f99f7f70f735 = $this->env->getExtension("native_profiler");
        $__internal_2231f28cf4d1ebe394e645ef7b822619a25f872433338a155b33f99f7f70f735->enter($__internal_2231f28cf4d1ebe394e645ef7b822619a25f872433338a155b33f99f7f70f735_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@NelmioApiDoc/resource.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_2231f28cf4d1ebe394e645ef7b822619a25f872433338a155b33f99f7f70f735->leave($__internal_2231f28cf4d1ebe394e645ef7b822619a25f872433338a155b33f99f7f70f735_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_5625ff901979b64e7e554c1654c7c2d03c124f38f7e3c875218838db791b0464 = $this->env->getExtension("native_profiler");
        $__internal_5625ff901979b64e7e554c1654c7c2d03c124f38f7e3c875218838db791b0464->enter($__internal_5625ff901979b64e7e554c1654c7c2d03c124f38f7e3c875218838db791b0464_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <li class=\"resource\">
        <ul class=\"endpoints\">
            <li class=\"endpoint\">
                <ul class=\"operations\">
                    ";
        // line 8
        $this->loadTemplate("NelmioApiDocBundle::method.html.twig", "@NelmioApiDoc/resource.html.twig", 8)->display($context);
        // line 9
        echo "                </ul>
            </li>
        </ul>
    </li>
";
        
        $__internal_5625ff901979b64e7e554c1654c7c2d03c124f38f7e3c875218838db791b0464->leave($__internal_5625ff901979b64e7e554c1654c7c2d03c124f38f7e3c875218838db791b0464_prof);

    }

    public function getTemplateName()
    {
        return "@NelmioApiDoc/resource.html.twig";
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

<?php

/* @WebProfiler/Profiler/toolbar_redirect.html.twig */
class __TwigTemplate_57053265c6dea7e13596da8e59a5c1e7a0a98f254a2672ade99a8be6966656fa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@WebProfiler/Profiler/toolbar_redirect.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_bf0b0070748a0335fd4ebed71d95dcddde1cafa46bd14923b39cb9cd33b4c546 = $this->env->getExtension("native_profiler");
        $__internal_bf0b0070748a0335fd4ebed71d95dcddde1cafa46bd14923b39cb9cd33b4c546->enter($__internal_bf0b0070748a0335fd4ebed71d95dcddde1cafa46bd14923b39cb9cd33b4c546_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Profiler/toolbar_redirect.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_bf0b0070748a0335fd4ebed71d95dcddde1cafa46bd14923b39cb9cd33b4c546->leave($__internal_bf0b0070748a0335fd4ebed71d95dcddde1cafa46bd14923b39cb9cd33b4c546_prof);

    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $__internal_e7907e983efa5eb041e1d3d4bf537cfef72966133dd0a8565a6c75d6fc475a0f = $this->env->getExtension("native_profiler");
        $__internal_e7907e983efa5eb041e1d3d4bf537cfef72966133dd0a8565a6c75d6fc475a0f->enter($__internal_e7907e983efa5eb041e1d3d4bf537cfef72966133dd0a8565a6c75d6fc475a0f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Redirection Intercepted";
        
        $__internal_e7907e983efa5eb041e1d3d4bf537cfef72966133dd0a8565a6c75d6fc475a0f->leave($__internal_e7907e983efa5eb041e1d3d4bf537cfef72966133dd0a8565a6c75d6fc475a0f_prof);

    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        $__internal_550fbf647b62e305f43c63fbfdfe304372d860ece6dcc89186dab6d678f606ab = $this->env->getExtension("native_profiler");
        $__internal_550fbf647b62e305f43c63fbfdfe304372d860ece6dcc89186dab6d678f606ab->enter($__internal_550fbf647b62e305f43c63fbfdfe304372d860ece6dcc89186dab6d678f606ab_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "    <div class=\"sf-reset\">
        <div class=\"block-exception\">
            <h1>This request redirects to <a href=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["location"]) ? $context["location"] : $this->getContext($context, "location")), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, (isset($context["location"]) ? $context["location"] : $this->getContext($context, "location")), "html", null, true);
        echo "</a>.</h1>

            <p>
                <small>
                    The redirect was intercepted by the web debug toolbar to help debugging.
                    For more information, see the \"intercept-redirects\" option of the Profiler.
                </small>
            </p>
        </div>
    </div>
";
        
        $__internal_550fbf647b62e305f43c63fbfdfe304372d860ece6dcc89186dab6d678f606ab->leave($__internal_550fbf647b62e305f43c63fbfdfe304372d860ece6dcc89186dab6d678f606ab_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Profiler/toolbar_redirect.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 8,  53 => 6,  47 => 5,  35 => 3,  11 => 1,);
    }
}
/* {% extends '@Twig/layout.html.twig' %}*/
/* */
/* {% block title 'Redirection Intercepted' %}*/
/* */
/* {% block body %}*/
/*     <div class="sf-reset">*/
/*         <div class="block-exception">*/
/*             <h1>This request redirects to <a href="{{ location }}">{{ location }}</a>.</h1>*/
/* */
/*             <p>*/
/*                 <small>*/
/*                     The redirect was intercepted by the web debug toolbar to help debugging.*/
/*                     For more information, see the "intercept-redirects" option of the Profiler.*/
/*                 </small>*/
/*             </p>*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* */

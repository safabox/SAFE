<?php

/* WebProfilerBundle:Profiler:toolbar_redirect.html.twig */
class __TwigTemplate_6bcfc477e9b1c42a0b398647287b6e2af237c99ce5ff272d7df02176ba2b450e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "WebProfilerBundle:Profiler:toolbar_redirect.html.twig", 1);
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
        $__internal_97a16381a4eef36f8901479342f4d539ca915c0462f0dcf68029ac763b2e749c = $this->env->getExtension("native_profiler");
        $__internal_97a16381a4eef36f8901479342f4d539ca915c0462f0dcf68029ac763b2e749c->enter($__internal_97a16381a4eef36f8901479342f4d539ca915c0462f0dcf68029ac763b2e749c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "WebProfilerBundle:Profiler:toolbar_redirect.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_97a16381a4eef36f8901479342f4d539ca915c0462f0dcf68029ac763b2e749c->leave($__internal_97a16381a4eef36f8901479342f4d539ca915c0462f0dcf68029ac763b2e749c_prof);

    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $__internal_c4a1d14f136bda6b7350347f3a47cfdb3f062bbc3182208f475bd090775f158b = $this->env->getExtension("native_profiler");
        $__internal_c4a1d14f136bda6b7350347f3a47cfdb3f062bbc3182208f475bd090775f158b->enter($__internal_c4a1d14f136bda6b7350347f3a47cfdb3f062bbc3182208f475bd090775f158b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Redirection Intercepted";
        
        $__internal_c4a1d14f136bda6b7350347f3a47cfdb3f062bbc3182208f475bd090775f158b->leave($__internal_c4a1d14f136bda6b7350347f3a47cfdb3f062bbc3182208f475bd090775f158b_prof);

    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        $__internal_427584a0549151edf07671b9b8e7c69c25716ab718fe0d670045f1dc90e4b16d = $this->env->getExtension("native_profiler");
        $__internal_427584a0549151edf07671b9b8e7c69c25716ab718fe0d670045f1dc90e4b16d->enter($__internal_427584a0549151edf07671b9b8e7c69c25716ab718fe0d670045f1dc90e4b16d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

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
        
        $__internal_427584a0549151edf07671b9b8e7c69c25716ab718fe0d670045f1dc90e4b16d->leave($__internal_427584a0549151edf07671b9b8e7c69c25716ab718fe0d670045f1dc90e4b16d_prof);

    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Profiler:toolbar_redirect.html.twig";
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

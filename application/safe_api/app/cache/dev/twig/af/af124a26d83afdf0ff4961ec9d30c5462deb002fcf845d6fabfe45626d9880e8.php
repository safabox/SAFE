<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_8611d0f146d1f6471522e2d0fa520dfc8f1f558e3726d8298e28b92a60ba82db extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
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
        $__internal_dd81ea6e43f1432af7d8bcb8803f1d1a1f3d73f3ea935657665b444c5beaf159 = $this->env->getExtension("native_profiler");
        $__internal_dd81ea6e43f1432af7d8bcb8803f1d1a1f3d73f3ea935657665b444c5beaf159->enter($__internal_dd81ea6e43f1432af7d8bcb8803f1d1a1f3d73f3ea935657665b444c5beaf159_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_dd81ea6e43f1432af7d8bcb8803f1d1a1f3d73f3ea935657665b444c5beaf159->leave($__internal_dd81ea6e43f1432af7d8bcb8803f1d1a1f3d73f3ea935657665b444c5beaf159_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_9bff48f77a07583cf35413d1ce4eb6357d611d5a86174513017db3418cf411b9 = $this->env->getExtension("native_profiler");
        $__internal_9bff48f77a07583cf35413d1ce4eb6357d611d5a86174513017db3418cf411b9->enter($__internal_9bff48f77a07583cf35413d1ce4eb6357d611d5a86174513017db3418cf411b9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_9bff48f77a07583cf35413d1ce4eb6357d611d5a86174513017db3418cf411b9->leave($__internal_9bff48f77a07583cf35413d1ce4eb6357d611d5a86174513017db3418cf411b9_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_4b31566b12eb1e7c87daff1ee511c72b9bdd231eb588fb3bbde9c6ec25f1ed5d = $this->env->getExtension("native_profiler");
        $__internal_4b31566b12eb1e7c87daff1ee511c72b9bdd231eb588fb3bbde9c6ec25f1ed5d->enter($__internal_4b31566b12eb1e7c87daff1ee511c72b9bdd231eb588fb3bbde9c6ec25f1ed5d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_4b31566b12eb1e7c87daff1ee511c72b9bdd231eb588fb3bbde9c6ec25f1ed5d->leave($__internal_4b31566b12eb1e7c87daff1ee511c72b9bdd231eb588fb3bbde9c6ec25f1ed5d_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_3766d9c70096398b65f5d8cc8dff7d2b1e04b934ef70bf9a7be63a9156d3f6be = $this->env->getExtension("native_profiler");
        $__internal_3766d9c70096398b65f5d8cc8dff7d2b1e04b934ef70bf9a7be63a9156d3f6be->enter($__internal_3766d9c70096398b65f5d8cc8dff7d2b1e04b934ef70bf9a7be63a9156d3f6be_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_3766d9c70096398b65f5d8cc8dff7d2b1e04b934ef70bf9a7be63a9156d3f6be->leave($__internal_3766d9c70096398b65f5d8cc8dff7d2b1e04b934ef70bf9a7be63a9156d3f6be_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@Twig/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include '@Twig/Exception/exception.html.twig' %}*/
/* {% endblock %}*/
/* */

<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_fd72cd0c082bde7541ca034fa0d90a05394c917c8308fa3b52a3e03cc76d5c0a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@Twig/Exception/exception_full.html.twig", 1);
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
        $__internal_1c92d2e2bd6aa02de32e899055df75702a301bba7dd2a8ec39c51c4c74da602b = $this->env->getExtension("native_profiler");
        $__internal_1c92d2e2bd6aa02de32e899055df75702a301bba7dd2a8ec39c51c4c74da602b->enter($__internal_1c92d2e2bd6aa02de32e899055df75702a301bba7dd2a8ec39c51c4c74da602b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_1c92d2e2bd6aa02de32e899055df75702a301bba7dd2a8ec39c51c4c74da602b->leave($__internal_1c92d2e2bd6aa02de32e899055df75702a301bba7dd2a8ec39c51c4c74da602b_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_d98f4c80f36eddfa0352d03e768ac3102a38cb452a107c41634d61d2c3e41bd1 = $this->env->getExtension("native_profiler");
        $__internal_d98f4c80f36eddfa0352d03e768ac3102a38cb452a107c41634d61d2c3e41bd1->enter($__internal_d98f4c80f36eddfa0352d03e768ac3102a38cb452a107c41634d61d2c3e41bd1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_d98f4c80f36eddfa0352d03e768ac3102a38cb452a107c41634d61d2c3e41bd1->leave($__internal_d98f4c80f36eddfa0352d03e768ac3102a38cb452a107c41634d61d2c3e41bd1_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_5a8d8b3e9b434e44840ebf4dea9598bbdec21c469309247859908f0a10de8fd7 = $this->env->getExtension("native_profiler");
        $__internal_5a8d8b3e9b434e44840ebf4dea9598bbdec21c469309247859908f0a10de8fd7->enter($__internal_5a8d8b3e9b434e44840ebf4dea9598bbdec21c469309247859908f0a10de8fd7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_5a8d8b3e9b434e44840ebf4dea9598bbdec21c469309247859908f0a10de8fd7->leave($__internal_5a8d8b3e9b434e44840ebf4dea9598bbdec21c469309247859908f0a10de8fd7_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_cb9810884f0c2b6a6cad387938f617784bc98e34b88388f585c4123c81372a11 = $this->env->getExtension("native_profiler");
        $__internal_cb9810884f0c2b6a6cad387938f617784bc98e34b88388f585c4123c81372a11->enter($__internal_cb9810884f0c2b6a6cad387938f617784bc98e34b88388f585c4123c81372a11_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_cb9810884f0c2b6a6cad387938f617784bc98e34b88388f585c4123c81372a11->leave($__internal_cb9810884f0c2b6a6cad387938f617784bc98e34b88388f585c4123c81372a11_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception_full.html.twig";
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

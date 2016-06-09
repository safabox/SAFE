<?php

/* base.html.twig */
class __TwigTemplate_c7699b4e81c1a191b6106b0e8e26ad62919e03a259db657224c94be633a260bc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_dc1eda5fe5c9dbd474c18114edbe579eb99c43b2576d8b97c1be841c67726213 = $this->env->getExtension("native_profiler");
        $__internal_dc1eda5fe5c9dbd474c18114edbe579eb99c43b2576d8b97c1be841c67726213->enter($__internal_dc1eda5fe5c9dbd474c18114edbe579eb99c43b2576d8b97c1be841c67726213_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 10
        $this->displayBlock('body', $context, $blocks);
        // line 11
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 12
        echo "    </body>
</html>
";
        
        $__internal_dc1eda5fe5c9dbd474c18114edbe579eb99c43b2576d8b97c1be841c67726213->leave($__internal_dc1eda5fe5c9dbd474c18114edbe579eb99c43b2576d8b97c1be841c67726213_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_61c5551e5019df6721eddc366b497290c86f55081f8e292c1c462fc88ea99af9 = $this->env->getExtension("native_profiler");
        $__internal_61c5551e5019df6721eddc366b497290c86f55081f8e292c1c462fc88ea99af9->enter($__internal_61c5551e5019df6721eddc366b497290c86f55081f8e292c1c462fc88ea99af9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_61c5551e5019df6721eddc366b497290c86f55081f8e292c1c462fc88ea99af9->leave($__internal_61c5551e5019df6721eddc366b497290c86f55081f8e292c1c462fc88ea99af9_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_1cee8984db4ab9d02d9f93f9663a8114d448bfd32eae15568438d330d305870a = $this->env->getExtension("native_profiler");
        $__internal_1cee8984db4ab9d02d9f93f9663a8114d448bfd32eae15568438d330d305870a->enter($__internal_1cee8984db4ab9d02d9f93f9663a8114d448bfd32eae15568438d330d305870a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_1cee8984db4ab9d02d9f93f9663a8114d448bfd32eae15568438d330d305870a->leave($__internal_1cee8984db4ab9d02d9f93f9663a8114d448bfd32eae15568438d330d305870a_prof);

    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        $__internal_e0fc9f1fdc8accf821433d8d5cec682a56c5c4fc85953ea7e9fd093125f8f532 = $this->env->getExtension("native_profiler");
        $__internal_e0fc9f1fdc8accf821433d8d5cec682a56c5c4fc85953ea7e9fd093125f8f532->enter($__internal_e0fc9f1fdc8accf821433d8d5cec682a56c5c4fc85953ea7e9fd093125f8f532_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_e0fc9f1fdc8accf821433d8d5cec682a56c5c4fc85953ea7e9fd093125f8f532->leave($__internal_e0fc9f1fdc8accf821433d8d5cec682a56c5c4fc85953ea7e9fd093125f8f532_prof);

    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_ba2bcff3a3e16a00392afc6aa93d27b96df08ce682946eeee8c4516ccf65f2dc = $this->env->getExtension("native_profiler");
        $__internal_ba2bcff3a3e16a00392afc6aa93d27b96df08ce682946eeee8c4516ccf65f2dc->enter($__internal_ba2bcff3a3e16a00392afc6aa93d27b96df08ce682946eeee8c4516ccf65f2dc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_ba2bcff3a3e16a00392afc6aa93d27b96df08ce682946eeee8c4516ccf65f2dc->leave($__internal_ba2bcff3a3e16a00392afc6aa93d27b96df08ce682946eeee8c4516ccf65f2dc_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 11,  82 => 10,  71 => 6,  59 => 5,  50 => 12,  47 => 11,  45 => 10,  38 => 7,  36 => 6,  32 => 5,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <title>{% block title %}Welcome!{% endblock %}</title>*/
/*         {% block stylesheets %}{% endblock %}*/
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/*     </head>*/
/*     <body>*/
/*         {% block body %}{% endblock %}*/
/*         {% block javascripts %}{% endblock %}*/
/*     </body>*/
/* </html>*/
/* */

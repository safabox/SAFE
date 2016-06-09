<?php

/* ::base.html.twig */
class __TwigTemplate_f4960f8ee55af4d2b162b2e7ba79b51ff148a495d603cbf3b8bb07fb98b2eba8 extends Twig_Template
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
        $__internal_61f252080c57cae3302e3447766d9ed782d71c769cc6119e81dce5b54ae2f0f1 = $this->env->getExtension("native_profiler");
        $__internal_61f252080c57cae3302e3447766d9ed782d71c769cc6119e81dce5b54ae2f0f1->enter($__internal_61f252080c57cae3302e3447766d9ed782d71c769cc6119e81dce5b54ae2f0f1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::base.html.twig"));

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
        
        $__internal_61f252080c57cae3302e3447766d9ed782d71c769cc6119e81dce5b54ae2f0f1->leave($__internal_61f252080c57cae3302e3447766d9ed782d71c769cc6119e81dce5b54ae2f0f1_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_688b8adec63faa47ef0708cae588e158d5c6077f6d6dd967eeda26d9b39256ad = $this->env->getExtension("native_profiler");
        $__internal_688b8adec63faa47ef0708cae588e158d5c6077f6d6dd967eeda26d9b39256ad->enter($__internal_688b8adec63faa47ef0708cae588e158d5c6077f6d6dd967eeda26d9b39256ad_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_688b8adec63faa47ef0708cae588e158d5c6077f6d6dd967eeda26d9b39256ad->leave($__internal_688b8adec63faa47ef0708cae588e158d5c6077f6d6dd967eeda26d9b39256ad_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_b0fdfe772a2abbe42fdba5fc9414c5f43e0287d392c2b87ae4c2bb1700234baf = $this->env->getExtension("native_profiler");
        $__internal_b0fdfe772a2abbe42fdba5fc9414c5f43e0287d392c2b87ae4c2bb1700234baf->enter($__internal_b0fdfe772a2abbe42fdba5fc9414c5f43e0287d392c2b87ae4c2bb1700234baf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_b0fdfe772a2abbe42fdba5fc9414c5f43e0287d392c2b87ae4c2bb1700234baf->leave($__internal_b0fdfe772a2abbe42fdba5fc9414c5f43e0287d392c2b87ae4c2bb1700234baf_prof);

    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        $__internal_fd35616e005bb1bbb65cb2801aedb98b4ce3cc40b39c2dd3f378c0915d35d76c = $this->env->getExtension("native_profiler");
        $__internal_fd35616e005bb1bbb65cb2801aedb98b4ce3cc40b39c2dd3f378c0915d35d76c->enter($__internal_fd35616e005bb1bbb65cb2801aedb98b4ce3cc40b39c2dd3f378c0915d35d76c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_fd35616e005bb1bbb65cb2801aedb98b4ce3cc40b39c2dd3f378c0915d35d76c->leave($__internal_fd35616e005bb1bbb65cb2801aedb98b4ce3cc40b39c2dd3f378c0915d35d76c_prof);

    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_3386c3c1f2a266730853af3bfc23b9e2c5d6abe73392e75055bf9d594c15d3b9 = $this->env->getExtension("native_profiler");
        $__internal_3386c3c1f2a266730853af3bfc23b9e2c5d6abe73392e75055bf9d594c15d3b9->enter($__internal_3386c3c1f2a266730853af3bfc23b9e2c5d6abe73392e75055bf9d594c15d3b9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_3386c3c1f2a266730853af3bfc23b9e2c5d6abe73392e75055bf9d594c15d3b9->leave($__internal_3386c3c1f2a266730853af3bfc23b9e2c5d6abe73392e75055bf9d594c15d3b9_prof);

    }

    public function getTemplateName()
    {
        return "::base.html.twig";
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

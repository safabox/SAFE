<?php

/* WebProfilerBundle:Profiler:ajax_layout.html.twig */
class __TwigTemplate_39980fb95c0cb2c0166822b176f5b1bf8ad23a6a59610b89d19887e555c9ba03 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_4da117aef642310788a840cdd729498b8e279de153088d6d1dc80daee4fbe960 = $this->env->getExtension("native_profiler");
        $__internal_4da117aef642310788a840cdd729498b8e279de153088d6d1dc80daee4fbe960->enter($__internal_4da117aef642310788a840cdd729498b8e279de153088d6d1dc80daee4fbe960_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "WebProfilerBundle:Profiler:ajax_layout.html.twig"));

        // line 1
        $this->displayBlock('panel', $context, $blocks);
        
        $__internal_4da117aef642310788a840cdd729498b8e279de153088d6d1dc80daee4fbe960->leave($__internal_4da117aef642310788a840cdd729498b8e279de153088d6d1dc80daee4fbe960_prof);

    }

    public function block_panel($context, array $blocks = array())
    {
        $__internal_e0a7e5153c825bb000f3976d813a3bda6c445caa621a8a367f09a81b0c531d45 = $this->env->getExtension("native_profiler");
        $__internal_e0a7e5153c825bb000f3976d813a3bda6c445caa621a8a367f09a81b0c531d45->enter($__internal_e0a7e5153c825bb000f3976d813a3bda6c445caa621a8a367f09a81b0c531d45_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        echo "";
        
        $__internal_e0a7e5153c825bb000f3976d813a3bda6c445caa621a8a367f09a81b0c531d45->leave($__internal_e0a7e5153c825bb000f3976d813a3bda6c445caa621a8a367f09a81b0c531d45_prof);

    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Profiler:ajax_layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  23 => 1,);
    }
}
/* {% block panel '' %}*/
/* */
